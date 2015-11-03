<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

/**
 * 校友录插件
 * 
 * @package Alumni
 * @author jimmy chaw
 * @version 0.1.0 Beta
 * @link http://x3d.cnblogs.com
 */
class Alumni_Plugin implements Typecho_Plugin_Interface {

    private static $_pluginName = 'Alumni';

    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @return string
     * @throws Typecho_Plugin_Exception
     */
    public static function activate() {
        $msg = 'true'; //self::install();

        //为已有的Widget注入新方法
        //Typecho_Plugin::factory('Widget_User')->___sinauthAuthorizeIcon = array('Sinauth_Plugin', 'authorizeIcon');

        //向系统注册新的Action Widget
        Helper::addAction('alumni_main', 'Alumni_Action_Main');
        Helper::addAction('alumni_dept', 'Alumni_Action_Dept');
        Helper::addAction('alumni_class', 'Alumni_Action_Class');
        Helper::addAction('alumni_user', 'Alumni_Action_User');
        
        //向系统前台注册新的action
        //将页面-p与API-api分离的方式来开发,便于将来多端开发
        $routes = require dirname(__FILE__) . '/conf/routes.conf.php';
        Alumni_Base_Helper::addRoutes($routes);
        //后台管理面板
        Helper::addPanel(1, 'Alumni/panel.php', '校友录管理', '管理面板', 'administrator');

        return _t($msg);
    }

    public static function install() {
        $db = Typecho_Db::get();
        
        $prefix = $db->getPrefix();
        
        $scripts = file_get_contents(dirname(__FILE__) . '/schema.sql');
        $scripts = str_replace('table.', $prefix, $scripts);
        try {
            $scripts = explode(';', $scripts);
            foreach ($scripts as $script) {
                $script = trim($script);
                if ($script) {
                    $db->query($script, Typecho_Db::WRITE);
                }
            }
            
            return('表创建成功, 插件已经被激活!');
        } catch (Typecho_Db_Exception $e) {
            $code = $e->getCode();
            if (('Mysql' == $db->getAdapterName() && 1050 == $code)) {
                $script = "SELECT `classid` from `{$prefix}alumni_class`";
                $db->query($script, Typecho_Db::READ);
                return '数据表已存在，插件启用成功,如有异常请手动操作表结构再来执行安装操作';
            } else {
                throw new Typecho_Plugin_Exception('数据表建立失败，插件启用失败。错误号：' . $code);
            }
        }
    }

    //在前台登陆页面增加oauth跳转图标
    /*public static function authorizeIcon() {
        return '<a href="' . Typecho_Router::url('sinauthAuthorize', array('feed' => '/atom/comments/')) . '">新浪登陆</a>';
    }*/

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate() {
        $routes = require dirname(__FILE__) . '/conf/routes.conf.php';
        
        foreach ($routes as $key => $value) {
            if (!$key) {
                continue;
            }
            
            Helper::removeRoute($key);
        }
        
        Helper::removePanel(1, 'Alumni/panel.php');
    }

    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form) {
        
    }

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {
        
    }

}
