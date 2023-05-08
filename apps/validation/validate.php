<?php


class validation {

    public static function email($email){
        
        return (filter_var($email , FILTER_VALIDATE_EMAIL)) ? filter_var($email, FILTER_SANITIZE_EMAIL) : false;

    }

    public static function  numeric($input){
        $pattern = "/^[0-9]+$/";
        return preg_match($pattern , $input);
    }

    public static function  alpha($input){
        $pattern = "/^[A-Za-z]+$/";
        return preg_match($pattern , $input);
    }

    public static function  alpha_numeric($input){
        $pattern = "/^[A-Za-z0-9]+$/";
        return preg_match($pattern , $input);
    }

    public static function  alpha_numeric_space($input){
        $pattern = "/^[A-Za-z0-9\s]+$/";
        return preg_match($pattern , $input);
    }

}


$sum = function(callable $callback){

}


?>

