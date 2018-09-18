<?php
/**
 * Created by PhpStorm.
 * User: mr tianlong
 * Email: 13343000479@163.com
 * phone: 13343000479 / 17342075152
 * Date: 2018/9/14
 * Time: 11:36
 */

if (!defined('IS_ENTRANCE')) {
    exit('哥们别搞笑!!!');
}
# ========================================
# 基本类
# ========================================



# ========================================
# 返回json格式数据
# ========================================
function showSuccess($data = "", $errCode = '0', $retCode = '0', $msg = ""){
    if($data == ""){
        $data = new stdClass;
    }
    echo json_encode(array('errCode' => $errCode,'retCode' => $retCode,'msg' => $msg,'data' => $data));
}
# ========================================
# 返回json格式数据
# ========================================



# ========================================
# 获取登录随机key
# ========================================
function getSecretKey() {
    mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
    $charid = strtoupper(md5(uniqid(rand(), true)));
    $hyphen = chr(45); // "-"
    $uuid = chr(123) // "{"
        . substr($charid, 0, 8) . $hyphen
        . substr($charid, 8, 4) . $hyphen
        . substr($charid, 12, 4) . $hyphen
        . substr($charid, 16, 4) . $hyphen
        . substr($charid, 20, 12)
        . chr(125); // "}"

    return md5($uuid);
}
# ========================================
# 获取登录随机key结束
# ========================================


function getSecretValue($secretKey, $salt = '7D6r5elGx3pgzsW4RjEBfiCTaliijaJWneNHrX9WB7g1dHErC4yKZ'){
    return md5(md5($secretKey) . $salt);
}


# ========================================
# 获取远程IP
# ========================================
function getRemoteIp(){
    //获取IP
    if (isset($_SERVER['HTTP_X_CLIENT_IP']) && !empty($_SERVER['HTTP_X_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_X_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $ipArr = explode(",", $ip);
        $ip = $ipArr[0];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
# ========================================
# 获取远程IP结束
# ========================================


# ========================================
# xss过滤函数
# @param string $str 待过滤的文本
# @return string
# ========================================
function removeXSS($val) {
    # 删除所有不可打印的字符。允许使用CR(0a)、LF(0b)和TAB(9)
    # 这可以防止一些字符重新间隔，例如
    # 注意，您必须在以后处理\n、\r和\t的拆分，因为它们在某些输入中是允许的
    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

    # 直接替换，用户不应该需要这些，因为它们是正常字符
    # 这可以防止像 <IMG SRC=@avascript:alert('XSS')>
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '<>~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        # ;?匹配;，这是可选的
        # 0{0,7}匹配任何填充的零，这些零是可选的，最多8个字符

        # @ @ 搜索十六进制值
        $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val);
        # @ @ 0{0,7}匹配'0' 0到7次
        $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val);
    }

    # 现在剩下的空白攻击是\t、\n和\r
    $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true; # 继续替换，就像前一轮替换一样
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern .= '|';
                    $pattern .= '|(&#0{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); # 添加<>来减少标签
            $val = preg_replace($pattern, $replacement, $val); # 过滤掉十六进制标签
            if ($val_before == $val) {
                # 没有进行替换，因此退出循环
                $found = false;
            }
        }
    }
    return htmlspecialchars($val);
}

# ========================================
# xss过滤函数结束
# ========================================



# ========================================
# 校验身份证是否合法
# ========================================
function isCardNoValid($cardNo) {

    if (empty($cardNo)) {
        return false;
    }

    $cardNo = strtoupper($cardNo);
    $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
    $arr_split = array();
    if (!preg_match($regx, $cardNo)){
        return false;
    }if (15 == strlen($cardNo)){# 检查15位
        $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";

        @preg_match($regx, $cardNo, $arr_split);
        # 检查生日日期是否正确
        $dtm_birth = "19" . $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
        if (!strtotime($dtm_birth)) {
            return false;
        } else {
            return true;
        }
    } else{ # 检查18位
        $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
        @preg_match($regx, $cardNo, $arr_split);
        $dtm_birth = $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
        if (!strtotime($dtm_birth)){ # 检查生日日期是否正确
            return false;
        } else {
            # 检验18位身份证的校验码是否正确。
            # 校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
            $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
            $sign = 0;
            for ($i = 0; $i < 17; $i++) {
                $b = (int) $cardNo{$i};
                $w = $arr_int[$i];
                $sign += $b * $w;
            }
            $n = $sign % 11;
            $val_num = $arr_ch[$n];
            if ($val_num != substr($cardNo, 17, 1)) {
                return false;
            } else {
                return true;
            }
        }
    }
}
# ========================================
# 校验身份证是否合法结束
# ========================================


# ========================================
# 校验手机号是否合法
# ========================================
function isMobileValid($mobile) {

    if (empty($mobile)) {
        return false;
    }

    return preg_match("/^13[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}|$|15[0123567889]{1}[0-9]{8}$|18[0123567889]{1}[0-9]{8}$|14[57]{1}[0-9]{8}$/", $mobile);
}
# ========================================
# 校验手机号是否合法结束
# ========================================


# ========================================
# 校验用户名是否合法
# 不能有特殊符号，不能有空格，不可为空，长度介于5-12个字符之间
# ========================================
function isUserNameValid($userName) {

    if (empty($userName)) {
        return false;
    }
    return preg_match("/^[a-zA-Z0-9]{5,12}$/", $userName);
}
# ========================================
# 校验用户名是否合法结束
# ========================================


# ========================================
# 校验密码是否合法
# 必须有大写字母，必须有特殊字符，长度介于6-16位之间
# ========================================
function isPasswordValid($password) {
    if (empty($password)) {
        return false;
    }
    return false;
}
# ========================================
# 校验密码是否合法结束
# ========================================


# ========================================
# 效验文件名称
# ========================================
function isFileValid($file) {
    if (empty($file)) {
        return false;
    }
    # 稍后回来部位
}
# ========================================
# 效验文件名称结束
# ========================================


# ========================================
# 效验成员名称
# ========================================
function isActionValid($actionName) {
    if (empty($actionName)) {
        return false;
    }
    # 稍后回来部位
}
# ========================================
# 效验成员名称结束
# ========================================



