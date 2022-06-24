<?php

require_once dirname(__FILE__) . '/../dao/ProductCategoryDao.class.php';
require_once dirname(__FILE__) . '/BaseService.class.php';

class ProductCategoryService extends BaseService
{
    public function __construct()
    {
        $this->dao = new product_categoryDao();
    }

    public function get_category_with_name($category)
    {
        return $this->dao->get_category_name($category);
    }

    public function update_product_category($id, $category) {
        $this->dao->update_productcategory($id, $category);
    }

    public function insert_new_category($category, $data)
    {
        return $this->dao->insert_new_category($category, $data);
    }

}
