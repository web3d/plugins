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
     * @param string $fields
     * @param array $filter
     * @return array
     */
    public function fetch($condition, $fields = '*', array $filter = NULL) {
        $query = $this->db->sql()->select($fields)->from("table.{$this->table}")->where($this->parseCondition($condition));

        return $this->db->fetchRow($query, $filter);
    }

    /**
     * 小量数据一次性取出多条数据
     * @param mixed $condition
     * @param string $fields
     * @param int $pageIndex
     * @param int $pageSize
     * @param array $filter
     */
    public function fetchAll($condition, $fields = '*', $pageIndex = 1, $pageSize = 10, array $filter = NULL) {
        $query = $this->db->sql()->select($fields)->from("table.{$this->table}")->where($this->parseCondition($condition))->page($pageIndex, $pageSize);

        return $this->db->fetchAll($query, $filter);
    }

    /**
     * 新增一条记录
     * @param array $data
     * @return boolean
     */
    public function insert($data) {
        $query = $this->db->insert("table.{$this->table}")->rows($data);

        return $this->db->query($query);
    }

    /**
     * 根据条件更新相关数据
     * @param mixed $condition
     * @param array $data
     * @return boolean
     */
    public function update($condition, $data) {
        $query = $this->db->update("table.{$this->table}")->where($this->parseCondition($condition))->rows($data);

        return $this->db->query($query);
    }

    /**
     * 根据条件删除相关数据
     * @param mixed $condition
     * @return boolean
     */
    public function delete($condition) {
        $query = $this->db->delete("table.{$this->table}")->where($this->parseCondition($condition));

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
        
        $where = '';
        if (empty($condition)) {
            $where = '1';
        } elseif (is_array($condition)) {
            $where = $this->implode($condition, ' AND ');
        } else {
            $where = $condition;
        }

        return $where;
    }

    protected function quote($str, $noarray = false) {

        if (is_string($str))
            return '\'' . mysql_escape_string($str) . '\'';

        if (is_int($str) or is_float($str))
            return '\'' . $str . '\'';

        if (is_array($str)) {
            if ($noarray === false) {
                foreach ($str as &$v) {
                    $v = $this->quote($v, true);
                }
                return $str;
            } else {
                return '\'\'';
            }
        }

        if (is_bool($str))
            return $str ? '1' : '0';

        return '\'\'';
    }

    protected function quoteField($field) {
        if (is_array($field)) {
            foreach ($field as $k => $v) {
                $field[$k] = $this->quoteField($v);
            }
        } else {
            if (strpos($field, '`') !== false)
                $field = str_replace('`', '', $field);
            $field = '`' . $field . '`';
        }
        return $field;
    }

    protected function implode($array, $glue = ',') {
        $sql = $comma = '';
        $glue = ' ' . trim($glue) . ' ';
        foreach ($array as $k => $v) {
            $sql .= $comma . $this->quoteField($k) . '=' . $this->quote($v);
            $comma = $glue;
        }
        return $sql;
    }

    protected function implodeFieldValue($array, $glue = ',') {
        return $this->implode($array, $glue);
    }

    protected function format($sql, $arg) {
        $count = substr_count($sql, '%');
        if (!$count) {
            return $sql;
        } elseif ($count > count($arg)) {
            throw new Typecho_Db_Query_Exception('SQL string format error! This SQL need "' . $count . '" vars to replace into.', 0, $sql);
        }

        $len = strlen($sql);
        $i = $find = 0;
        $ret = '';
        while ($i <= $len && $find < $count) {
            if ($sql{$i} == '%') {
                $next = $sql{$i + 1};
                if ($next == 's') {
                    $ret .= $this->quote(is_array($arg[$find]) ? serialize($arg[$find]) : (string) $arg[$find]);
                } elseif ($next == 'f') {
                    $ret .= sprintf('%F', $arg[$find]);
                } elseif ($next == 'd') {
                    $ret .= intval($arg[$find]);
                } elseif ($next == 'i') {
                    $ret .= $arg[$find];
                } elseif ($next == 'n') {
                    if (!empty($arg[$find])) {
                        $ret .= is_array($arg[$find]) ? implode(',', $this->quote($arg[$find])) : $this->quote($arg[$find]);
                    } else {
                        $ret .= '0';
                    }
                } else {
                    $ret .= $this->quote($arg[$find]);
                }
                $i++;
                $find++;
            } else {
                $ret .= $sql{$i};
            }
            $i++;
        }
        if ($i < $len) {
            $ret .= substr($sql, $i);
        }
        return $ret;
    }

}
