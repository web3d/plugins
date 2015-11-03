<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

/**
 * 班级相关操作
 */
class Alumni_Service_Class extends Alumni_Base_Service {
    
    /**
     * 创建班级
     * @param int $uid
     * @param string $name
     * @param int $enyear
     * @param int $deptId
     * @return boolean
     */
    public function create($uid, $name, $enyear, $deptId) {
        if (empty($name)) {
            $this->setError(self::ERR_INPUT_INVALID, '请输入有效班级名');
            return false;
        }
        
        if ($enyear < 1700 || $enyear > date('Y') ) {
            $this->setError(self::ERR_INPUT_INVALID, '请输入有效入学年份');
            return false;
        }
        
        if ($deptId < 1) {
            $this->setError(self::ERR_INPUT_INVALID, '请输入有效院系');
            return false;
        }
        $dept_model = new Alumni_Model_Department;
        $dept = $dept_model->fetch($deptId);
        if (!$dept || $dept['parent_id'] < 1) {
            $this->setError(self::ERR_INPUT_INVALID, '请选择到院->系');
            return false;
        }
        
        $model = new Alumni_Model_Class;
        $result = $model->create($name, $enyear, $uid, $deptId);
        if (!$result) {
            $this->setError(self::ERR_OPER_FAIL, '创建操作失败');
            return false;
        }
        $uc_model = new Alumni_Model_User_Class;
        $result = $uc_model->join($uid, $result, true);
        if (!$result) {
            $this->setError(self::ERR_OPER_FAIL, '创建操作失败');
            return false;
        }
        
        $this->setError(self::ERR_OPER_SUCC, $name . '创建成功');
        
        return true;
    }
}

