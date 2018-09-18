<?php
/**
 * Created by PhpStorm.
 * User: mr tainlong
 * Email: 13343000479@163.com
 * phone: 13343000479 / 17342075152
 * Date: 2018/9/14
 * Time: 17:08
 */

# 简陋的登录页面以及信息页
# 登录采用非对称加密方法
if (!defined('IS_ENTRANCE')){
    exit('哥们别搞笑!!!');
}

class account{

    # 登录页面 时间问题没来得及做RSA 非对称加密 只写了一个csrf攻击
    public function loginValid(){

        $loginKey = request()->post('loginKey');            // 用户名
        $loginExt = request()->post('loginExt');            // 加密后的用户密码
        $loginSecretKet = request()->post('secretKey');     // key
        $loginSecretValue = request()->post('secretValue'); // value

        # 判断key是否为空
        if(empty($loginSecretKet)){
            showSuccess('','004','004',USER_KEY_ERROR_004);
            return;
        }

        # 判断key是否相同
        if($loginSecretKet != $_COOKIE['secretKey']){
            showSuccess('','006','006',USER_KEY_ERROR_006);
            return;
        }

        # 判断value是否为空
        if(empty($loginSecretValue)){
            showSuccess('','005','005',USER_VALUE_ERROR_005);
            return;
        }

        # 判断value是否相同
        if($loginSecretValue != $_COOKIE['secretValue']){
            showSuccess('','007','007',USER_VALUE_ERROR_007);
            return;
        }

        # 判断 _csrf 是否存在
        # 防止 _csrf 攻击
        if(!isset($_COOKIE['_csrf'])){
            showSuccess(['_csrf'=>$_COOKIE['_csrf']],'020','020',COOKIE_CSRF_ERROR_020);
            return;
        }

        # 判断非对称加密
        # 防止 _csrf 攻击
        if((openssl('public',$_COOKIE['_csrf']) != getSecretValue($loginSecretKet)) && (getSecretValue($loginSecretKet) == $loginSecretValue)){
            showSuccess(['_csrf'=>$_COOKIE['_csrf']],'020','020',COOKIE_CSRF_ERROR_020);
            return;
        }

        # 用户名是否为空
        if(empty($loginKey)){
            showSuccess('','002','002',USER_USERNAME_ERROR_002);
            return;
        }

        # 用户名表达式
        if(!isUserNameValid($loginKey)){
            showSuccess('','003','003',USER_USERNAME_ERROR_003);
            return;
        }

        # 判断用户是否正确
        if($loginKey != "tianlong"){
            showSuccess('','008','008',USER_USERNAME_ERROR_008);
            return;
        }

        # 密码是否为空
        if(empty($loginExt)){
            showSuccess('','012','012',USER_PASSWORD_ERROR_012);
            return;
        }

        # 密码表达式
        if(!isPasswordValid($loginExt)){
            showSuccess('','013','013',USER_PASSWORD_ERROR_013);
            return;
        }

        # 判断密码是否正确
        if($loginExt != "Tl-123456"){
            showSuccess('','008','008',USER_USERNAME_ERROR_008);
            return;
        }

        Session_start();
        $_SESSION['username'] = $loginKey;
        $_SESSION['password'] = $loginExt;

        showSuccess('','','',LOGIN_OK);
    }

    # 展示页
    public function show(){
        Session_start();
        // 判断是否在登录
        if(!isset($_SESSION['username']) || !isset($_SESSION['password'])){
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/index.php?c=account&a=login");
        }

        require_once VALUES_PATH . "show.php";
    }

    # 登录页面
    public function login(){
        require_once VALUES_PATH . "login.php";
    }

    # 获取登录随机key
    # 设置_csrf值
    public function getLoginSecret(){
        if(!IS_GET){
            showSuccess('','403','403','只允许get请求');
            return;
        }
        # 登录页面最多30分钟后   30分钟后提交不上去
        $data['secretKey'] = getSecretKey();
        $data['secretValue'] =getSecretValue($data['secretKey']);
        setcookie("secretKey",$data['secretKey'] , time()+1800);
        setcookie("secretValue", $data['secretValue'], time()+1800);
        setcookie("_csrf",openssl('private',$data['secretValue']) , time()+1800);
        showSuccess($data);
    }

}