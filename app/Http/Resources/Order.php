<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $order = [];
        $buyer = [];
        $items = [];

        $buyer = [
            'id' => $this->buyer->id,
            'name' => $this->buyer->name,
            'cpf' => $this->buyer->cpf,
            'email' => $this->buyer->email,
        ];

        foreach($this->items as $item) {
            $product = [
                'id' => $item->product->id,
                'sku' => $item->product->sku,
                'title' => $item->product->name,
            ];
            $items[] = [
                'amount' => $item->amount,
                'price_unit' => $item->price_unit,
                'total' => $item->total,
                'product' => $product,
            ];        
        }
        
        $order['id'] = $this->id;
        $order['created_at'] = Carbon::parse($this->created_at)->format('Y-m-d\TH:i:s\Z');

        if(!is_null($this->cancelDate))
            $order['cancelDate'] = $this->cancelDate;

        $order['status'] = $this->status;
        $order['total'] = $this->total;
        $order['buyer'] = $buyer;
        $order['items'] = $items;
        
        return $order;
    }
}
