<?php 

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Question extends Model 
{

	protected $table = "questions";

	protected $fillable = ['id', 'name', 'section', 'marking_type', 'course_id', 'exam_detail', 'exam_explanation', 'created_by', 'updated_by', 'created_at', 'updated_at'];


	/**
	* Arrays will be stored as json in database and retrieved and parsed as array
	*/
	protected $casts = [
	];


	/**
	* Dates will be parsed as Carbon instance
	*/
	protected $dates = ['created_at', 'updated_at', ];


	public function course()
	{
	
		return $this->belongsTo('\App\Question');
	
	}



	/*
	* exam_id belongs to \App\Exam 
	*/
	public function Exam()
	{

		return $this->belongsToMany('\App\Exam', 'exam_questions');

	}
	
	public function options()
	{
		
		return $this->hasMany('\App\Option');
		
	}


	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
            
			$model->created_by = auth()->user()->id ;
                
        });

		static::updating(function($model)
		{
            
			$model->created_by = auth()->user()->id;
                
        });
            
        

	}
        
        

}