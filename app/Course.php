<?php 

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Course extends Model 
{

	protected $table = "courses";

	protected $fillable = ['id', 'name', 'alter_name', 'created_at', 'updated_at'];


	/**
	* Arrays will be stored as json in database and retrieved and parsed as array
	*/
	protected $casts = [
	];


	/**
	* Dates will be parsed as Carbon instance
	*/
	protected $dates = ['created_at', 'updated_at', ];

	public function questions()
	{
	
		return $this->hasMany('\App\Question');
	
	}
	
	
	public function exams()
	{
		
		return $this->hasMany('\App\Exam');
		
	}
	
	
	public function students()
	{
		
		return $this->belongsToMany('\App\User');
		
	}


	public function myStudents()
	{

		return $this->students()->where('teacher_id', auth()->user()->id );

	}


	public function teacher(){
	
		return $this->belongsTo('\App\User', 'teacher_id');
	
	}
	


	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
            

                
        });
            
        

	}
        
        

}