<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{

    protected $table = "gateways";
    
    protected $fillable = ['id', 'name', 'charge', 'is_active', 'created_at', 'updated_at'];
    
    
    

}

        