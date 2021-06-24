<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/services/AdminService.class.php';
require_once dirname(__FILE__) . '/services/ProductContentService.class.php';
require_once dirname(__FILE__) . '/services/ProductService.class.php';
require_once dirname(__FILE__) . '/services/CustomerService.class.php';
require_once dirname(__FILE__) . '/services/LogsService.class.php';

/* Reading query parameters from URL */
Flight::map('query', function ($name, $default_value = null) {
    $request = Flight::request();

    $query_param = @$request->query->getData()[$name];
    $query_param = $query_param ? $query_param : $default_value;

    return $query_param;
});

Flight::route('GET /', function(){
    Flight::redirect('/docs');
  });

/* BL Layer registration */
Flight::register('adminService', 'AdminService');
Flight::register('categoryService', 'productCategoryService');
Flight::register('productService', 'productService');
Flight::register('customerService', 'CustomerService');
Flight::register('logsService', 'LogsService');



/* Routes */
require_once dirname(__FILE__) . '/routes/admins.php';
require_once dirname(__FILE__) . '/routes/product_category.php';
require_once dirname(__FILE__) . '/routes/products.php';
require_once dirname(__FILE__) . '/routes/middleware.php';
require_once dirname(__FILE__) . '/routes/customer.php';
require_once dirname(__FILE__) . '/routes/logs.php';

Flight::start();
