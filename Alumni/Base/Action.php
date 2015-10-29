<?php

/**
 * Alumni Action Base
 */
class Alumni_Base_Action extends Typecho_Widget implements Widget_Interface_Do {

    /**
     *
     * @var Widget_Options 
     */
    protected $options;

    /**
     * 风格目录
     * 
     * @var string
     */
    protected $themeDir = 'default';
    
    protected $viewSuffix = '.php';

    /**
     * 用户对象
     *
     * @access protected
     * @var Widget_User
     */
    protected $user;

    /**
     * 安全模块
     *
     * @var Widget_Security
     */
    protected $security;

    /**
     *
     * @var string 以插件Alumni/Action目录为起点,
     * Action类Class.php的名字如Class 子Action Class/Board.php的名字Action/Board
     */
    protected $actionName = null;

    public function __construct($request, $response, $params = NULL) {
        parent::__construct($request, $response, $params);

        $this->options = $this->widget('Widget_Options');
        $this->user = $this->widget('Widget_User');
        $this->security = $this->widget('Widget_Security');
        $this->themeDir = $this->options->theme;

        $this->init();
    }

    /**
     * Action必须实现的方法
     */
    public function action() {
        
    }

    /**
     * Action初始化方法,供子类重载实现
     */
    protected function init() {
        
    }

    /**
     * 分析Action名 注意:要输出视图的话,必须在子类init方法中中调用此方法
     * @return string 
     */
    protected function parseActionName() {
        $class = substr(get_class($this), strlen('Alumni_Action_'));

        $this->actionName = $class;

        return $class;
    }

    /**
     * 创建url
     * @param string $route 基本
     * @param array $args 参数
     * @return string
     */
    protected function url($route, $args) {
        return Typecho_Router::url($route, $args, $this->options->index());
    }

    /**
     * 获取视图文件
     * @usage $this->need('_xyz'); $this->need('../Xy/xx');
     *
     * @param string $fileName 主题文件 兼容te原始代码
     * @param boolean $global 是否去te的主题目录引用文件
     * @return void
     */
    public function need($fileName, $global = false) {
        if (substr($fileName, -4, 4) != $this->viewSuffix) {
            $fileName = $this->viewSuffix;
        }
        
        if ($global) {
            $view_file = rtrim($this->options->themeFile($this->themeDir, '/')) 
                        . '/' . $fileName;
        } else {
            $view_file = $this->realViewPath($fileName);
        }

        if (!file_exists($view_file)) {
            Typecho_Common::error(500);
        }

        require $view_file;
    }

    /**
     * 输出视图
     * @param string $view 无需.php后缀
     * @param array $data 数据以键名 键值的形式传递过来
     */
    protected function render($view, $data = array()) {
        extract($data);

        $validated = false;
        $view_file = $this->realViewPath($view . $this->viewSuffix);
        if (file_exists($view_file)) {
            $validated = true;
        }

        if (!$validated) {
            Typecho_Common::error(500);
        }

        require $view_file;
    }

    /**
     * 生成视图的绝对路径
     * @param string $view
     * @return string
     */
    protected function realViewPath($view) {
        
        return dirname(dirname(__FILE__)) 
                . "/views/{$this->themeDir}/{$this->actionName}/{$view}";
    }

}