<?php

Flight::before('start', function(&$params, &$output){

    if(Flight::request()->url == '/') return TRUE;

    if (str_starts_with(Flight::request()->url, '/customers')) return TRUE;

    if (str_starts_with(Flight::request()->url, '/admins/login')) return TRUE;

    if (str_starts_with(Flight::request()->url, '/admins/register')) return TRUE;

    if (str_starts_with(Flight::request()->url, '/admins/forgot_password')) return TRUE;

    if (str_starts_with(Flight::request()->url, '/admins/reset_password')) return TRUE;

    if (str_starts_with(Flight::request()->url, '/admins/confirm/')) return TRUE;

    if (str_starts_with(Flight::request()->url, '/tickets/submit')) return TRUE;

    if (str_starts_with(Flight::request()->url, '/clients/add_comment')) return TRUE;



    $headers = getallheaders();
    $token = @$headers['Authentication'];
    try {
        $decoded = (array)\Firebase\JWT\JWT::decode($token, "JWT SECRET", [""]);
        Flight::set('admin', $decoded);
        return TRUE;
    } catch (\Exception $e) {
        Flight::json(["message" => "You must be logged in."], 401);
        die;
    }
});
