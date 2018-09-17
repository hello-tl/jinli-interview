<?php
/**
 * Created by PhpStorm.
 * User: mr tianlong
 * Email: 13343000479@163.com
 * phone: 13343000479 / 17342075152
 * Date: 2018/9/14
 * Time: 13:16
 */

if (!defined('IS_ENTRANCE')){
    exit('哥们别搞笑!!!');
}


# ========================================
# 系统工具类
# ========================================



# =========================================
# print_r 封装
# =========================================
if (!function_exists('p')){
    function p($data){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
# =========================================
# print_r 结束
# =========================================


# =========================================
# var_dump 封装
# =========================================
if (!function_exists('d')){
    function d($data){
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}
# =========================================
# var_dump 结束
# =========================================



# =========================================
# 是否高于你提供的php版本号
# =========================================
if ( ! function_exists('is_php'))
{
    /**
     * 确定当前版本的PHP是否等于或大于提供的值
     * @param	string
     * @return	bool	如果当前版本是$version或更高版本，则为真
     */
    function is_php($version){
        static $_is_php;
        $version = (string) $version;

        if ( ! isset($_is_php[$version]))
        {
            $_is_php[$version] = version_compare(PHP_VERSION, $version, '>=');
        }

        return $_is_php[$version];
    }
}
# =========================================
# 是否高于你提供的php版本号 结束
# =========================================



# =========================================
# get post 函数
# =========================================
if (!function_exists('request')) {
    /**
     * 获取当前Request对象实例
     * @return Request
     */
    function request(){
        require_once SYSTEM_PATH . "Request.php";
        return new \system\Request();
    }
}
# =========================================
# get post 结束
# =========================================