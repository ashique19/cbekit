<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = "settings";
    
    protected $fillable = ['id', 'application_name', 'application_slogan', 'business_name', 'owners_name', 'address', 'city', 'country', 'postcode', 'contact', 'helpline', 'helpmail', 'email', 'logo_photo', 'icon_photo', 'google_plus', 'facebook', 'twitter', 'is_controlled_access', 'created_at', 'updated_at'];
    
    
    

}

        