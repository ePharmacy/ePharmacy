<?php


/**
 *     @OA\Post(path="/admin/customers/add", tags={"x-admin","customers"}, security={{"ApiKeyAuth":{}}},
 * @OA\RequestBody(description="Basic flight info", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="customer_name", required="true", type="string", example="Ado"),
 *    				 @OA\Property(property="password", type="string"),
 *     				 @OA\Property(property="email", type="string", example="a@a.com"),
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Add customers for the user.")
 * )
 */ 
Flight::route('POST /admin/customers/add', function () {
    $data = Flight::request()->data->getData();
    Flight::customerService()->add($data);
    Flight::json(["message" => "Thanks! Proceed with ticket creation."]);
});


/**
 *     @OA\Get(path="/user/customers{id}", tags={"x-user","customers"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="ID of customers"),
 *     @OA\Response(response="200", description="Fetch individual customers")
 * )
 */ 
Flight::route('GET /user/customers/@id', function ($id) {
    Flight::json(Flight::customerService()->get_by_id($id));
});


/**
 * @OA\Get(path="/user/customers", tags={"x-user","customers"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=10, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for customers"),
 *     @OA\Parameter(type="string", in="query", name="order", default="-flightid", description="Sorting for return elements. -column_name ascending order by id or +column_name descending order by id"),
 *     @OA\Response(response="200", description="List customers from database")
 * )
 */ 
Flight::route('GET /user/customers', function () {

    $request = Flight::request();

    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $email = Flight::query('email');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::customerService()->get_clients($email, $offset, $limit, $order));
});


 /**
 *     @OA\Put(path="/admin/customers/{id}", tags={"x-admin","customers"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 * @OA\RequestBody(description="Basic customers info that is going to be updated", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="customer_name", required="true", type="string", example="Ado"),
 *    				 @OA\Property(property="password", type="string"),
 *     				 @OA\Property(property="email", type="string", example="a@a.com"),
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Update customers by ID from database")
 * )
 */ 
Flight::route('PUT /admin/customers/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::customerService()->update_customer($id, $data)); 
  });

?>