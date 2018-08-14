<?php

namespace App\Exceptions;

use Exception;

class InvalidLocationException extends Exception
{
    public function render($request){
        return redirect('/')->withErrors(['This Zip Code is Invalid']);
    }
}
