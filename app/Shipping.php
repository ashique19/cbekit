<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{

    protected $table = "shippings";
    
    protected $fillable = ['id', 'name', 'cost', 'delivery_days', 'created_at', 'updated_at'];
    
    
    

}

        