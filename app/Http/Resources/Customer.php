<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'created_at' => $this->created_at->format('Y-m-d\TH:i:s\Z'),
            'updated_at' => $this->updated_at->format('Y-m-d\TH:i:s\Z'),
        ];
    }
}
