<?php

if (!defined('__TYPECHO_ROOT_DIR__')) exit; 

return array(
    'alumni_main' => array(
        'route' => '/alumni',
        'map' => array('Alumni_Action_Main', 'action')
    ),
    'alumni_dept_main' => array(
        'route' => '/alumni/p/depts',
        'map' => array('Alumni_Action_Dept', 'action')
    ),
    'alumni_api_dept_main_tree' => array(
        'route' => '/alumni/api/depts',
        'map' => array('Alumni_Action_Dept', 'query')
    ),
    'alumni_api_dept_get' => array(
        'route' => '/alumni/api/depts/[id:digital]',
        'map' => array('Alumni_Action_Dept', 'get')
    ),
    'alumni_class_main' => array(
        'route' => '/alumni/p/classes',
        'map' => array('Alumni_Action_Class', 'action')
    ),
    'alumni_class_main_bydeptid' => array(
        'route' => '/alumni/p/classes/[deptid:digital]',
        'map' => array('Alumni_Action_Class', 'action')
    ),
    'alumni_class_view' => array(
        'route' => '/alumni/p/class/[id:digital]',
        'map' => array('Alumni_Action_Class', 'view')
    ),
    'alumni_api_class_join' => array(
        'route' => '/alumni/api/class/join',
        'map' => array('Alumni_Action_Class', 'join')
    ),
    'alumni_api_class_create' => array(
        'route' => '/alumni/api/class/create',
        'map' => array('Alumni_Action_Class', 'create')
    ),
);