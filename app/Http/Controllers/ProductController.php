<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title = "My Doc API",
 *     version = "1.0.0",
 *     description = "Описание API"
 * ),
 * 
 * @OA\PathItem(
 *     path="/api/"
 * ),
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="GET products",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Фильтр по имени продукта",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="categories",
     *         in="query",
     *         description="Фильтр по категориям продукта",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *               @OA\Property(property="id", type="integer", example=1),
     *               @OA\Property(property="name", type="string", example="name"),
     *               @OA\Property(property="categories", type="string", example="categories"),
     *               @OA\Property(property="unit", type="string", example="unit"),
     *               @OA\Property(property="price", type="decimal", example=12.10), 
     *               @OA\Property(property="quantity", type="integer", example=10),
     *             )),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ресурс не найден"
     *     )
     * )
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('categories')) {
            $query->where('categories', 'like', '%' . $request->input('categories') . '%');
        }
        $products = $query->get();

        return ProductResource::collection($products);
    }

    /**
     * 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Create",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               
     *               @OA\Property(property="name", type="string", example="name"),
     *               @OA\Property(property="categories", type="string", example="categories"),
     *               @OA\Property(property="unit", type="string", example="unit"),
     *               @OA\Property(property="price", type="decimal", example=12.10), 
     *               @OA\Property(property="quantity", type="integer", example=10),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ",
     *         @OA\JsonContent(
     *            @OA\Property(property="id", type="integer", example=1),
     *            @OA\Property(property="name", type="string", example="name"),
     *            @OA\Property(property="categories", type="string", example="categories"),
     *            @OA\Property(property="unit", type="string", example="unit"),
     *            @OA\Property(property="price", type="decimal", example=12.10), 
     *            @OA\Property(property="quantity", type="integer", example=10),
     *         )
     *     ),
     *     @OA\Response(    
     *         response=400,
     *         description="Ошибка в запросе",
     *         @OA\JsonContent(
     *             
     *         )
     *     ),
     *     
     * )
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);
        return ProductResource::make($product);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{product}",
     *     summary="GET product",
     *     description="Получает ресурс по указанному ID",
     *     operationId="getResourceById",
     *     tags={"Products"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID post",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный запрос",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 format="int64",
     *                 description="ID ресурса"
     *             ),
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Название ресурса"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ресурс не найден"
     *     )
     * )
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    /**
     * @OA\Get(
     *  path="/api/products/{product}/edit",
     *  operationId="/api/products/{product}/edit",
     *  tags={"Products"},
     *  summary="Get product by id",
     *  security={{"bearerAuth":{}}},
     *  @OA\Parameter(
     *   name="product",
     *   in="path",
     *   required=true,
     *   @OA\Schema(type="integer"),
     *
     *  ),
     *  @OA\Response(response=200, description="Success",@OA\MediaType(mediaType="application/json",)),
     *  @OA\Response(response=401,description="Unauthenticated"),
     *  @OA\Response(response=400,description="Bad Request"),
     *  @OA\Response(response=404,description="not found"),
     *  @OA\Response(response=403,description="Forbidden")
     *)
     * 
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product = new ProductResource($product);
        }
        return $this->jsonResponse($product);
    }
    protected function jsonResponse($data, $status = 200)
    {
        return new JsonResponse($data, $status);
    }

    /**
     * @OA\PATCH(
     *     path="/api/products/{product}",
     *     summary="Обновление ресурса",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         name="product",
     *         in="path",
     *         description="ID ресурса",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="title",
     *                 type="string",
     *                 description="Описание поля 1"
     *             ),
     *             @OA\Property(
     *                 property="likes",
     *                 type="integer",
     *                 description="Описание поля 2"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешное обновление ресурса"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ресурс не найден"
     *     )
     * )
     * 
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $data = $request->validated();
        $product->update($data);
        return ProductResource::make($product);
    }

    /**
     *  @OA\Delete(
     *     path="/api/products/{product}",
     *     summary="Удаление",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         description="ID post",
     *         in="path",
     *         name="product",
     *         required=true,
     *         example=1
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="ok",
     *         @OA\JsonContent(
     *            @OA\Property(property="message", type="string", example="the object has been deleted"),
     *            
     *         ),
     *       ),
     *   ),
     * ),
     * 
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => 'the object has been deleted',
        ]);
    }
}
