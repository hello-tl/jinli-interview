<?php
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
# =============================================================================
# 简陋框架目录
# application--------项目目录
#   _config-----------------配置文件目录
#       basepage.php-------------------基础配置
#       constants.php------------------尝用的常量
#       database.php-------------------数据库配置
#       errorpage.php------------------错误配置
#       systemuser.php-----------------系统用户配置
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

extension_loaded('openssl') or die('php需要openssl扩展支持');

# 是否是入口
# 每个页面都必须要判断 IS_ENTRANCE 是否存在  记住是必须判断
define('IS_ENTRANCE', "yes");
# 引入composer
require_once __DIR__ . '/../../vendor/autoload.php';

# ============================================================
# 应用根目录
# ============================================================
define('APP_ROOT', dirname(dirname(__FILE__)));

# config配置目录
define('CONFIG_PATH', dirname(dirname(__FILE__)) . "/_config/");

# 系统文件配置目录
define('SYSTEM_PATH', dirname(dirname(dirname(__FILE__))) . "/system/");

# 控制器目录
define('CONTROLLERS_PATH', dirname(dirname(__FILE__)) . "/controllers/");

# 试图目录
define('VALUES_PATH', dirname(dirname(__FILE__)) . "/views/");

# helpers助手目录
define('HELPERS_PATH', dirname(dirname(__FILE__)) . "/_helpers/");

# pem目录路径
define('PEM_PATH', dirname(dirname(__FILE__)) . "/_pem/");

# ============================================================
# 目录设定结束
# ============================================================


# ============================================================
# 引入config中的配置文件
# ============================================================
# 引入常量设定文件
require_once CONFIG_PATH . 'constants.php';

# 引入基本配置
require_once CONFIG_PATH . 'basepage.php';

# 引入常量设定报错文件
require_once CONFIG_PATH . 'errorpage.php';

# 引入数据库配置
require_once CONFIG_PATH . 'database.php';

# ============================================================
# 引入config中的配置文件结束
# ============================================================


# ============================================================
// 合并配置
# ============================================================

$config = array_merge_recursive(
    $database
);
unset($database);

# ============================================================
// 合并配置结束
# ============================================================



# ============================================================
# 助手类引入
# ============================================================
# 基本类
require_once HELPERS_PATH . 'common_helpers.php';

# 系统工具类
require_once HELPERS_PATH . 'utils_helper.php';

# 系统工具类
require_once HELPERS_PATH . 'openssl_helpers.php';

if(!is_php('5.6')){
    echo "哥们咱们php版本稍微升级一下如何?";
}
# ============================================================
# 助手类引入结束
# ============================================================


# 框架启动入口文件
require_once SYSTEM_PATH . 'interview.php';
(new interview)::run();
