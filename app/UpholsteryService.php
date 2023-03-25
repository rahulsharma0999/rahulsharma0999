<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UpholsteryService extends Model
{
	protected $fillable = [
        'couche_price',
        'dinning_chair_price',
        'side_chair_price'

    ];
}
