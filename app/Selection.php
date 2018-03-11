<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    public $timestamps = true;
    public $primaryKey = 'id';

    protected $fillable = ['breed_id','highest_breed_id', 'max_miles', 'match'];

    public function users(){
        $this->hasOne('App\User', 'selection_id','id');
    }

    public function breed(){
        $this->hasOne('App\Breed', 'id', 'breed_id');
    }
}
