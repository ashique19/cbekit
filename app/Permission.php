<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    protected $table = "permissions";
    
    protected $fillable = ['id', 'name', 'created_at', 'updated_at'];
    
    public function roles()
    {
        
        return $this->belongsToMany('\App\Role');
        
    }
    

}

        