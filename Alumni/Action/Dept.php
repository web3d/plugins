<?php

/**
 * Alumni Plugin
 * 插件前台院校相关功能
 *
 * @copyright  Copyright (c) 2015 jimmy.chaw (http://x3d.cnblogs.com)
 * @license    GNU General Public License 2.0
 * 
 */
class Alumni_Action_Dept extends Alumni_Base_Action {
    /**
     * 院系列表
     */
    public function action() {
        
    }
    
    /**
     * 查看指定ID下的院系结构 基本信息及相关班级
     */
    public function view() {
        $dept_id = $this->request->get('id');
    }

}
