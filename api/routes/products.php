<?php


Flight::route('POST /products/submit', function () {
    $data = Flight::request()->data->getData();
    Flight::productsService()->add($data);
    Flight::json(["message" => "Product created! You will soon get an email with confirmation and details."]);
});



Flight::route('PUT /products/add_comment/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::productsService()->column_value_change($id, 'products', $data);
    Flight::json(["message" => "Comment recorded. Thanks!"]);
});


Flight::route('PUT /products/category_change/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::productsService()->column_value_change($id, 'products', $data);
    Flight::json(["message" => "products category changed."]);
});



Flight::route('PUT /products/admin_assign/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::productsService()->column_value_change($id, 'products', $data);
    Flight::json(["message" => "Admin assigned."]);
});



Flight::route('PUT /products/change_status/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::productsService()->column_value_change($id, 'products', $data);
    Flight::json(["message" => "Status updated."]);
});
