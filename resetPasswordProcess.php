<?php

require "connection.php";

 $email = $_POST["e"];
 $new_pw = $_POST["np"];
 $retype_pw = $_POST["rnp"];
 $v_code = $_POST["vc"];

if(empty($email)){
    echo("Please enter your email");
}else if(empty($new_pw)){
   echo ("Please enter a new password");
}else if(strlen($new_pw) < 5 || strlen($new_pw) > 20 ){
    echo ("Invalid New Password");
}else if(empty($retype_pw)){
    echo ("Please retype a enw password");
}else if($new_pw != $retype_pw){
    echo("Password does not match");
}else if (empty($v_code)){
    echo("Please neter your verification code");
}else{

    $rs = Database::search("SELECT * FROM `users` WHERE `email`='".$email."' 
    AND `verification_code`='".$v_code."'");

    $n = $rs->num_rows;

    if($n == 1){

        Database::iud("UPDATE `users` SET `password`='".$new_pw."' WHERE 
        `email`='".$email."' AND `verification_code`='".$v_code."'");

        echo ("Success");

    }else{
        echo("Invalid user details.");
    }
}



?>