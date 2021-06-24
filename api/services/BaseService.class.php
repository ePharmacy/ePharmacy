<?php

class BaseService
{
    protected $dao;
    
    public function get_by_id($id)
    {
        return $this->dao->get_by_id($id);
    }

    public function update($id, $data)
    {
        $this->dao->update($id, $data);
        return $this->dao->get_by_id($id);
    }

    public function add($data)
    {
        return $this->dao->add($data);
    }

    public function column_value_change($id, $table, $value)
    {
        $this->dao->change_value($id, $table, $value);
    }
}
