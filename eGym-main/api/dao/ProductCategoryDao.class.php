<?php

require_once dirname(__FILE__) . '/BaseDao.class.php';

class product_categoryDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('product_category');
    }

    public function get_category_name($category)
    {
        return $this->query("SELECT * FROM product_category WHERE LOWER(category) = :category", ["category" => strtolower($category)]);
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

    public function update_productcategory($id, $category) {
        $this->update("product_category", $id, $category);
    }

    public function insert_new_category($category, $data)
    {
        return $this->insert($category, $data);
    }
}
