<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{

    protected $table = "subscribers";
    
    protected $fillable = ['id', 'name', 'email', 'created_at', 'updated_at'];
    
    protected $casts = [
    ];
    
    

}

        