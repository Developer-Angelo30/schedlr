<?php


class Hash{

    private const CUSTOM_SALT = "beba503c09729f48babceb45a7380f28";

    public static function hash(string $password):string{
        return password_hash(self::CUSTOM_SALT.$password , PASSWORD_BCRYPT);
    }

    public static function dehash(string $password ,string $hashed):bool{
        return password_verify(self::CUSTOM_SALT.$password, $hashed);
    }
}



?>