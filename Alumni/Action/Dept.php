<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

/**
 * Alumni Plugin
 * 插件前台院校相关功能 支持院系两级结构
 *
 * @copyright  Copyright (c) 2015 jimmy.chaw (http://x3d.cnblogs.com)
 * @license    GNU General Public License 2.0
 * 
 */
class Alumni_Action_Dept extends Alumni_Base_Action {
    
    /**
     * 初始化 
     */
    protected function init() {
        parent::init();
        
        $this->parseActionName();
    }
    
    /**
     * 院系列表
     */
    public function action() {
        
    }
    
    /**
     * ajax方式获取列表
     */
    public function query() {
        //$id = (int) $this->request->get('id');
        
        $model = new Alumni_Model_Department();
        
        $depts = $model->fetchTree();
        
        $this->response->throwJson($depts);
    }
    
    /**
     * 查看指定ID下的院系结构 基本信息及相关班级
     */
    public function get() {
        $id = $this->request->get('id');
    }
    
    /**
     * ajax获取单条
     */
    /*public function ajaxGet() {
        $id = (int) $this->request->get('id');
        
        $model = new Alumni_Model_Department();
        $row = $model->fetch($id);
        
        $this->response->throwJson($row);
    }*/

}
