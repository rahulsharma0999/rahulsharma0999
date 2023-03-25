<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
	protected $fillable = [
		"image",
		"title",
		"link",
	];
	



	// public function getImageAttribute($value){
 //        $base_path = public_path("storage/advertisement_images");
 //        $image = $value;

 //        if(!empty($image) && file_exists($base_path.'/'.$image)){
 //            return url("storage/advertisement_images").'/'.$image;
 //        }
 //        return url('admin/assets/img/add_image.png ');
 //    }




}
