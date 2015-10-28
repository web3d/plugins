<?php

/**
 * DB模型基类
 */
class Alumni_Base_Model {
    /**
     *
     * @var Typecho_Db 
     */
    protected $db;
    
    /**
     * 
     * @var string 表名 子类重载该属性赋值 
     */
    protected $table;
    
    /**
     * 
     * @var string 表主键字段名 子类重载该属性赋值
     */
    protected $pk;

    public function __construct() {
        $this->db = Typecho_Db::get();
    }
    
    /**
     * 取出单条数据
     * @param mixed $condition
     * @param array $filter
     * @return array
     */
    public function fetch($condition, array $filter = NULL) {
        $query = $this->db->sql()->from("table.{$this->table}")->where($this->parseCondition($condition));
        
        return $this->db->fetchRow($query, $filter);
    }

    /**
     * 小量数据一次性取出多条数据
     * @param mixed $condition
     * @param array $filter
     */
    public function fetchAll($condition, $pageIndex = 1, $pageSize = 10, array $filter = NULL) {
        $query = $this->db->sql()->from("table.{$this->table}")->where($this->parseCondition($condition))->page($pageIndex, $pageSize);
        
        return $this->db->fetchAll($query, $filter);
    }
    
    /**
     * 新增一条记录
     * @param array $data
     * @return boolean
     */
    public function insert($data) {
        $query = $this->db->sql()->insert("table.{$this->table}")->rows($data);
        
        return $this->db->query($query);
    }
    
    /**
     * 根据条件更新相关数据
     * @param mixed $condition
     * @param array $data
     * @return boolean
     */
    public function update($condition, $data) {
        $query = $this->db->sql()->update("table.{$this->table}")->where($this->parseCondition($condition))->rows($data);
        
        return $this->db->query($query);
    }
    
    /**
     * 根据条件删除相关数据
     * @param mixed $condition
     * @return boolean
     */
    public function delete($condition) {
        $query = $this->db->sql()->delete("table.{$this->table}")->where($this->parseCondition($condition));
        
        return $this->db->query($query);
    }
    
    /**
     * 重新构造查询条件
     * @param mixed $condition
     * @return array
     */
    public function parseCondition($condition) {
        if (is_int($condition) && $this->pk) {
            $condition = array($this->pk => $condition);
        }
        
        return $condition;
    }
}