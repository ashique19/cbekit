<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $table = "countries";
    
    protected $fillable = ['id', 'code', 'name', 'created_at', 'updated_at'];
    
    
    

}

        