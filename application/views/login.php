<?php
/**
 * Created by PhpStorm.
 * User: mr tianlong
 * Email: 13343000479@163.com
 * phone: 13343000479 / 17342075152
 * Date: 2018/9/15
 * Time: 17:06
 */
?>
<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <title>Login</title>
    <title>登录页面</title>
    <link rel="stylesheet" href="http://interview-assets.hello-tl.com/twbs/bootstrap/dist/css/bootstrap.css" type="text/css" />

    <script src="http://interview-assets.hello-tl.com/components/jquery/jquery.js"></script>
    <script src="http://interview-assets.hello-tl.com/twbs/bootstrap/dist/js/bootstrap.js"></script>

    <script src="http://interview.hello-tl.com/js/RSA.js"></script>
    <script src="http://interview.hello-tl.com/js/BigInt.js"></script>
    <script src="http://interview.hello-tl.com/js/Barrett.js"></script>

</head>
<style>
    #container {
        min-height: 100vh;
        height: auto;
        position: relative;
        min-width: 290px;
        overflow: hidden;
    }
    .bg-img{
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        opacity: .8;
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    .cls-content {

        padding: 50px 15px 15px;
        padding-top: 50px;
        padding-top: 10vh;
        position: relative;

    }
    .panel .panel-footer, .panel > :last-child {

        border-bottom-left-radius: 2px;
        border-bottom-right-radius: 2px;

    }
    .panel .panel-heading, .panel > :first-child {

        border-top-left-radius: 2px;
        border-top-right-radius: 2px;

    }
    .panel-body {
        padding: 15px 20px 25px;
        background: aliceblue;
    }

    .pad-btm {

        padding-bottom: 15px;

    }
    .mar-ver {

        margin-top: 15px;
        margin-bottom: 15px;

    }
    h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {

        font-weight: 600;
        color: #4d627b;

    }
    .cls-container {

        text-align: center;

    }
    @media (min-width: 768px)
        .cls-content  .cls-content-sm {
            width: 150px;
        }
        .cls-content .cls-content-sm, .cls-content .cls-content-lg {
            margin: 0 auto;
            box-shadow: none;
            width: 70%;
            min-width: 270px;
            margin: 0 auto;
        }

</style>
<body>
    <div id="container" class="cls-container">
        <div class="bg-img" style="background-image: url(https://bossdev.hello-tl.com/boss/nifty-v2.9.1/get-started/img/bg-img-3.jpg);"></div>
        <div class="cls-content">
            <div class="cls-content-sm panel">
                <div class="panel-body">
                    <div class="mar-ver pad-btm">
                        <h1 class="h3">帐号登录</h1>
                        <p style="color: red;">登录到您的帐户</p>
                    </div>
                        <input name="secretKey" id="secretKey" value="" class="form-control" autocomplete="off" type="hidden">
                        <input name="secretValue" id="secretValue" value="" class="form-control" autocomplete="off" type="hidden">
                        <div class="form-group">
                            <input name="loginKey" id="loginKey" value="tianlong" class="form-control" placeholder="请输入用户名" autocomplete="off" type="text">
                        </div>
                        <div class="form-group">
                            <input name="loginExt" id="loginExt" value="123456" class="form-control" placeholder="请输入密码" autocomplete="off" type="password">
                        </div>
                        <button id="login" class="btn btn-primary btn-lg btn-block">登录</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    $(function(){

        $("#login").click(function(){
            $.ajax({
                url     : window.location.protocol + "//" + window.location.host + "?c=account&a=loginValid",
                type    : 'POST',
                dataType: 'json',
                data    : {
                    loginKey    : document.getElementById("loginKey").value,
                    loginExt    : document.getElementById("loginExt").value,
                    secretKey   : document.getElementById("secretKey").value,
                    secretValue : document.getElementById("secretValue").value
                },
                async   : true,
                cache   : true,
                dataType: 'json',
                success:function(res){
                    // 请求成功
                    if("登录成功" == res.msg){
                        window.location.href = window.location.protocol + "//" + window.location.host + "?c=account&a=show";
                    }else{
                        document.getElementsByTagName("p")[0].innerHTML = res.msg;
                    }
                },
                error:function(xhr,errorText,errorType){
                    console.log('错误');	         //自定义错误
                    console.log(errorText + ':' + errorType);
                }
            })
        });


        // 先去获取 secretKey secretValue
        $.ajax({
            type    : 'get',
            url     : window.location.protocol + "//" + window.location.host + "?c=account&a=getLoginSecret",
            async   : true,
            cache   : true,
            dataType: 'json',
            success:function(res){
                document.getElementById("secretKey").value = res.data['secretKey'];
                document.getElementById("secretValue").value = res.data['secretValue'];
            },
            error:function(xhr,errorText,errorType){
                console.log('错误');	                //自定义错误
                console.log(errorText + ':' + errorType);
            }
        });
    })
</script>



