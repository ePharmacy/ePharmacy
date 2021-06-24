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
}
