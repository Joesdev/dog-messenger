<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    public $timestamps = true;
    public $primaryKey = 'id';

    protected $fillable = ['breed'];

    public function selections(){
        $this->hasMany('App\Selection', 'breed_id','id');
    }
}
