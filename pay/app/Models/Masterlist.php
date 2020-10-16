<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masterlist extends Model {

	protected $table = 'prlemployeemaster';
	protected $primaryKey = 'employeeid';

	protected $appends = [
		'fullname'
	];
	
	public function getFullnameAttribute()
	{
		return $this->firstname.' '.$this->lastname;
	}
}
