<?php

/**
 * 用户班级相关操作
 */
class Alumni_Service_UserClass extends Alumni_Base_Service {
    
    /**
     * 用户申请加入
     * @param int $uid
     * @param int $classId
     * @return boolean
     */
    public function join($uid, $classId) {
        $ucmodel = new Alumni_Model_User_Class;
        
        $cur_user_joined = $ucmodel->hasJoined($uid, $classId);
        if ($cur_user_joined) {
            $this->setError(self::ERR_OPER_OTHER, '你已经加入了或正在审核中,无需重复操作');
            
            return false;
        }
        
        $result = $ucmodel->join($uid, $classId);
        if (!$result) {
            $this->setError(self::ERR_OPER_FAIL, '申请操作失败');
            return false;
        }
        
        return true;
    }
    
    /**
     * 操作用户
     * @param int $uid 操作者
     * @param int $ucId
     * @param boolean $passed 是否通过
     */
    public function review($uid, $ucId, $passed) {
        $uc_model = new Alumni_Model_User_Class;
        
        $uc = $uc_model->fetch($ucId);
        if (!$uc) {
            $this->setError(self::ERR_NOT_FOUND, '数据不存在');
            
            return false;
        }
        
        $result = $uc_model->passed($ucId, $passed);
        if (!$result) {
            $this->setError(self::ERR_OPER_FAIL, '操作失败');
            
            return false;
        }
        
        //TODO 插入消息记录 更新班级人数
        
        $this->setError(self::ERR_OPER_SUCC, '操作成功');
        
        return true;
    }
}