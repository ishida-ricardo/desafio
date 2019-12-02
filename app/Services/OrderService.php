<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Resources\Order as OrderResource;
use App\Order;
use App\OrderItem;

class OrderService
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        $orders = $this->model->with(['items', 'items.product', 'buyer'])->get();
        return OrderResource::collection($orders);
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $orderData = $request->only(['status', 'total', 'created_at']);
            $orderData['customer_id'] = $request->input('buyer.id');
            $order = Order::create($orderData);

            $totalOrder = 0;
            foreach($request->items as $i) {
                $itemData = array_merge($i, ['product_id' => $i["product"]["id"]]);
                $item = new OrderItem($itemData);

                $totalItem = $item->amount * $item->price_unit;
                if($totalItem != $item->total)
                    throw new \Exception("O valor total do item {$i['product']['title']} é diferente de quantidade * preço unitário!", 1);
                    
                $totalOrder += $totalItem;
                $order->items()->save($item);
            }

            if(round($totalOrder, 2) != round($order->total, 2))
                throw new \Exception("O valor total dos items é diferente do total do pedido!", 1);

            DB::commit();
            return new OrderResource($order);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function cancel($order_id) 
    {
        $order = $this->model->find($order_id);

        if(!$order)
            return false;

        $order->status = "CANCELED";
        $order->cancelDate = now();
        $order->save();
        return $order;
    }

}
