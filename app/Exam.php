<?php 

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Exam extends Model 
{

	protected $table = "exams";

	protected $fillable = ['id', 'name', 'course_id', 'is_free', 'is_premium', 'exam_duration_minutes', 'created_at', 'updated_at'];


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
	* course_id belongs to \App\Course 
	*/
	public function Course()
	{

		return $this->belongsTo('\App\Course');

	}
	
	
	public function questions()
	{
		
		return $this->belongsToMany('\App\Question', 'exam_questions', 'exam_id', 'question_id');
		
	}


	/**
	* @is_free : 0 = no, 1 = yes 
	*/
	public function scopeFree($query)
	{

		return $query->where('is_free', 1);

	}


	/**
	* @is_premium : 0 = no, 1 = yes 
	*/
	public function scopePremium($query)
	{

		return $query->where('is_premium', 1);

	}
	
	
	public function attempts()
	{
		
		return $this->hasMany('\App\Attempt');
		
	}


	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
            

                
        });
            
        

	}
        
        

}