<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';


    Class Email{

        public static function sendPassword($reciever, $fullname , $department){

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            //sender
            $mail->Username = "schedlr.neust@gmail.com";
            $mail->Password = "qvopyfgjnjemxtqm";
            $mail->Port = 465;
            $mail->SMTPSecure = "ssl";
            $mail->isHTML(true);
            $mail->setFrom("schedlr.neust@gmail.com");
            $mail->addAddress($reciever);
            $mail->Subject = "NEUST Schedlr.";
            $mail->Body = '
                <div style="width: 100%;">
                    <div class="upper" style="background:blue;padding: 10px;">
                        <h4 style="color:white; font-size: 20px;" >NUEVA ECIJA UNIVERSITY OF SCIENCE AND TECHNOLOGY</h4>
                    </div>
                    <div class="content">
                        <br><br>
                        <strong lng style="font-size: 20px;" >Hello, Prof. <span>'.$fullname.'</span> </strong><br>
                        <label for=""  style="font-size: 16px;" >('.$department.')</label><br><hr>
                        <strong style="font-size: 20px;" >Email Address</strong><br>
                        <label for=""  style="font-size: 18px;" >example@gmail.com</label><br>
                        <strong  style="font-size: 20px;" >Password</strong><br>
                        <label  style="font-size: 18px;" for="">dsadarfafwafawfwaefaw</label><br>
                    </div>
                </div>
            ';
            if($mail->send()){
                return true;
            }

        }

        public static function sendVerification($reciever, $code){

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            //sender
            $mail->Username = "schedlr.neust@gmail.com";
            $mail->Password = "qvopyfgjnjemxtqm";
            $mail->Port = 465;
            $mail->SMTPSecure = "ssl";
            $mail->isHTML(true);
            $mail->setFrom("schedlr.neust@gmail.com");
            $mail->addAddress($reciever);
            $mail->Subject = "NEUST Schedlr.";
            $mail->Body = '
                <div style="width: 100%;">
                    <div class="upper" style="background:blue;padding: 10px;">
                        <h4 style="color:white; font-size: 20px;" >NUEVA ECIJA UNIVERSITY OF SCIENCE AND TECHNOLOGY</h4>
                    </div>
                    <div class="content">
                        <br><br>
                        <strong lng style="font-size: 20px;" >Verification Code</strong><br><hr>
                        <small>This verification code valid only for 2 minutes.</small> <br>
                        <strong style="font-size: 20px;" >'.$code.'</strong>
                    </div>
                </div>
            ';
            if($mail->send()){
                return true;
            }

        }

    }

?>

