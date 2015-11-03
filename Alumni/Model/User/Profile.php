<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

/**
 * 用户资料
 */
class Alumni_Model_User_Profile extends Alumni_Base_Model {
    protected $table = 'alumni_user_profile';
    protected $pk = 'uid';
}