<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

/**
 * 用户在线状态相关操作
 */
class Alumni_Service_UserOnline extends Alumni_Base_Service {
    
    /**
     * 设置用户状态
     * @param Widget_User $user
     * @param string $action
     * @param string $location
     * @return boolean
     */
    public function set(Widget_User $user, $action = '', $location = ''){
        if ($user->uid < 1) {
            $this->setError(self::ERR_NEED_LOGIN, '未指定登录用户');
            return false;
        }
        
        $datetime = Alumni_Base_Helper::datetime();
        $model = new Alumni_Model_User_Online();
        $online = $model->fetchByUser($user->uid);
        if (!$online) {
            $result = $model->add($user->uid, $user->name, $datetime, Typecho_Request::getInstance()->getIp() . '');
        } else {
            $data = array('active_time' => $datetime, 'act' => $action, 'location' => $location);
            if ($action == Alumni_Model_User_Online::ACT_LOGIN) {
                $data['login_time'] = $datetime;
            }
            $result = $model->update($online['id'], $data);
        }
        
        return $result;
    }
}