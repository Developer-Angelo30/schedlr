<?php


class AutoGenerate{

    public static function email_verification(){

        $code = mt_rand(100000 , 999999);
        return $code;

    }

    public static function password(){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password  = '';

        for ($i = 0 ; $i < 12; $i++ ){
            $index = rand(0, strlen($characters)-1);
            $password .= $characters[$index];
        }

        return $password;

    }

}

?>