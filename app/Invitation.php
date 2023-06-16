<?php 

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model 
{

	protected $table = "teacher_student_invites";

	protected $fillable = [
		'id', 
		'student_id', 
		'teacher_id', 
		'course_id', 
		'invited_by', 
		'is_accepted',	// 0 (default) = no, 1 = yes,	2=declined
		'created_at', 
		'updated_at'
	];


	/**
	* Arrays will be stored as json in database and retrieved and parsed as array
	*/
	protected $casts = [
	];


	/**
	* Dates will be parsed as Carbon instance
	*/
	protected $dates = ['created_at', 'updated_at'];



	/*
	* 
	*/
	public function student()
	{

		return $this->belongsTo('\App\User', 'student_id');

	}


	/*
	* 
	*/
	public function teacher()
	{

		return $this->belongsTo('\App\User', 'teacher_id');

	}


	/*
	* 
	*/
	public function invitedBy()
	{

		return $this->belongsTo('\App\User', 'invited_by');

	}


	/*
	* course_id belongs to \App\Course 
	*/
	public function course()
	{

		return $this->belongsTo('\App\Course');

	}


	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
            
			$model->invited_by = auth()->user()->id;
                
        });

		static::created(function($model)
		{
            
			\App\Notification::create([
				'name' => auth()->user()->name.' invited you to join for '.$model->course->name,
				'link' => action('Students@myInvitations'),
				'user_id' => $model->student_id
			]);
                
        });
            
        

	}
        
        

}