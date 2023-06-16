<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blogslide extends Model
{

    protected $table = "blogslides";
    
    protected $fillable = ['id', 'name', 'subtitle', 'slide_photo', 'blog_id', 'created_at', 'updated_at'];
    
    public function blog()
    {
        
        return $this->belongsTo('\App\Blog');
        
    }
            
    
    

}

        