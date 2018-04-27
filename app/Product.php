<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;


class Product extends Model
{
	protected $fillable = ['name','description','price','image'];

    public function presentPrice()
    {
    	return '$'.' '.$this->price/100;
    }

    public function categoryys()
    {
    	return $this->belongsToMany('App\Categoryy');
    }
}
