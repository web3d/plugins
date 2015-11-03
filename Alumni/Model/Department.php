<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

/**
 * 部门
 */
class Alumni_Model_Department extends Alumni_Base_Model {
    
    protected $table = 'alumni_department';
    protected $pk = 'id';
    
    /**
     * 支持两级
     */
    public function fetchTree() {
        $depts = $this->fetchAll(NULL, '*', 1, 2000);
        if (!$depts) {
            return array();
        }
        
        $l1s = array();
        foreach ($depts as $dept) {
            if ($dept['parent_id'] == 0) {
                $l1s[$dept['id']] = $dept;
            }
        }
        
        if (!$l1s) {
            return array();
        }
        
        foreach ($l1s as $key => $dept) {
            foreach ($depts as $_dept) {
                if ($_dept['parent_id'] == $key) {
                    $l1s[$key]['subs'][$_dept['id']] = $_dept;
                }
            }
        }
        
        return $l1s;
    }
    

}