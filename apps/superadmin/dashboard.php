<?php
include_once("../database/DB.php");
if(isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['role']) && isset($_SESSION['department']) ){

    $check = DB::select('users' , DB::DBconnection() , ["userEmail"=>$_SESSION['email'] , "userPassword"=>$_SESSION['password'] ] );

    if(count($check) > 0){
        if($_SESSION['role'] != 1){
            header("location: ../admin/dashboard.php");
        }
    }
    else{
        header("location: ../logout.php");
    }

}
else{
    header("location: ../logout.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/bootstrap-4.0.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="../../assets/css/all.css">
    <title>Schedlr</title>
</head>
<body>
    <section id="dashboard" >
        <div id="sidebar">a</div>
        <div id="content">
a
        </div>
    </section>
    <script src="../assets/js/jquery-3.6.4.js"></script>
    <script src="../assets/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
    <script src="../assets/sweetalert2/dist/sweetalert2.all.js"></script>
    <script src="../assets/js/backends.js"></script>
</body>
</html>