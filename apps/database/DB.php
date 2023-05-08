<?php
session_start();
date_default_timezone_set("Asia/manila");

class DB{

    private static $DBhost = "localhost";
    private static $DBusername = "root";
    private static $DBpassword = "";
    private static $DBname = "capstone";

    public static function DBconnection(){

        $con = mysqli_connect(self::$DBhost, self::$DBusername , self::$DBpassword , self::$DBname);

        if(!$con){
            die("Connection failed!".mysqli_connect_error());
        }

        return $con;
    }

    public static function DBclose(){
        return mysqli_close(self::DBconnection());
    }

    public static function create($table, array $fields, $con){

        $keys = null;
        $values = null;

        if(is_array($fields)){
            foreach($fields as $key=>$value){

                $data = mysqli_real_escape_string($con , $value);
    
                if($key == end(array_keys($fields))){
                    $keys .= "{$key}";
                    $values .= "'{$data}'";
                }
                else{
                    $keys .= "{$key}, ";
                    $values .= "'{$data}', ";
                }
            }
        }

        $sql =  "INSERT INTO $table ($keys)VALUES($values) ";
        mysqli_query(DB::DBconnection(), $sql);
        return true;
    }

    public static function update($table , array $updateData , array $where, $con){

        $updateValue = null;
        $updateWhere = null;

        if(is_array($updateData)){

            foreach($updateData as $key=>$value){
                $data = mysqli_real_escape_string($con , $value);

                ($key == end(array_keys($updateData))) ? $updateValue .= "{$key} = '{$data}'" : $updateValue .= "{$key} = '{$data}' ,";
            }

            foreach($where as $key=>$value){
                $data = mysqli_real_escape_string($con , $value);
                
                ($key == end(array_keys($where))) ? $updateWhere .= "{$key} = '{$data}'" : $updateWhere .= "{$key} = '{$data}' AND ";
            }
        }
        
        $update = "UPDATE $table SET $updateValue WHERE $updateWhere";
        mysqli_query($con , $update);
        return true;
    }

    public static function delete($table, array $where,$con){
        
        $updateWhere = null;

        foreach($where as $key=>$value){
            $data = mysqli_real_escape_string($con, $value);
            
            ($key == end(array_keys($where))) ? $updateWhere .= "{$key} = '{$data}'" : $updateWhere .= "{$key} = '{$data}' AND ";
        }

        $sql =  "DELETE FROM $table WHERE $updateWhere ";
        mysqli_query($con, $sql);
        return true;

    }

    public static function select($table , $con ,array $where = null ){

        $whereValue = null;
        $output = array();

        if(!empty($where)){
            foreach($where as $key=>$value){
                $data = mysqli_real_escape_string($con, $value);
                ($key == end(array_keys($where))) ? $whereValue .= "{$key} = '{$data}'" : $whereValue .= "{$key} = '{$data}' AND ";
            }
            $sql = "SELECT * FROM $table WHERE $whereValue ";
        }
        else{
            $sql = "SELECT * FROM $table ";
        }

        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)){
                $output[] = $row;
            }
        }
        DB::DBclose();
        return $output;

    }

}

//     field      value   
// 'firstname'=>'angelo'

//echo DB::create('users',['firstname'=>'angelo','lastname'=>'reyes'], DB::DBconnection());
//echo DB::update('users', ['firstname'=>'Dong' , 'lastname' => 'Cock'] , ['id'=>1] , DB::DBconnection() );
//echo DB::delete('users' , ['id'=>1] , DB::DBconnection());
//print_r(DB::select('users',DB::DBconnection()));

?>