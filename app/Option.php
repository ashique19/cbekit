<?php 

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Option extends Model 
{

	protected $table = "options";

	protected $fillable = ['id', 'name', 'options', 'qref', 'is_correct', 'marks', 'question_id', 'created_at', 'updated_at'];


	/**
	* Arrays will be stored as json in database and retrieved and parsed as array
	*/
	protected $casts = [
	];


	/**
	* Dates will be parsed as Carbon instance
	*/
	protected $dates = ['created_at', 'updated_at', ];



	/*
	* question_id belongs to \App\Question 
	*/
	public function question()
	{

		return $this->belongsTo('\App\Question');

	}


	/**
	* @is_correct : 0 = no, 1 = yes 
	*/
	public function scopeCorrect($query)
	{

		return $query->where('is_correct', 1);

	}


	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
            

                
        });
            
        

	}
        
        

}