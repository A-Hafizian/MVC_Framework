<?php
namespace App\Utilities;

class Validation 
{
    public static function is_valid_email(string $email){
        return filter_var($email,FILTER_VALIDATE_EMAIL) ? true : false ;
    }

    public static function is_valid_fullname(string $fullname){
    }
}
