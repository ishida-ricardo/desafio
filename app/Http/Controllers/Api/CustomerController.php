<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Services\CustomerService;

class CustomerController extends Controller {

    protected $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    public function store(CustomerRequest $request) 
    {
        $customer = $this->service->create($request);
        return response()->json($customer, 201);
    }
}