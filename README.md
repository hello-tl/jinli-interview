<pre>
# =============================================================================
# 登录 username : tianlong   password : 123456
# 登录页面 http://interview.hello-tl.com/?c=account&a=login
# =============================================================================
/**
 * Created by PhpStorm.
 * User: mr tianlong
 * Email: 13343000479@163.com
 * phone: 13343000479 / 17342075152
 * Date: 2018/9/14
 * Time: 10:13
 *
 * 朴新教育集团 面试测试题 登录开始时间 2018/9/14
 *
 * 每一个伟大的思想都有一个微不足道的开始
 * #include <stdio.h>
 * int main(){
 *    printf("Hello, World! \n");
 *    return 0;
 * }
 *
 * 每一个PHP也有一个微不足道的开始
 * require_once __DIR__ . '/../../vendor/autoload.php';
 *
 * 人事小姐姐说 原声php 40 分钟做完正常
 * 我想我是做不完的只能来试试了
 *
 * 下面开始我的登录设计
 * 不知一下代码是否能得到大佬的赏识
 */
</pre>
<pre>
# =============================================================================
# 简陋框架目录
# application--------项目目录
#   _config-----------------配置文件目录
#       basepage.php-------------------基础配置
#       constants.php------------------尝用的常量
#       database.php-------------------数据库配置
#       errorpage.php------------------错误配置
#   _helpers----------------助手函数目录
#       common_helpers.php-------------基本函数封装
#       openssl_helpers.php------------openssl加解密
#       utils_helper.php---------------系统类封装
#   _logs-------------------日志文件目录
#       _nginx-------------------------nginx日志文件
#           host.access.log-------------------------日志文件
#           interview.hello-tl.com.conf-------------nginx配置文件
#       _nginx-------------------------php配置文件
#   _pem--------------------钥匙文件目录
#       login_rsa_private_key.pem------私钥
#       login_rsa_public_key.pem-------公钥
#   _webroot----------------入口文件目录
#       index.php----------------------入口文件
#   controllers-------------控制器目录
#   models------------------模型目录
#   views-------------------视图目录
# components---------composer下载依赖包js
# system-------------系统目录
#   interview---------------框架启动文件
#   Request.php-------------Request类
# vendor-------------composer下载依赖包php-js
# composer.json------composer json文件
# composer.lock------composer lock文件
# =============================================================================
</pre>