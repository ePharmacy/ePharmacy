<?php

require_once dirname(__FILE__) . '/BaseDao.class.php';

class ProductsDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('products');
    }

    public function get_products_by_category($category)
    {
        return $this->query('SELECT * FROM products WHERE category_id = :category_id', ['category_id' => $category]);
    }
}
