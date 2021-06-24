<?php

require_once dirname(__FILE__) . '/../dao/ProductContentDao.class.php';
require_once dirname(__FILE__) . '/BaseService.class.php';

class ProductCategoryService extends BaseService
{
    public function __construct()
    {
        $this->dao = new ProductContentDao();
    }

    public function get_product_with_name($name)
    {
        return $this->dao->get_product_name($name);
    }

}
