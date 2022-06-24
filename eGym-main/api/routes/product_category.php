<?php

/**
 *     @OA\Post(path="/admin/category", tags={"x-admin","category"}, security={{"ApiKeyAuth":{}}},
 * @OA\RequestBody(description="Basic category info", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="category", required="true", type="string", description="Category of the med."),
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Add category for the user.")
 * )
 */ 
Flight::route('POST /admin/category', function () {
    $data = Flight::request()->data->getData();
    Flight::categoryService()->add($data);
    Flight::json(["message" => "Category created."]);
});

/**
 *     @OA\Get(path="/user/category/{id}", tags={"x-user","category"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="ID of category"),
 *     @OA\Response(response="200", description="Fetch individual category")
 * )
 */ 
Flight::route('GET /user/category/@id', function ($id) {
    Flight::json(Flight::categoryService()->get_by_id($id));
});


/**
 *     @OA\Get(path="/user/category/display/{name}", tags={"x-user","category"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(type="integer", in="path", name="name", default=1, description="ID of category"),
 *     @OA\Response(response="200", description="Fetch individual category")
 * )
 */ 
Flight::route('GET /user/category/display/@name', function ($name){
    Flight::json(Flight::categoryService()->get_category_with_name($name));
});


/**
 *     @OA\Put(path="/admin/category/{id}", tags={"x-admin","category"}, security={{"ApiKeyAuth":{}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 * @OA\RequestBody(description="Basic category info that is going to be updated", required=true,
 *     @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="category", required="true", type="string", description="Category of the med."),
 *          )
 *     )
 * ),
 *     @OA\Response(response="200", description="Update category by ID from database")
 * )
 */ 
Flight::route('PUT /admin/category/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::categoryService()->update($id, $data)); 
  });


?>
