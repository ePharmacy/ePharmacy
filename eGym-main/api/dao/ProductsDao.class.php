<?php

require_once dirname(__FILE__) . '/BaseDao.class.php';

class ProductsDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('products');
    }

    public function get_products($search, $offset, $limit, $order){

        list($order_column, $order_direction) = self::parse_order($order);


        return $this->query("SELECT * FROM products 
                             WHERE LOWER(productname) LIKE CONCAT('%', :productname, '%') 
                             ORDER BY ${order_column} ${order_direction}
                             LIMIT ${limit} OFFSET ${offset}", 
                             ["productname"=>strtolower($search)]);
    }

    public function get_products_by_category($category)
    {
        return $this->query('SELECT * FROM products WHERE category_id = :category_id', ['category_id' => $category]);
    }

    public function insert_new_product($products, $data)
    {
        return $this->insert($products, $data);
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

    public function update_product($id, $products) {
        $this->update("products", $id, $products);
    }


    
}
