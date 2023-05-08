<?php
include_once("../validation/validate.php");
include_once("../models/user.model.php");

class userView extends userModel{

    public function loginAccounts(){
        
        $count = 0;
        (empty($this->getEmail()))?$count +=1 : $count ;
        (empty($this->getPassword()))?$count +=1 : $count ;

        if($count === 0){

            $validEmail = validation::email($this->getEmail());

            if($validEmail != false){
                return $this->loginAccount();
            }
            else{
                return json_encode(array("status"=>false, "error"=>"email" , "message"=>"Please input valid email address"));
            }
        }
        else{
            return json_encode(array("status"=>false, "error"=>"global" , "message"=>"Please fill all input fields!"));
        }

    }

    public function loginVerifications(){

        if(validation::numeric($this->getVerification())){
            return $this->verifyLogin();
        }
        else{
            return json_encode(array("status"=>false , "message"=>"Please input numeric only!"));
        }
        
    }

}

$action = $_POST['action'];
$view = new userView;

switch($action){
    case 'loginAccounts':{
        $view->setEmail($_POST['email']);
        $view->setPassword($_POST['password']);
        echo $view->loginAccounts();
        break;
    }
    case 'loginVerifications':{

        $code1 = $_POST['code-1'];
        $code2 = $_POST['code-2'];
        $code3 = $_POST['code-3'];
        $code4 = $_POST['code-4'];
        $code5 = $_POST['code-5'];
        $code6 = $_POST['code-6'];

        if(!empty($code1) ||!empty($code2) ||!empty($code3) ||!empty($code4) || !empty($code5) ||!empty($code6)){
            $code = $code1.$code2.$code3.$code4.$code5.$code6;
            $view->setVerification($code);
            echo $view->loginVerifications();
        }
        else{
            return json_encode(array("status"=>false , "message"=>"Please fill all input fields!"));
        }

        
        break;
    }
    default:{
        die("Conmtact the developer");
        break;
    }
}


?>