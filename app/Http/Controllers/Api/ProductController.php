<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Services\ProductService;

class ProductController extends Controller {

    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index() 
    {
        $products = $this->service->getAll();
        return response()->json($products, 200);
    }

    public function store(ProductRequest $request) 
    {
        $product = $this->service->create($request);
        return response()->json($product, 201);
    }
}