<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Found_Dog extends Model
{
    public $timestamps = true;
    public $table ='found_dogs';
    public $primaryKey = 'id';

    protected $fillable = ['email', 'new_breed_id','miles'];

}
