<?php 

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model 
{

	protected $table = "attempts";

	protected $fillable = ['id', 'name', 'student_id', 'exam_id', 'elapsed_second', 'exam_mark', 'achieved_mark', 'created_at', 'updated_at'];


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
	* student_id belongs to \App\Student 
	*/
	public function Student()
	{

		return $this->belongsTo('\App\User', 'student_id');

	}


	/*
	* exam_id belongs to \App\Exam 
	*/
	public function Exam()
	{

		return $this->belongsTo('\App\Exam');

	}
	
	
	public function answers()
	{
		
		return $this->hasMany('\App\Answer');
		
	}


	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
            

                
        });
            
        

	}
        
        

}