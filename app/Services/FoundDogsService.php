<?php
namespace App\Services;

use App\Found_Dog;

class FoundDogsService{

    public function deleteRecord($new_breed_id){
        $found_dog = Found_Dog::where('new_breed_id', $new_breed_id);
        $found_dog->delete();
    }

}

