<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

/**
 * 用户在线记录
 */
class Alumni_Model_User_Online extends Alumni_Base_Model {
    protected $table = 'alumni_user_online';
    protected $pk = 'id';
    
    const ACT_LOGIN = 'login';
    const ACT_OTHER = 'other';
    
    /**
     * 插入一条用户在线记录
     * @param int $uid
     * @param string $username
     * @param string $loginTime
     * @param string $ip
     * @return int
     */
    public function add($uid, $username, $loginTime, $ip) {
        return $this->insert(array(
            'uid' => $uid,
            'username' => $username,
            'login_time' => $loginTime,
            'active_time' => $loginTime,
            'act' => self::ACT_LOGIN,
            'ip' => $ip
        ));
    }
    
    /**
     * 取出用户在线状态记录
     * @param int $uid
     * @return array
     */
    public function fetchByUser($uid) {
        return $this->fetch(array('uid' => $uid));
    }
}