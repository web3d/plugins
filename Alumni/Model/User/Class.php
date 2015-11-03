<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

/**
 * 用户加入的
 */
class Alumni_Model_User_Class extends Alumni_Base_Model {
    
    protected $table = 'alumni_user_class';
    protected $pk = 'id';
    
    public function fetchAllByUser($uid, $fields = '*', $pageIndex = 1, $pageSize = 10, $filter = null) {
        return $this->fetchAll(array('uid' => $uid), $fields, $pageIndex, $pageSize, $filter);
    }
    
    public function countByUser($uid) {
        return $this->count(array('uid' => $uid));
    }
    
    public function fetchAllByClass($classId, $fields = '*', $pageIndex = 1, $pageSize = 10, $filter = null) {
        return $this->fetchAll(array('class_id' => $classId), $fields, $pageIndex, $pageSize, $filter);
    }
    
    public function countByClass($classId) {
        return $this->count(array('class_id' => $classId));
    }
    
    /**
     * 判断用户是否已加入班级
     * @param int $uid
     * @param int $classId
     * @return boolean
     */
    public function hasJoined($uid, $classId) {
        $row = $this->count(array('uid' => $uid, 'class_id' => $classId));
        return $row ? true : false;
    }
    
    /**
     * 用户申请加入
     * @param int $uid
     * @param int $classId
     * @param boolean $passed
     * @return int
     */
    public function join($uid, $classId, $passed = false) {
        $data = array(
            'uid' => $uid,
            'class_id' => $classId,
            'is_auditing' => $passed ? 1 : 0,
            'join_time' => Alumni_Base_Helper::datetime()
        );
        
        return $this->insert($data);
    }
    
    /**
     * 设置通过加入或拒绝
     * @param int $id
     * @param boolean $passed
     * @return boolean
     */
    public function passed($id, $passed = true) {
        return $this->update($id, array('is_auditing' => $passed ? 1 : 0));
    }
}