<?php

require_once dirname(__FILE__) . '/../dao/CustomerDao.class.php';
require_once dirname(__FILE__) . '/../dao/ProductContentDao.class.php';
require_once dirname(__FILE__) . '/BaseService.class.php';

class CustomerService extends BaseService
{
    public function __construct()
    {
        $this->dao = new CustomerDao();
        $this->contentDao = new ProductContentDao();
    }

    public function get_customers($email, $offset, $limit, $order)
    {
        if ($email) {
            return $this->dao->get_customer_with_email($email, $offset, $limit, $order);
        } else {
            return $this->dao->get_all($offset, $limit, $order);
        }
    }

    public function get_customer_by_email($email, $offset, $limit)
    {
        return $this->dao->get_customer_with_email($email, $offset, $limit);
    }

    public function insert_new_customer($email, $customers)
    {
        return $this->dao->insert($email, $customers);
    }

    public function update_customer($id, $customers) {
        $this->dao->update($id, $customers);
    }
}
