<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;

class OrderController extends Controller {

    protected $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function index() 
    {
        $orders = $this->service->getAll();
        return response()->json($orders, 200);
    }

    public function store(OrderRequest $request) 
    {
        try {
            $order = $this->service->create($request);
            return response()->json($order, 201);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 422);
        }
    }

    public function cancelStatus(Request $request, $order_id) 
    {
        $order = $this->service->cancel($order_id);

        if(!$order)
            return response()->json(['message' => 'Order not found.'], 404);

        return response()->json(['order_id' => $order->id, 'status' => $order->status], 200);
    }
}