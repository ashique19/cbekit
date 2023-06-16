<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{

    protected $table = "socials";
    
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];
    
    
    

}

        