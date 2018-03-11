<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    public $timestamps = true;
    public $primaryKey = 'id';

    protected $fillable = ['highest_breed_id', 'max_miles', 'match'];

    public function users(){
        $this->hasOne('App\User', 'selection_id','id');
    }
}