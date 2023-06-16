<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    
    protected $fillable = [
        'id',
        'name',
        'user_id',
        'link',
        'is_read',
        'created_at',
        'updated_at'
    ];
    
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    
    public function user(){
    
        return $this->belongsTo('\App\User');
    
    }

    public function scopeIsRead($query){
    
        return $query->where( 'is_read', 1 );
    
    }


    public function scopeUnread($query){
    
        return $query->where('is_read', 0);
    
    }
    
    
    
}
