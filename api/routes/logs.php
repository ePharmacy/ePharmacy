<?php



Flight::route('GET /logs/history/', function () {
    $request = Flight::request();

    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $order = Flight::query('order', "-id");

    Flight::json(Flight::logsService()->get_all_comments($offset, $limit, $order));
});
