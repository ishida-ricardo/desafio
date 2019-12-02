<?php

namespace App\Services;

use App\Product;
use App\Http\Resources\Product as ProductResource;

class ProductService
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        $products = $this->model->all();
        return ProductResource::collection($products);
    }

    public function create($request)
    {
        $product = $this->model->create($request->all());
        return new ProductResource($product);
    }

}
