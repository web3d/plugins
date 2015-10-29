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
        
        $ucmodel = new Alumni_Model_User_Class;
        $cur_user_joined = false;
        if ($this->user->uid) {
            $cur_user_joined = $ucmodel->hasJoined($this->user->uid, $id);
        }
        
        $this->render('view', array('class' => $class, 'has_joined' => $cur_user_joined));
    }
    
    /**
     * 申请加入
     */
    public function join() {
        if (!$this->user->hasLogin()) {
            $this->responseFail(self::ERR_NEED_LOGIN, '请登录后再操作');
        }
        
        $id = (int) $this->request->get('id');
        
        $ucmodel = new Alumni_Model_User_Class;
        
        $cur_user_joined = $ucmodel->hasJoined($this->user->uid, $id);
        if ($cur_user_joined) {
            $this->responseFail(self::ERR_OPER_OTHER, '你已经加入了或正在审核中,无需重复操作');
        }
        
        $result = $ucmodel->join($this->user->uid, $id);
        if (!$result) {
            $this->responseFail(self::ERR_OPER_FAIL, '申请操作失败');
        }
        $this->responseOK('成功提交申请,请等待管理员审核');
    }
    
    /**
     * 创建
     */
    public function create() {
        if (!$this->user->hasLogin()) {
            $this->responseFail(self::ERR_NEED_LOGIN, '请登录后再操作');
        }
        
        //Submit
        $name = trim($this->request->get('name'));
        $enyear = (int)trim($this->request->get('enyear'));
        $dept_id = (int) $this->request->get('deptid');
        
        if (empty($name) || $enyear < 1950 || $enyear > date('Y') || $dept_id < 1) {
            $this->responseFail(self::ERR_OPER_FAIL, '请输入有效数据');
        }
        $dept_model = new Alumni_Model_Department;
        $dept = $dept_model->fetch($dept_id);
        if (!$dept || $dept['parent_id'] < 1) {
            $this->responseFail(self::ERR_OPER_FAIL, '请选择到院系');
        }
        
        $model = new Alumni_Model_Class;
        $result = $model->create($name, $enyear, $this->user->uid, $dept_id);
        if (!$result) {
            $this->responseFail(self::ERR_OPER_FAIL, '创建操作失败');
        }
        $this->responseOK($name . '创建成功');
    }

}
