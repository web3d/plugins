<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

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
     * 班级列表 Web
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
        $this->stack = $model->fetchAll($condition, '*', $page_index, $page_size);
        
        $this->render('index');
    }
    
    /**
     * 查看班级 Web
     */
    public function view() {
        $id = (int) $this->request->get('id');
        
        $model = new Alumni_Model_Class;
        $class = $model->fetch($id);
        if (!$class) {
            throw new Typecho_Exception('指定的班级不存在,请返回重试!', 404);
        }
        
        $cur_user_joined = false;
        if ($this->user->uid) {
            $ucmodel = new Alumni_Model_User_Class;
            $cur_user_joined = $ucmodel->hasJoined($this->user->uid, $id);
        }
        
        $this->render('view', array('class' => $class, 'has_joined' => $cur_user_joined));
    }
    
    /**
     * 申请加入 ajax
     */
    public function join() {
        $this->forceLogin();
        
        $id = (int) $this->request->get('id');
        
        $uc_service = new Alumni_Service_UserClass();
        
        $result = $uc_service->join($this->user->uid, $id);
        if (!$result) {
            $this->responseFail($uc_service->getErrorCode(), $uc_service->getErrorMessaage());
        }
        
        $this->responseOK('成功提交申请,请等待管理员审核');
    }
    
    /**
     * 班级管理员审核加入申请 ajax
     */
    public function review() {
        $this->forceLogin();
        //TODO 判断权限
        
        $ucid = (int) $this->request->get('ucid');
        $passed = (int) $this->request->get('passed');
        
        $uc_service = new Alumni_Service_UserClass;
        
        $result = $uc_service->review($this->user->uid, $ucid, $passed);
        if (!$result) {
            $this->responseFail($uc_service->getErrorCode(), $uc_service->getErrorMessaage());
        }
        
        $this->responseOK('操作成功');
    }
    
    /**
     * 创建 ajax
     */
    public function create() {
        $this->forceLogin();
        
        //Submit
        $name = trim($this->request->get('name'));
        $enyear = (int)trim($this->request->get('enyear'));
        $dept_id = (int) $this->request->get('deptid');
        
        $class_service = new Alumni_Service_Class;
        $result = $class_service->create($this->user->uid, $name, $enyear, $dept_id);
        if (!$result) {
            $this->responseFail($class_service->getErrorCode(), $class_service->getErrorMessaage());
        }
        
        $this->responseOK($name . '创建成功');
    }
    
    /**
     * @return void
     */
    protected function forceLogin() {
        if (!$this->user->hasLogin()) {
            $this->responseFail(Alumni_Base_Service::ERR_NEED_LOGIN, '请登录后再操作');
        }
    }

}
