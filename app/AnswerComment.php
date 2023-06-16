<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerComment extends Model
{
    
	protected $table = 'answer_comments';
	
	protected $fillable = ['name', 'created_by', 'is_reply', 'attempt_id', 'question_id', 'answer_comment_id'];


	public function comments()
	{
	
		return $this->hasMany('\App\AnswerComment');
	
	}

	public function commentedBy()
	{
	
		return $this->belongsTo('\App\User', 'commented_by');
	
	}

	public function scopeNotReply($query)
	{
	
		return $query->where('is_reply', 0);
	
	}


    public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
            
            $model->commented_by = auth()->user()->id;
                
        });
            
        

	}

}
