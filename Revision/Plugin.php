<?php
/**
 * Contents修改版本记录插件
 * 
 * @package Revision
 * @author jimmy chaw
 * @version 1.0.0 Beta
 * @link http://x3d.cnblogs.com
 */
class Revision_Plugin implements Typecho_Plugin_Interface
{
    private static $pluginName = 'Revision';
    private static $tableName = 'contents_revisions';
    
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        $meg = self::install();
        
        Typecho_Plugin::factory('Widget_Contents_Post_Edit')->finishPublish = array('Revision_Plugin', 'saveRevision');
        Typecho_Plugin::factory('Widget_Contents_Page_Edit')->finishPublish = array('Revision_Plugin', 'saveRevision');
        
        
        Helper::addPanel(1, 'Revision/panel.php', 'Revision', '文档版本管理',   'administrator');
        
        return _t($meg);
    }
    
    public static function install()
	{           
                                
		$installDb = Typecho_Db::get();
		$prefix = $installDb->getPrefix();
        $table = $prefix. self::$tableName;
		try {
                        $installDb->query("CREATE TABLE IF NOT EXISTS `$table` (
  `rid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `created` int(11) NOT NULL,
  `text` text NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '版本创建者',
  PRIMARY KEY (`rid`),
  KEY `cid` (`cid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档内容的版本化';");

                       return('表创建成功, 插件已经被激活!');
                    
		} catch (Typecho_Db_Exception $e) {
			$code = $e->getCode();
			if(('Mysql' == $type && 1050 == $code)) {
					//$script = 'SELECT `rid` from `' . $table . '`';
					//$installDb->query($script, Typecho_Db::READ);
					return '数据表已存在，插件启用成功';	
			} else {
				throw new Typecho_Plugin_Exception('数据表'.$table.'建立失败，插件启用失败。错误号：'.$code);
			}
		}
	}
    
    public static function saveRevision(array $contents, $obj) {
        $cookieUid = Typecho_Cookie::get('__typecho_uid');
        
        $revision = array(
        	'cid' => $obj->cid,
            'title' => $contents['title'],
            'slug' => $contents['slug'],
            'created' => time(),
            'text' => $contents['text'],
            'uid' => $cookieUid,
        );
        
        $db = Typecho_Db::get();
        
    	$rid = $db->query($db->insert('table.' . self::$tableName)->rows($revision));
        
        return $rid;
    }
    
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){
    
    }
    

    
}
