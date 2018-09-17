<?php
/**
 * Created by PhpStorm.
 * User: mr tainlong
 * Email: 13343000479@163.com
 * phone: 13343000479 / 17342075152
 * Date: 2018/9/15
 * Time: 14:33
 */

if (!defined('IS_ENTRANCE')){
    exit('哥们别搞笑!!!');
}

function encryptData($data){
    # 密钥文件的路径
    $privateKeyFilePath = PEM_PATH . 'login_rsa_private_key.pem';

    (file_exists($privateKeyFilePath)) or die('密钥或者公钥的文件路径不正确');

    # 生成Resource类型的密钥，如果密钥文件内容被破坏，openssl_pkey_get_private函数返回false
    $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyFilePath));


    ($privateKey) or die('密钥或者公钥不可用');

    # 加密以后的数据，用于在网路上传输
    $encryptData = '';
    ///////////////////////////////用私钥加密////////////////////////
    if (openssl_private_encrypt($data, $encryptData, $privateKey)){
        # 加密后 可以base64_encode后方便在网址中传输 或者打印  否则打印为乱码
        return base64_encode($encryptData);
    } else {
        echo "加密失败";
        exit;
    }
}

function decryptData($data){

    # 公钥文件的路径
    $publicKeyFilePath  = PEM_PATH . 'login_rsa_public_key.pem';
    extension_loaded('openssl') or die('php需要openssl扩展支持');

    (file_exists($publicKeyFilePath)) or die('密钥或者公钥的文件路径不正确');


    # 生成Resource类型的公钥，如果公钥文件内容被破坏，openssl_pkey_get_public函数返回false
    $publicKey = openssl_pkey_get_public(file_get_contents($publicKeyFilePath));

    ($publicKey) or die('密钥或者公钥不可用');


    # 解密以后的数据
    $decryptData ='';
    ///////////////////////////////用公钥解密////////////////////////
    if (openssl_public_decrypt(base64_decode($data), $decryptData, $publicKey)){
        # 解密后返回
        return $decryptData;
    } else {
        echo "解密失败";
        exit;
    }
}

# 登录使用
# param 只能是  private 或者 public
# private 加密
# public  解密
function openssl($param = null,$data = null){
    if(empty($param) || empty($data)){
        echo "两个参数都不能为空";
        exit;
    }
    if(!in_array($param,['private','public'])){
        echo "只能传 private 或者 public";
        exit;
    }
    if($param == 'private'){
        return encryptData($data);
    }else{
        return decryptData($data);
    }
}




