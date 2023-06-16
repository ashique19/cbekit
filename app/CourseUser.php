<?php 

namespace App; 

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model 
{

	protected $table = "course_user";

	protected $fillable = ['id', 'course_id', 'user_id', 'teacher_id', 'is_enroled', 'is_free', 'is_premium', 'is_paid', 'is_active', 'start_date', 'end_date', 'note', 'created_at', 'updated_at'];


	/**
	* Arrays will be stored as json in database and retrieved and parsed as array
	*/
	protected $casts = [
	];


	/**
	* Dates will be parsed as Carbon instance
	*/
	protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at'];



	/*
	* course_id belongs to \App\Course 
	*/
	public function Course()
	{

		return $this->belongsTo('\App\Course');

	}


	/*
	* user_id belongs to \App\User 
	*/
	public function User()
	{

		return $this->belongsTo('\App\User');

	}


	/**
	* @is_enroled : 0 = no, 1 = yes 
	*/
	public function scopeEnroled($query)
	{

		return $query->where('is_enroled', 1);

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


	/**
	* @is_paid : 0 = no, 1 = yes 
	*/
	public function scopePaid($query)
	{

		return $query->where('is_paid', 1);

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