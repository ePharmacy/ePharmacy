<?php

require_once dirname(__FILE__) . '/BaseDao.class.php';

class TransactionsDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('transactions');
    }

    public function get_transactions($search, $offset, $limit, $order){

        list($order_column, $order_direction) = self::parse_order($order);


        return $this->query("SELECT * FROM transactions 
                             WHERE LOWER(price) LIKE CONCAT('%', :price, '%') 
                             ORDER BY ${order_column} ${order_direction}
                             LIMIT ${limit} OFFSET ${offset}", 
                             ["price"=>strtolower($search)]);
    }

     public function get_transactions_by_id($id)
    {
        return $this->query('SELECT * FROM transactions WHERE id = :id', ['id' => $id]);
    }

    public function insert_new_transaction($transactions, $data)
    {
        return $this->insert($transactions, $data);
    }

    public function execute_update($table, $id, $entity, $id_column = "id"){
        $query = "UPDATE ${table} SET ";
        foreach($entity as $name => $value){
          $query .= $name ."= :". $name. ", ";
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE ${id_column} = :id";
    
        $stmt= $this->connection->prepare($query);
        $entity['id'] = $id;
        $stmt->execute($entity);
      }

    public function update_transaction($id, $transactions) {
        $this->update("transactions", $id, $transactions);
    }

}
////////////////////////7