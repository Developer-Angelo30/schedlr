<?php

include_once("../database/DB.php");
include_once("../encrypt/hash.php");
include_once("../auto/auto.php");
include_once("../Email/email.php");
include_once("../log/log.php");

class userModel {

    private $email;
    private $firstName;
    private $lastName;
    private $password;
    private $department;
    private $verification;

    protected function loginAccount(){

        $email = mysqli_real_escape_string(DB::DBconnection(), $this->getEmail());

        $now = date("Y-m-d H:i:s");
        $plusDate = strtotime($now) + (2 * 60);
        $punishAttempt = date("Y-m-d H:i:s" , $plusDate );

        $sql = "SELECT users.* , attempts.* , departments.* FROM `users` INNER JOIN attempts ON users.userID = attempts.userID  INNER JOIN departments ON users.userDepartment = departments.Department WHERE userEmail = '$email' ";
        $result = DB::DBconnection()->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            

            if(Hash::dehash($this->getPassword(), $row['userPassword'] )){
                
                if(strtotime($now) >= strtotime($row['attempt_date'])){
                    $resetAttempt = DB::update('attempts' , ['attempt'=>3 , 'attempt_date'=>$now] , ["userID"=>$row['userID']] , DB::DBconnection() );
                    if($resetAttempt){

                        if($row['userRole'] == 1){
                            $code = AutoGenerate::email_verification();
                            if(Email::sendVerification($row['userEmail'] ,$code)){
                                $_SESSION['email'] = $row['userEmail'];
                                $_SESSION['code'] = Hash::hash($code);
                                $_SESSION['code_time'] = $punishAttempt;
                                $output = json_encode(array("status"=>true , "role"=>1) );
                            }
                            else{
                                session_destroy();
                                Log::log("Failed to send email verification code");
                                $output = json_encode(array("status"=>false, "error"=>"verification" , "message"=>"Failed to send emailverification code" ));
                            }
                        }
                        else{
                            $_SESSION['email'] = $row['userEmail'];
                            $_SESSION['password'] = $row['userPassword'];
                            $_SESSION['role'] = $row['userRole'];
                            $_SESSION['department'] = $row['userDepartment'];
                            $output = json_encode(array("status"=>true, 'role'=>0 , "message"=>"./admin/dashboard.php" ));
                        }

                    }
                }
                else{
                    Log::log("maximum login attempt");
                    $show =  date("h:i A", strtotime($row['attempt_date']));
                    $output = json_encode(array("status"=>false, "error"=>"global" , "message"=>"Try again, {$show}." ));
                }
            }
            else{

                $attempt = $row['attempt'] - 1;

                if($row['attempt'] != 0){
                    $updateAttempt = DB::update('attempts' , ['attempt'=>$attempt , 'attempt_date'=>$punishAttempt] , ["userID"=>$row['userID']] , DB::DBconnection() );
                    if($updateAttempt){
                        Log::log("login attempt");
                        $output = json_encode(array("status"=>false, "error"=>"password" , "message"=>"Password not matched, {$attempt} attempt left." ));
                    }
                }
                else{
                    if(strtotime($now) >= strtotime($row['attempt_date'])){
                        $resetAttempt = DB::update('attempts' , ['attempt'=>3 , 'attempt_date'=>$now] , ["userID"=>$row['userID']] , DB::DBconnection() );
                        if($resetAttempt){
                            if($row['attempt'] != 0){
                                $updateAttempt = DB::update('attempts', ['attempt'=>$attempt , 'attempt_date'=>$punishAttempt] , ["userID"=>$row['userID']] , DB::DBconnection() );
                                if($updateAttempt){
                                    Log::log("login attempt");
                                    $output = json_encode(array("status"=>false, "error"=>"password" , "message"=>"Password not matched, {$attempt} attempt left." ));
                                }
                            }
                            else{
                                $output = json_encode(array("status"=>false, "error"=>"password" , "message"=>"Password not matched, 3 attempt left." ));
                            }
                        }
                    }
                    else{
                        Log::log("maximum login attempt");
                        $show =  date("h:i A", strtotime($row['attempt_date']));
                        $output = json_encode(array("status"=>false, "error"=>"global" , "message"=>"Try again, {$show}." ));
                    }
                }
            }

        }
        else{
            $output = json_encode(array("status"=>false, "error"=>"email" , "message"=>"Please double check your email address." ));
        }

        DB::DBclose();
        return $output;

    }

    protected function verifyLogin(){

        $email = $_SESSION['email'];

        if(Hash::dehash($this->getVerification(), $_SESSION['code'])){
            $sql = "SELECT users.* , attempts.* FROM `users` INNER JOIN attempts ON users.userID = attempts.userID WHERE userEmail = '$email' ";
            $result = mysqli_query(DB::DBconnection(), $sql);

            if(mysqli_num_rows($result)){
                $row = mysqli_fetch_assoc($result);
                
                $_SESSION['email'] = $row['userEmail'];
                $_SESSION['password'] = $row['userPassword'];
                $_SESSION['role'] = $row['userRole'];
                $_SESSION['department'] = $row['userDepartment'];
                $output = json_encode(array("status"=>true, "message"=>"./superadmin/dashboard.php" ));
            }
        }
        else{
            $output = json_encode(array("status"=>false, "message"=>"Incorrect verification code!" ));
        }

        DB::DBclose();
        return $output;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    protected function getEmail(){
        return $this->email;
    }

    public function setFirstName($firstName){
        $this->firstName = $firstName;
    }

    protected function getFirstName(){
        return $this->firstName;
    }

    public function setLastName($lastName){
        $this->lastName = $lastName;
    }

    protected function getLastName(){
        return $this->lastName;
    }
    
    public function setPassword($password){
        $this->password = $password;
    }

    protected function getPassword(){
        return $this->password;
    }

    public function setDepartment($department){
        $this->department = $department;
    }

    protected function getDepartment(){
        return $this->department;
    }
    public function setVerification($verification){
        $this->verification = $verification;
    }

    protected function getVerification(){
        return $this->verification;
    }

}

?>