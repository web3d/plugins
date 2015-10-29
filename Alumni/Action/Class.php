<?php

/**
 * Alumni Plugin
 * 插件前台班级相关功能界面
 *
 * @copyright  Copyright (c) 2015 jimmy.chaw (http://x3d.cnblogs.com)
 * @license    GNU General Public License 2.0
 * 
 */
class Alumni_Action_Class extends Alumni_Base_Action {
    
    /**
     * 初始化 
     */
    protected function init() {
        parent::init();
        
        $this->parseActionName();
    }

    /**
     * 班级列表
     */
    public function action() {
        $dept_id = (int) $this->request->get('deptid');
        $condition = array();
        if ($dept_id) {
            $condition['dept_id'] = $dept_id;
        }
        
        $page_index = isset($this->request->page) ? $this->request->page : 1;
        $page_size = 10;//TODO 后台配置?
        
        $model = new Alumni_Model_Class;
        $this->stack = $model->fetchAll($condition, $page_index, $page_size);
        
        $this->render('index');
    }
    
    /**
     * 查看班级
     */
    public function view() {
        $id = (int) $this->request->get('id');
        
        $model = new Alumni_Model_Class;
        $class = $model->fetch($id);
        if (!$class) {
            throw new Typecho_Exception('指定的班级不存在,请返回重试!', 404);
        }
        
        $this->render('view', array('class' => $class));
    }
    
    /**
     * 申请加入
     */
    public function join() {
        
    }
    
    /**
     * 创建
     */
    public function create() {
        
    }

}
