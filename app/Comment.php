<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table = "comments";
    
    protected $fillable = ['id', 'name', 'user_id', 'blog_id', 'status', 'is_reply', 'comment_id', 'created_at', 'updated_at'];
    
    public function user()
    {
        
        return $this->belongsTo('\App\User');
        
    }
            
    public function blog()
    {
        
        return $this->belongsTo('\App\Blog');
        
    }
            
    public function comment()
    {
        
        return $this->belongsTo('\App\Comment');
        
    }
    
    public function scopeParents($query)
    {
        
        return $query->where('is_reply', 0);
        
    }
    
    public function scopeReply($query, $parent = null)
    {
        
        return ($parent == null) ? $query->where('is_reply', 1) : $query->where('is_reply', 1)->where('comment_id', $parent);
        
    }
    
    
    public function scopePublished($query)
    {
        
        return $query->where('status',1);
        
    }
            
    
    

}

        