<?php

require_once dirname(__FILE__) . '/BaseDao.class.php';

class ProductContentDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('product_content');
    }

    public function get_content_by_admin($products)
    {
        return $this->query('SELECT * FROM product_id_content WHERE product_id = :id', ['id' => $products]);
    }
}
