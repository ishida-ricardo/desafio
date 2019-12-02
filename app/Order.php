<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = ['customer_id', 'total', 'status', 'created_at'];
    
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value);
    }

    public function buyer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }
    
    public function items()
    {
        return $this->hasMany('App\OrderItem');
    }

}
