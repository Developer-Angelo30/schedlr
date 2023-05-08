<?php


class Log{

    // need to deploy this system to get the real IP address
    
    public static function log($message){

        $os = $_SERVER['HTTP_SEC_CH_UA_PLATFORM'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $date = date("Y-m-d");

        $msg = "[{$date}] = IP: {$ip} , OS: {$os} , MESSAGE: {$message}\n";

        file_put_contents("../../logs.log", $msg , FILE_APPEND );
    }

}

?>