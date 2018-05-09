<?php

namespace App\Exceptions;

use Exception;

class IndexException extends Exception
{
    public function render($request){
        return redirect('/');
    }
}
