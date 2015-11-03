<?php

class Alumni_Base_Helper {
    
    /**
     * 当前时间转换为日期时间格式
     * @param string $format 默认'Y-m-d H:i:s'
     * @return string
     */
    public static function datetime($format = 'Y-m-d H:i:s') {
        $created = new Typecho_Date(Typecho_Date::gmtTime());
        
        return $created->format($format);
    }
    
    /**
     * 批量添加route
     * @param array $routes
     */
    public static function addRoutes($routes) {
        if (!$routes) {
            return false;
        }
        
        foreach ($routes as $key => $route) {
            if (empty($route['route']) || empty($route['map'][0])) {
                continue;
            }
            
            Helper::addRoute($key, $route['route'], $route['map'][0], empty($route['map'][1]) ? 'action' : $route['map'][1]);
        }
        
        return true;
    }
}