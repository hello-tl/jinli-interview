<?php
/**
 * Created by PhpStorm.
 * User: mr tainlong
 * Email: 13343000479@163.com
 * phone: 13343000479 / 17342075152
 * Date: 2018/9/14
 * Time: 11:19
 */

if (!defined('IS_ENTRANCE')) {
    exit('哥们别搞笑!!!');
}

# ============================================================
# 定义一些参数效验错误常量
# ============================================================

# 用户名验证   =    不能有特殊符号，不能有空格，不可为空，长度介于5-12个字符之间
define('USER_USERNAME_ERROR_001' ,'用户名错误');
define('USER_USERNAME_ERROR_002' ,'用户名不能为空');
define('USER_USERNAME_ERROR_003' ,'不能有特殊符号，不能有空格，不可为空，长度介于5-12个字符之间');
define('USER_KEY_ERROR_004' ,'key不能为空');
define('USER_VALUE_ERROR_005' ,'value不能为空');
define('USER_KEY_ERROR_006' ,'key不对称');
define('USER_VALUE_ERROR_007' ,'value不对称');
define('USER_USERNAME_ERROR_008' ,'用户名或密码错误');

# 密码验证     =    必须有大写字母，必须有特殊字符，长度介于6-16位之间
define('USER_PASSWORD_ERROR_011' ,'密码错误');
define('USER_PASSWORD_ERROR_012' ,'密码不能为空');
define('USER_PASSWORD_ERROR_013' ,'必须有大写字母，必须有特殊字符，长度介于6-16位之间');


define('COOKIE_CSRF_ERROR_020' ,'请求错误请重新发送请求');

define('LOGIN_OK' ,'登录成功');
