<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id';

    protected $fillable = ['breed'];

    public function selections(){
        return $this->hasMany('App\Selection', 'breed_id','id');
    }
}
