<?php

require_once dirname(__FILE__) . '/../dao/ProductsDao.class.php';
require_once dirname(__FILE__) . '/BaseService.class.php';

class ProductsService extends BaseService
{
    public function __construct()
    {
        $this->dao = new ProductsDao();
    }

    public function get_product_with_name($name)
    {
        return $this->dao->get_product_name($name);
    }

    public function get_product_with_category($category)
    {
        return $this->dao->get_products_by_category($category);
    }

    public function get_products($search, $offset, $limit, $order)
    {
        return $this->dao->get_products($search, $offset, $limit, $order);
    }

    public function update_product($id, $products) {
        $this->dao->update($id, $products);
    }

    public function insert_new_product($products, $data)
    {
        return $this->dao->insert($products, $data);
    }

}
