<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	
	public function Church(){
		return $this->belongsTo('App\Models\Church');
	}
	
	
	
	
	
	
	
	public function userSetting(){
		 return $this->hasOne('App\Models\UserSettings');
	}
	
	
	public function notificationList(){
		 return $this->hasMany('App\Models\NotificationList','userId');
	}
	
	public function contactUs(){
		 return $this->hasOne('App\Models\ContactUs');
	}
	  
	public function friendList(){
		 return $this->hasMany('App\Models\FriendList');
	}
	public function commentList(){
		 return $this->hasMany('App\Models\CommentList');
	}

	public function gallery() {
		return $this->hasMany('App\Models\UserGallery', 'userId');
	}
}
