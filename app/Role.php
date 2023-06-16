<?php

namespace App;

use \App\Nav;
use \Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    protected $table = 'roles';
    
    protected $fillable = ['id','name'];
    
    
    public function user()
    {
        
        return $this->belongsTo('\App\User');
        
    }
    
    public function navs()
    {
        
        return $this->belongsToMany('\App\Nav', 'nav_role', 'role_id', 'nav_id');
            
    }
    
    public function permissions()
    {
        
        return $this->belongsToMany('\App\Permission');
        
    }
    

    
}
