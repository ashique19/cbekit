<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    
    protected $table= 'navs';
    
    protected $fillable = ['id','name','type','parent_id','route','icon','location'];
    
    
    public function scopeL1($query)
    {
        
        return $query->where('type', 1);
        
    }

    
    public function scopeL2($query, $parent = null)
    {
        
        return $parent ? $query->where('type', 2)->where('parent_id', $parent) : $query->where('type', 2);
        
    }
    

    
    public function scopeL3($query, $parent = null)
    {
        
        return $parent ? $query->where('type', 3)->where('parent_id', $parent) : $query->where('type', 3);
        
    }
    
    
    public function scopeOrphans($query)
    {
        
        return $query->where('type','>',1)->whereIsNull('parent_id');
        
    }
    
    
    public function children()
    {
        
        return $this->hasMany('\App\Nav', 'parent_id');
        
    }
    
    
    
    public function roles()
    {
        
        return $this->belongsToMany('\App\Role');
        
    }
    
    
    
    
}
