<?php
/**
 * Created by PhpStorm.
 * User: mr tianlong
 * Email: 13343000479@163.com
 * Date: 2018/9/14
 * Time: 13:44
 */

if (!defined('IS_ENTRANCE')){
    exit('哥们别搞笑!!!');
}

class interview{
    public static function run(){
        self::controller();
    }

    public static function controller(){
        $controller = request()->get('c');
        if(!$controller){
            $controller = request()->post('c');
        }
        # 判断控制器是否传参  控制器操作
        if($controller){
            if(isFileValid($controller)){# 判断是否是一个正确的文件名
                // TODO 加入500日志
                echo "ERROR 500->" . CONTROLLERS_PATH . $controller . ".php  filename malformed";
                die;
            }
            if(is_file(CONTROLLERS_PATH . $controller . ".php")){           # 判断地址是否存在
                include_once CONTROLLERS_PATH . $controller . ".php";
            }else{                                                                  # 否则报错404
                // TODO 加入404日志
                echo "ERROR 404->" . CONTROLLERS_PATH . $controller . ".php  There is no";
                die;
            }
        }else{          # 使用默认值
            if(isFileValid(default_CONTROLLER)){# 判断是否是一个正确的文件名
                // TODO 加入500日志
                echo "ERROR 500->" . CONTROLLERS_PATH . default_CONTROLLER . ".php  filename malformed";
                die;
            }
            if(is_file(CONTROLLERS_PATH . default_CONTROLLER . ".php")){    # 判断默认控制器是否存在
                $controller = default_CONTROLLER;
                include_once CONTROLLERS_PATH . default_CONTROLLER . ".php";
            }else{                                                                   # 否则报错404
                // TODO 加入404日志
                echo "ERROR 404->" . CONTROLLERS_PATH . default_CONTROLLER . ".php  There is no";
                die;
            }
        }

        $obj = new $controller();

        $action = request()->get('a');
        if(!$action){
            $action = request()->post('a');
        }
        $methods = get_class_methods($obj);
        # 判断方法是否是空 方法操作
        if($action){
            if(isActionValid(default_CONTROLLER)){# 判断是否是一个正确的方法名
                // TODO 加入500日志
                echo "ERROR 500->" . default_ACTION . "  actionname malformed";
                die;
            }
            if(in_array($action,$methods)){
                $obj->$action();
            }else{
                // TODO 加入404日志
                echo "ERROR 404 controller::".$controller."->".$action."()  There is no";
                die;
            }
        }else{
            $action = default_ACTION;
            if(isActionValid($action)){# 判断是否是一个正确的方法名
                // TODO 加入500日志
                echo "ERROR 500->" . $action . "  actionname malformed";
                die;
            }
            if(in_array($action,$methods)){
                $obj->$action();
            }else{
                // TODO 加入404日志
                echo "ERROR 404 controller::".$controller."->".$action."()  There is no";
                die;
            }
        }
    }
}
