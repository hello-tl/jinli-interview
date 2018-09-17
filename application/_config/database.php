<?php
/**
 * Created by PhpStorm.
 * User: mr tainlong
 * Email: 13343000479@163.com
 * phone: 13343000479 / 17342075152
 * Date: 2018/9/14
 * Time: 10:19
 */

if (!defined('IS_ENTRANCE')) {
    exit('哥们别搞笑!!!');
}

# ============================================================
# 数据库配置文件
# mysql v 8.0.12
# ============================================================

$database = [
    'driver'    => 'mysql',
    'host'      => '39.104.112.65',
    'port'      => 3308,
    'database'  => 'interview',
    'username'  => 'root',
    'password'  => '19980202',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => 'interview_',
    'strict'    => false,
];
