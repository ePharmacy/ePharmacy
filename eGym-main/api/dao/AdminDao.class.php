<?php

require_once dirname(__FILE__) . '/BaseDao.class.php';

class AdminDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('admin');
    }

    public function update_admin_by_email($email, $admin)
    {
        $this->execute_update($email, 'admin', $admin, 'email');
    }

    public function get_admin_by_email($email){
        return $this->query_unique("SELECT * FROM admin WHERE email = :email", ["email" => $email]);
      }

    public function get_admins_with_search($search, $offset, $limit, $order = "-id")
    {
        list($order_column, $order_direction) = self::parse_order($order);

        return $this->query("SELECT * FROM admin WHERE LOWER(name) LIKE CONCAT('%', :name, '%') ORDER BY ${order_column} ${order_direction} LIMIT ${limit} OFFSET ${offset}", ["name" => strtolower($search)]);
    }
}
