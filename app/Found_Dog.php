<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Found_Dog extends Model
{
    public $timestamps = true;
    public $table ='found_dogs';
    public $primaryKey = 'id';

    protected $fillable = ['email', 'new_breed_id','miles'];

    public function scopeBreedIdAndMiles($query, $email)
    {
        return $query->where('email', $email)->get()->sortByDesc('updated_at')->map(function ($dogs) {
            return $dogs->only(['new_breed_id', 'miles']);
        });
    }

}
