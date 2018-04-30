<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    public $timestamps = true;
    public $primaryKey = 'id';

    protected $fillable = ['breed_id', 'zip','highest_breed_id', 'max_miles', 'match'];

    public function users(){
        return $this->hasOne('App\User', 'selection_id','id');
    }

    public function breed(){
        return $this->hasOne('App\Breed', 'id', 'breed_id');
    }
}
