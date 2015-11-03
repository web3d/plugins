<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

/**
 * 用户相关 钩子处理
 */
class Alumni_Handler_User extends Typecho_Widget {
    
    public static function setUserOnline(Widget_User $user, $name, $password, $temporarily, $expire) {
        $service = new Alumni_Service_UserOnline;
        $service->set($user, Alumni_Model_User_Online::ACT_LOGIN);
    }
}