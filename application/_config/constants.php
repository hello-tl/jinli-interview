<?php
/**
 * Created by PhpStorm.
 * User: mr tianlong
 * Email: 13343000479@163.com
 * phone: 13343000479 / 17342075152
 * Date: 2018/9/14
 * Time: 11:14
 */

if (!defined('IS_ENTRANCE')) {
    exit('哥们别搞笑!!!');
}

# ============================================================
# 定义一些尝用的常量
# ============================================================

# 判断是否是post方法
define('IS_POST',strtolower($_SERVER["REQUEST_METHOD"]) == 'post');

# 判断是否是get方法
define('IS_GET' ,strtolower($_SERVER["REQUEST_METHOD"]) == 'get');

# 判断是否是ajax请求
define('IS_AJAX',isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');