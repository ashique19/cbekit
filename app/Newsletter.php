<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{

    protected $table = "newsletters";
    
    protected $fillable = ['id', 'name', 'details', 'created_at', 'updated_at'];
    
    protected $casts = [
    ];
    
    

}

        