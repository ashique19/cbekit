<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    protected $table = "currencies";
    
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];
    
    
    

}

        