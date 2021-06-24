<?php



Flight::route('POST /customers/add', function () {
    $data = Flight::request()->data->getData();
    Flight::customerService()->add($data);
    Flight::json(["message" => "Thanks! Proceed with ticket creation."]);
});



Flight::route('GET /customers/@id', function ($id) {
    Flight::json(Flight::customerService()->get_by_id($id));
});



Flight::route('GET /customers', function () {

    $request = Flight::request();

    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $email = Flight::query('email');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::customerService()->get_clients($email, $offset, $limit, $order));
});
