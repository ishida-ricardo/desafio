<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'cpf', 'email', 'created_at', 'updated_at'];
    
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace( "@[./-]@", "", $value );
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value);
    }

    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = Carbon::parse($value);
    }
    
}
