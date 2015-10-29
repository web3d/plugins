<?php
/**
 * 用户加入的
 */
class Alumni_Model_User_Class extends Alumni_Base_Model {
    
    protected $table = 'alumni_user_class';
    protected $pk = 'uid';
    
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
}