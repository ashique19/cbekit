<?php 

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Answer extends Model 
{

	protected $table = "answers";

	protected $fillable = ['id', 'name', 'question_id', 'qref', 'qtype', 'attempt_id', 'given_answer', 'correct_answer', 'achieved_mark', 'created_at', 'updated_at'];


	/**
	* Arrays will be stored as json in database and retrieved and parsed as array
	*/
	protected $casts = [
		'given_answer' => 'array',
		'correct_answer' => 'array',
	];


	/**
	* Dates will be parsed as Carbon instance
	*/
	protected $dates = ['created_at', 'updated_at', ];


	public function comments()
	{
	
		return $this->hasMany('\App\AnswerComment');
	
	}


	/*
	* question_id belongs to \App\Question 
	*/
	public function question()
	{

		return $this->belongsTo('\App\Question');

	}


	/*
	* question_id belongs to \App\Attempt 
	*/
	public function attempt()
	{

		return $this->belongsTo('\App\Attempt');

	}


	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
            

                
        });
            
        

	}
        
        

}