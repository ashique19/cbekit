<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NavRole extends Model
{

    protected $table = 'nav_role';
    
    protected $fillable = ['nav_id','role_id'];
    
    
    
}
