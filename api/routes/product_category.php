<?php

Flight::route('POST /category/add', function () {
    $data = Flight::request()->data->getData();
    Flight::categoryService()->add($data);
    Flight::json(["message" => "Category created."]);
});


Flight::route('GET /category/@id', function ($id) {
    Flight::json(Flight::categoryService()->get_by_id($id));
});



Flight::route('GET /category/display/@name', function ($name){
    Flight::json(Flight::categoryService()->get_category_with_name($name));
});
