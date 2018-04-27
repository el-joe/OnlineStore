<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoryy extends Model
{
    //
    public function products()
    {
    	return $this->belongsToMany('App\product');
    }
}
