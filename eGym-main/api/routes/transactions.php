<?php


/**
 * @OA\Get(path="/user/transactions", tags={"x-user","transactions"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=10, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for transactions"),
 *     @OA\Parameter(type="string", in="query", name="order", default="-flightid", description="Sorting for return elements. -column_name ascending order by id or +column_name descending order by id"),
 *     @OA\Response(response="200", description="List transactions from database")
 * )
 */ 
Flight::route('GET /user/transactions', function () {

    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 25);
    $order = Flight::query('order', "-id");
    $search = Flight::query('search');


    Flight::json(Flight::transactionsService()->get_all_transactions($search, $offset, $limit, $order));
});


/**
 *     @OA\Post(path="/admin/transaction", tags={"x-admin","transactions"}, security={{"ApiKeyAuth":{}}},
 * @OA\RequestBody(description="Basic transactions info", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="price", required="true", type="integer", example="10", description="Price of the transaction."),
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Add transactions for the user.")
 * )
 */ 
Flight::route('POST /admin/transaction', function () {
    $data = Flight::request()->data->getData();
    Flight::transactionService()->insert_new_transaction($data);
    Flight::json(["message" => "Transaction created!"]);
});

/**
 *     @OA\Get(path="/user/transaction/{id}", tags={"x-user","transactions"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="ID of transactions"),
 *     @OA\Response(response="200", description="Fetch individual transactions")
 * )
 */ 
Flight::route('GET /user/transaction/@id', function ($id) {
    Flight::json(Flight::transactionService()->get_transaction_by_id($id));
});


/**
 *     @OA\Put(path="/admin/transaction/{id}", tags={"x-admin","transactions"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 * @OA\RequestBody(description="Basic transactions info that is going to be updated", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="price", required="true", type="integer", description="Price of the transaction."),
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Update transactions by ID from database")
 * )
 */ 
Flight::route('PUT /admin/transaction/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::transactionService()->update_transaction($id, $data)); 
  });

?>