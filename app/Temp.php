<?php 

namespace App; 

use Illuminate\Database\Eloquent\Model;

class Temp extends Model 
{

	protected $table = "temps";

	protected $fillable = ['id', 'name', 'role_id', 'is_active', 'temp_link', 'thumb_image', 'thumb_files', 'thumb_images', 'temp_description', 'more_detail', 'stat_details', 'created_by', 'updated_by', 'published_date', 'reviewed_date', 'created_at', 'updated_at'];


	/**
	* Arrays will be stored as json in database and retrieved and parsed as array
	*/
	protected $casts = [
		'thumb_files'=> 'array',
		'thumb_images'=> 'array',
	];


	/**
	* Dates will be parsed as Carbon instance
	*/
	protected $dates = ['published_date', 'reviewed_date', 'created_at', 'updated_at', ];



	/*
	* role_id belongs to \App\Role 
	*/
	public function Role()
	{

		return $this->belongsTo('\App\Role');

	}


	/**
	* @is_active : 0 = no, 1 = yes 
	*/
	public function scopeActive($query)
	{

		return $query->where('is_active', 1);

	}


	public function createdBy()
	{

		return $this->belongsTo('\App\User', 'created_by');

	}


	public function updatedBy()
	{

		return $this->belongsTo('\App\User', 'updated_by');

	}


	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
            
			if(auth()->user())
			{

				$model->created_by = auth()->user()->id;

				$model->updated_by = auth()->user()->id;

			}
        

            /**
             * 
             * Prepare unique link for the blog
             * 
             */
            $item = new self();
            
            $link = str_slug($model->name);
            
            $model->link = $item->where('link', 'like', $link)->first() ? $link.'-'.($item->where('link', 'like', $link.'%')->count()+1) : $link;
            
            
                
        });
            
        
        
        static::updating(function($model)
        {
    
            if(auth()->user())
            {
                
                $model->updated_by = auth()->user()->id;
                
            }
            
        });
            
        

	}
        
        

}