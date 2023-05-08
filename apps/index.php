<?php
include_once("./database/DB.php");
if(isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['role']) && isset($_SESSION['department']) ){

    $check = DB::select('users' , DB::DBconnection() , ["userEmail"=>$_SESSION['email'] , "userPassword"=>$_SESSION['password'] ] );

    if(count($check) > 0){
        if($_SESSION['role'] == 1){
            header("location: ./superadmin/dashboard.php");
        }
        else{   
            header("location: ./admin/dashboard.php");
        }
    }
    else{
        header("location: ./logout.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="../assets/css/all.css">
    <title>Schedlr</title>
</head>
<body>
    <?php

    if((isset($_SESSION['code']) && !empty($_SESSION['code'])) && (isset($_SESSION['code_time']) ) ){

        $now = date("Y-m-d H:i:s");
        $date = $_SESSION['code_time'];

        if(strtotime($now) >= strtotime($date)){
            header("location: logout.php");
        }

        ?>
        <section id="wrapper-login-verification" class="container-fluid d-flex justify-content-center align-items-center " >
            <div class="center-box">
                <h1 class="text-dark text-center fw-bolder" >Enter Verification Code</h1><hr>
                <div class="alert-show d-none alert-show-verification alert alert-danger text-center error-globals error-global-verification">
                    
                </div>
                <form id="login-verification-form" >
                    <div class="group-input" >
                        <input type="text" class="form-control input " name="code-1" >
                        <input type="text" class="form-control input " name="code-2" >
                        <input type="text" class="form-control input " name="code-3" >
                        <input type="text" class="form-control input " name="code-4" >
                        <input type="text" class="form-control input " name="code-5" >
                        <input type="text" class="form-control input " name="code-6" >
                    </div><hr>
                    <div class="text-center">
                        <a href="logout.php" class="btn btn-danger w-25" >Cancel</a>
                        <button type="submit" class="btn btn-success w-25" id="login-verification-form-submit" >Verify</button>
                    </div>
                </form>
            </div>
        </section>
        <?php
    }
    ?>
    <section id="wrapper-login" class="container-fluid d-flex justify-content-center align-items-center " >
        <div class="center-login">
            <span class="left">
                <span class="yellow"></span>
                <span class="orange p-2">
                    <img class="mt-1" src="../assets/images/schedule-icon.JPG" width="100%" alt="">
                </span>
                <span class="blue"></span>
            </span>
            <div class="right">
                <span class="yellow"></span>
                <span class="orange"></span>
                <div class="white d-flex justify-content-center align-items-center">
                    <form class="w-100" id="login-form" >
                        <div class="text-center">
                            <img src="../assets/images/icon.gif" height="200px" alt="">
                            <h5 class="fw-bold" >ADMINISTRATOR</h5>
                        </div>
                        <hr>
                        <div class="alert alert-danger text-center d-none alert-show ">
                            <small class="error-globals error-global" ></small>
                        </div>
                        <div class="input-group mt-3">
                            <input type="text" class="form-control input" name='email' placeholder="Email Address">
                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-envelope" ></i></span>
                        </div>
                        <small class="text-danger error error-email"  ></small>
                        <div class="input-group mt-3">
                            <input type="password" class="form-control input" name='password' placeholder="Password">
                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-eye" ></i></span>
                        </div>
                        <small class="text-danger error error-password"  ></small>
                        <div class="mt-3 text-center">
                            <button type="submit" id="login-form-submit" class="btn btn-primary w-100" >Login <i class="fa fa-arrow-right" ></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="../assets/js/jquery-3.6.4.js"></script>
    <script src="../assets/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
    <script src="../assets/sweetalert2/dist/sweetalert2.all.js"></script>
    <script src="../assets/js/backends.js"></script>
</body>
</html>