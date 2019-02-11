<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commitment extends Model
{
	protected $fillable = ['commitment_num', 'title', 'description', 'characteristics', 'status'];

	public function steps(){
		return $this->hasMany('App\Step');
	}

	public function users(){
		return $this->belongsToMany('App\User');
	}
}
