<?php

Flight::route('GET /admins', function () {
    $request = Flight::request();

    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::adminService()->get_admins($search, $offset, $limit, $order));
});



Flight::route('GET /admins/@id', function ($id) {
    Flight::json(Flight::adminService()->get_by_id($id));
});



Flight::route('POST /admins/add', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::adminService()->add($data));
});


Flight::route('PUT /admins/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::adminService()->update($id, $data);
});



Flight::route('POST /admins/register', function () {
    $data = Flight::request()->data->getData();
    Flight::adminService()->register($data);
    Flight::json(["message" => "Your account has been registered. Email with the activation link sent."]);
});



Flight::route('POST /admins/login', function () {
    Flight::json(Flight::jwt(Flight::adminService()->login(Flight::request()->data->getData())));
});



Flight::route('POST /admins/forgot_password', function () {
    $data = Flight::request()->data->getData();
    Flight::adminService()->forgot_password($data);
    Flight::json(["message" => "Recovery link sent to email."]);
});



Flight::route('POST /admins/reset_password', function () {
    Flight::json(Flight::jwt(Flight::adminService()->reset_password(Flight::request()->data->getData())));
});



Flight::route('GET /admins/confirm/@registration_token', function ($token) {
    Flight::json(Flight::jwt(Flight::adminService()->confirm($token)));
});


Flight::route('PUT /admins/category_change/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::adminService()->column_value_change($id, 'admin', $data);
    Flight::json(["message" => "Admin group changed."]);
});



Flight::route('PUT /admins/email_change/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::adminService()->column_value_change($id, 'admin', $data);
    Flight::json(["message" => "Email changed."]);
});



Flight::route('PUT /admins/change_status/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::adminService()->column_value_change($id, 'admin', $data);
    Flight::json(["message" => "Active status changed."]);
});



Flight::route('PUT /admins/change_password/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::adminService()->column_value_change($id, 'admin', $data);
    Flight::json(["message" => "Password changed successfully."]);
});



Flight::route('PUT /admins/change_name/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::adminService()->column_value_change($id, 'admin', $data);
    Flight::json(["message" => "Name changed successfully."]);
});



Flight::route('POST /admins/add_comment', function () {
    $data = Flight::request()->data->getData();
    Flight::adminService()->add_comment($data);
    Flight::json(["message" => "Comment applied to the ticket."]);
});
