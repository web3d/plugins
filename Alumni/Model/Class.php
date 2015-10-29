<?php
/**
 * 班级
 */
class Alumni_Model_Class extends Alumni_Base_Model {
    
    protected $table = 'alumni_class';
    protected $pk = 'id';

    public function create($name, $enyear, $creator, $deptId) {
        
        return $this->insert(array(
            'name' => $name,
            'enrollment_year' => $enyear,
            'creator' => $creator,
            'admin1' => $creator,
            'dept_id' => $deptId,
            'reg_date' => Alumni_Base_Helper::datetime()
        ));
    }
}