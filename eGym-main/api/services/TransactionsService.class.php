<?php

require_once dirname(__FILE__) . '/../dao/TransactionsDao.class.php';
require_once dirname(__FILE__) . '/BaseService.class.php';

class TransactionsService extends BaseService
{
    public function __construct()
    {
        $this->dao = new TransactionsDao();
    }

    public function get_all_transactions($search, $offset, $limit, $order)
    {
        return $this->dao->get_transactions($search, $offset, $limit, $order);
    }

    public function get_transaction_by_id($id)
    {
        return $this->dao->get_transactions_by_id($id);
    }

    public function update_transaction($id, $transactions) {
        $this->dao->update_transaction($id, $transactions);
    }

    public function insert_new_transaction($transactions, $data)
    {
        return $this->dao->insert_new_transaction($transactions, $data);
    }
}
?>