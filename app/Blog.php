<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    protected $table = "blogs";
    
    protected $fillable = ['id', 'name', 'link', 'banner_photo', 'details', 'created_by', 'updated_by', 'status', 'created_at', 'updated_at'];
    
        
    public function blogslides()
    {
        
        return $this->hasMany('\App\Blogslide');
        
    }
        
        
    public function comments()
    {
        
        return $this->hasMany('\App\Comment');
        
    }
    
    
    public function createdBy()
    {
        
        return $this->belongsTo('\App\User', 'created_by');
        
    }
    
    
    public function updatedBy()
    {
        
        return $this->belongsTo('\App\User', 'updated_by');
        
    }
    
    
    public function scopePublished($query)
    {
        
        return $query->where('status', 2);
        
    }
        
        
    public static function boot()
    {
        
        parent::boot();
        
        static::creating(function($model)
        {
            
            /**
             * 
             * Adding loggedin user as the creator and updater of the blog
             * 
             */
            if(auth()->user())
            {
                
                $model->created_by = auth()->user()->id;
                
                $model->updated_by = auth()->user()->id;
                
            }
            
            /**
             * 
             * Prepare unique link for the blog
             * 
             */
            $blog = new self();
            
            $link = str_slug($model->name);
            
            $model->link = $blog->where('link', 'like', $link)->first() ? $link.'-'.$blog->where('link', 'like', $link)->count()+1 : $link;
            
        });
        
        static::updating(function($model)
        {
            
            /**
             * 
             * Adding loggedin user as the updater of the blog
             * 
             */
            if(auth()->user())
            {
                
                $model->updated_by = auth()->user()->id;
                
            }
            
        });
        
    }
    

}

        