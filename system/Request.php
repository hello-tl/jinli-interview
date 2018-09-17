<?php
namespace system;
/**
 * Created by PhpStorm.
 * User: mr tianlong
 * Email: 13343000479@163.com
 * Date: 2018/9/14
 * Time: 14:40
 * 解刨 TP 5.0 Request类  主要post get接收参数
 */
class Request{


    # 全局过滤规则
    protected $filter;

    # 请求参数
    protected $param   = [];
    protected $get     = [];
    protected $post    = [];


    // php://input
    protected $input;


    # =============================================================
    # 设置获取GET参数
    # @access public
    # @param string|array  $name 变量名
    # @param mixed         $default 默认值
    # @param string|array  $filter 过滤方法
    # @return mixed
    # =============================================================
    public function get($name = '', $default = null, $filter = ''){
        if (empty($this->get)) {
            $this->get = $_GET;
        }
        if (is_array($name)) {
            $this->param      = [];
            return $this->get = array_merge($this->get, $name);
        }
        return $this->input($this->get, $name, $default, $filter);
    }

    # =============================================================
    # 设置获取POST参数
    # @access public
    # @param string        $name 变量名
    # @param mixed         $default 默认值
    # @param string|array  $filter 过滤方法
    # @return mixed
    # =============================================================
    public function post($name = '', $default = null, $filter = ''){
        if (empty($this->post)) {
            $content = $this->input;
            if (empty($_POST) && false !== strpos($this->contentType(), 'application/json')) {
                $this->post = (array) json_decode($content, true);
            } else {
                $this->post = $_POST;
            }
        }
        if (is_array($name)) {
            $this->param       = [];
            return $this->post = array_merge($this->post, $name);
        }
        return $this->input($this->post, $name, $default, $filter);
    }



    # =============================================================
    # 获取变量 支持过滤和默认值
    # @param array         $data 数据源
    # @param string|false  $name 字段名
    # @param mixed         $default 默认值
    # @param string|array  $filter 过滤函数
    # @return mixed
    # =============================================================
    public function input($data = [], $name = '', $default = null, $filter = ''){
        if (false === $name) {
            # 获取原始数据
            return $data;
        }
        $name = (string) $name;
        if ('' != $name) {
            # 解析name
            if (strpos($name, '/')) {
                list($name, $type) = explode('/', $name);
            } else {
                $type = 's';
            }
            # 按.拆分成多维数组进行判断
            foreach (explode('.', $name) as $val) {
                if (isset($data[$val])) {
                    $data = $data[$val];
                } else {
                    # 无输入数据，返回默认值
                    return $default;
                }
            }
            if (is_object($data)) {
                return $data;
            }
        }

        # 解析过滤器
        $filter = $this->getFilter($filter, $default);

        if (is_array($data)) {
            array_walk_recursive($data, [$this, 'filterValue'], $filter);
            reset($data);
        } else {
            $this->filterValue($data, $name, $filter);
        }

        if (isset($type) && $data !== $default) {
            # 强制类型转换
            $this->typeCast($data, $type);
        }
        return $data;
    }

    # 解析过滤器
    protected function getFilter($filter, $default)
    {
        if (is_null($filter)) {
            $filter = [];
        } else {
            $filter = $filter ?: $this->filter;
            if (is_string($filter) && false === strpos($filter, '/')) {
                $filter = explode(',', $filter);
            } else {
                $filter = (array) $filter;
            }
        }

        $filter[] = $default;
        return $filter;
    }

    # =============================================================
    # 递归过滤给定的值
    # @param mixed     $value 键值
    # @param mixed     $key 键名
    # @param array     $filters 过滤方法+默认值
    # @return mixed
    # =============================================================
    private function filterValue(&$value, $key, $filters){
        $default = array_pop($filters);
        foreach ($filters as $filter) {
            if (is_callable($filter)) {
                # 调用函数或者方法过滤
                $value = call_user_func($filter, $value);
            } elseif (is_scalar($value)) {
                if (false !== strpos($filter, '/')) {
                    # 正则过滤
                    if (!preg_match($filter, $value)) {
                        # 匹配不成功返回默认值
                        $value = $default;
                        break;
                    }
                } elseif (!empty($filter)) {
                    # filter函数不存在时, 则使用filter_var进行过滤
                    # filter为非整形值时, 调用filter_id取得过滤id
                    $value = filter_var($value, is_int($filter) ? $filter : filter_id($filter));
                    if (false === $value) {
                        $value = $default;
                        break;
                    }
                }
            }
        }
        return $this->filterExp($value);
    }

    # =============================================================
    # 过滤表单中的表达式
    # @param string $value
    # @return void
    # =============================================================
    public function filterExp(&$value)
    {
        // 过滤查询特殊字符
        if (is_string($value) && preg_match('/^(EXP|NEQ|GT|EGT|LT|ELT|OR|XOR|LIKE|NOTLIKE|NOT LIKE|NOT BETWEEN|NOTBETWEEN|BETWEEN|NOT EXISTS|NOTEXISTS|EXISTS|NOT NULL|NOTNULL|NULL|BETWEEN TIME|NOT BETWEEN TIME|NOTBETWEEN TIME|NOTIN|NOT IN|IN)$/i', $value)) {
            $value .= ' ';
        }
        // TODO 其他安全过滤
    }


    # =============================================================
    # 强制类型转换
    # @param string $data
    # @param string $type
    # @return mixed
    # =============================================================
    private function typeCast(&$data, $type){
        switch (strtolower($type)) {
            # 数组
            case 'a':
                $data = (array) $data;
                break;
            # 数字
            case 'd':
                $data = (int) $data;
                break;
            # 浮点
            case 'f':
                $data = (float) $data;
                break;
            # 布尔
            case 'b':
                $data = (boolean) $data;
                break;
            # 字符串
            case 's':
            default:
                if (is_scalar($data)) {
                    $data = (string) $data;
                } else {
                    'variable type error：' . gettype($data);
                    exit;
                }
        }
    }

    # =============================================================
    # 当前请求 HTTP_CONTENT_TYPE
    # @access public
    # @return string
    # =============================================================
    public function contentType(){
        $contentType = $this->server('CONTENT_TYPE');
        if ($contentType) {
            if (strpos($contentType, ';')) {
                list($type) = explode(';', $contentType);
            } else {
                $type = $contentType;
            }
            return trim($type);
        }
        return '';
    }

    # =============================================================
    # 获取server参数
    # @access public
    # @param string|array  $name 数据名称
    # @param string        $default 默认值
    # @param string|array  $filter 过滤方法
    # @return mixed
    # =============================================================
    public function server($name = '', $default = null, $filter = ''){
        if (empty($this->server)) {
            $this->server = $_SERVER;
        }
        if (is_array($name)) {
            return $this->server = array_merge($this->server, $name);
        }
        return $this->input($this->server, false === $name ? false : strtoupper($name), $default, $filter);
    }
}
