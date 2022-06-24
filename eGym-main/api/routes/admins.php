<?php


/**Swagger Documentation */

/**
 * @OA\Info(title="egym API", version="0.1")
 * @OA\OpenApi(
 *   @OA\Server(
 *       url="http://localhost/egym/api/",
 *       description="Development Environment"
 *   )
 * ),
 * @OA\SecurityScheme(
 *      securityScheme="ApiKeyAuth",
 *      name="Authentication",
 *      type="apiKey",
 *      in="header",
 * ),
 */




 /**
 * @OA\Get(path="/admin/admins", tags={"x-admin","admins"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=10, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for admins"),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by id or +column_name descending order by id"),
 *     @OA\Response(response="200", description="List admins from database")
 * )
 */ 
Flight::route('GET /admin/admins', function () {
    $request = Flight::request();

    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::adminService()->get_admins($search, $offset, $limit, $order));
});


/**
 *     @OA\Get(path="/admin/admins/{id}", tags={"x-admin","admins"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="ID of admins"),
 *     @OA\Response(response="200", description="Fetch individual admins")
 * )
 */ 
Flight::route('GET /admin/admins/@id', function ($id) {
    Flight::json(Flight::adminService()->get_by_id($id));
});


/**
 *     @OA\Post(path="/admin/admins", tags={"x-admin","admins"}, security={{"ApiKeyAuth":{}}},
 * @OA\RequestBody(description="Basic admins info", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="username", required="true", type="string", example="ado", description="Name of the admins"),
 *    				 @OA\Property(property="email", type="string", example="ado@sadulah.com", description="Email of the admins"),
 *    				 @OA\Property(property="password", type="string", example="", description="Password of the admins"),
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Admins that has been added into database with ID assigned.")
 * )
 */ 
Flight::route('POST /admin/admins', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::adminService()->add($data));
});

/**
 *     @OA\Put(path="/admin/admins/{id}", tags={"x-admin","admins"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 * @OA\RequestBody(description="Basic admins info that is going to be updated", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="username", required="true", type="string", example="ado", description="Name of the admins"),
 *    				 @OA\Property(property="email", type="string", example="ado@sadulah.com", description="Email of the admins"),
 *    				 @OA\Property(property="password", type="string", example="", description="Password of the admins"),
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Update admins by ID from database")
 * )
 */ 
Flight::route('PUT /admin/admins/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::adminService()->update($id, $data);
});


/**
 *     @OA\Post(path="/admins/register", tags={"admin"},
 * @OA\RequestBody(description="Basic admin info", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="username", required="true", type="string", example="ado", description="Name of the admin"),
 *    				 @OA\Property(property="email", type="string", example="myemail@gmail.com", description="Email of the admin"),
 *    				 @OA\Property(property="password", type="string", example="12345", description="Password of the admin"),
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Message that user has been created.")
 * )
 */ 
Flight::route('POST /admins/register', function () {
    $data = Flight::request()->data->getData();
    Flight::adminService()->register($data);
    Flight::json(["message" => "Your account has been registered. Email with the activation link sent."]);
});


/**
 *     @OA\Post(path="/admins/login", tags={"admins"},
 * @OA\RequestBody(description="Basic admins info", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", type="string", example="myemail@gmail.com", description="Email of the admins"),
 *    				 @OA\Property(property="password", type="string", example="12345", description="Password of the admins"),
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Message that user has been created.")
 * )
 */ 
Flight::route('POST /admins/login', function () {
    Flight::json(Flight::jwt(Flight::adminService()->login(Flight::request()->data->getData())));
});


/**
 *     @OA\Post(path="/admins/forgot_password", tags={"admins"}, description="Send recovery URL to users email address",
 * @OA\RequestBody(description="Basic admins info", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="email", type="string", example="myemail@gmail.com", description="Email of the admins")
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Message that recovery link has been sent.")
 * )
 */ 
Flight::route('POST /admins/forgot_password', function () {
    $data = Flight::request()->data->getData();
    Flight::adminService()->forgot_password($data);
    Flight::json(["message" => "Recovery link sent to email."]);
});


/**
 *     @OA\Post(path="/admins/reset_password", tags={"admins"}, description="Reset users password using recovery token",
 * @OA\RequestBody(description="Basic admins info", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="token", type="string", example="12njkdsf90ds3m", description="Recovery token"),
 *    				 @OA\Property(property="password", type="string", example="12345", description="New password")
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Message that user has changed password.")
 * )
 */ 
Flight::route('POST /admins/reset_password', function () {
    Flight::json(Flight::jwt(Flight::adminService()->reset_password(Flight::request()->data->getData())));
});


/**
 *     @OA\Get(path="/admin/admins/confirm/@registration_token{token}", tags={"admins"},
 *     @OA\Parameter(type="string", in="path", name="token", default=123, description="Temporary token for activating admins."),
 *     @OA\Response(response="200", description="Message upon succesfull activation.")
 * )
 */ 
Flight::route('GET /admin/admins/confirm/@registration_token', function ($token) {
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
