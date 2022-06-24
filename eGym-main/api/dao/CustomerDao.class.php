<?php

require_once dirname(__FILE__) . '/BaseDao.class.php';

class CustomerDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('customers');
    }

    public function get_customer_with_email($email, $offset, $limit, $order = "-id")
    {
        list($order_column, $order_direction) = self::parse_order($order);

        return $this->query("SELECT * FROM customers 
                             WHERE LOWER(email) LIKE CONCAT('%', :email, '%')
                             ORDER BY ${order_column} ${order_direction} 
                             LIMIT ${limit} OFFSET ${offset}", ["email" => strtolower($email)]);
    }

    public function update_customer_by_email($email, $customers)
    {
        $this->update($email, 'customers', $customers, 'email');
    }

    public function insert_new_customer($email, $customers)
    {
        return $this->insert($email, $customers);
    }
}
