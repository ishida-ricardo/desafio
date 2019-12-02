<?php

namespace App\Services;

use App\Customer;
use App\Http\Resources\Customer as CustomerResource;

class CustomerService
{
    protected $model;

    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function create($request)
    {
        $customer = $this->model->create($request->all());
        return new CustomerResource($customer);
    }

}
