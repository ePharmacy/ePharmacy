<?php

/**
 *     @OA\Post(path="/admin/products/submit", tags={"x-admin","products"}, security={{"ApiKeyAuth":{}}},
 * @OA\RequestBody(description="Basic products info", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="productname", required="true", type="string", example="Paracetamol", description="Name of the product."),
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Add products for the user.")
 * )
 */ 
Flight::route('POST /admin/products/submit', function () {
    $data = Flight::request()->data->getData();
    Flight::productsService()->add($data);
    Flight::json(["message" => "Product created! You will soon get an email with confirmation and details."]);
});


/**
 * @OA\Get(path="/user/products", tags={"x-user","products"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=10, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for products"),
 *     @OA\Parameter(type="string", in="query", name="order", default="-flightid", description="Sorting for return elements. -column_name ascending order by id or +column_name descending order by id"),
 *     @OA\Response(response="200", description="List products from database")
 * )
 */ 
Flight::route('GET /user/products', function() {

    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $search = Flight::query('search');

    $order = Flight::query('order', "-id");


    Flight::json(Flight::productsService()->get_products($search, $offset, $limit, $order));

  });



Flight::route('PUT /admin/products/add_comment/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::productsService()->column_value_change($id, 'products', $data);
    Flight::json(["message" => "Comment recorded. Thanks!"]);
});


Flight::route('PUT /admin/products/category_change/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::productsService()->column_value_change($id, 'products', $data);
    Flight::json(["message" => "products category changed."]);
});



Flight::route('PUT /admin/products/admin_assign/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::productsService()->column_value_change($id, 'products', $data);
    Flight::json(["message" => "Admin assigned."]);
});



Flight::route('PUT /admin/products/change_status/@id', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::productsService()->column_value_change($id, 'products', $data);
    Flight::json(["message" => "Status updated."]);
});


?>