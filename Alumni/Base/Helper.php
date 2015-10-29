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
}