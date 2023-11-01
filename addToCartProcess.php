<?php

session_start();
require "connection.php";

if(isset($_SESSION["u"])){
    if(isset($_GET["id"])){

        $email = $_SESSION["u"]["email"];
        $pid= $_GET["id"];

        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '".$pid."' 
        AND `users_email`='".$email."'");

        $cart_num = $cart_rs->num_rows;

        if ($cart_num == 1){
            echo("Already exists");
        }else{
            Database::iud("INSERT INTO `cart`(`qty`,`users_email`,`product_id`) VALUES 
            ('1','".$email."','".$pid."')");
            echo("Added");
        }
        
    }

   
}

?>