<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    protected $table = "pages";
    
    protected $fillable = ['id', 'name', 'details', 'meta_tag_title', 'meta_tag_description', 'meta_tag_keywords', 'created_at', 'updated_at'];
    
    
    

}

        