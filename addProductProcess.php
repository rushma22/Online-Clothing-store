<?php 

session_start();
require "connection.php";


Database::iud("SET foreign_key_checks = 0");

$email = $_SESSION["u"]["email"];

$category = $_POST["ca"];
$brand = $_POST["b"];
$model = $_POST["m"];
$title = $_POST["t"];
$qty = $_POST["qty"];
$cost = $_POST["cost"];
$dwc = $_POST["dwc"];
$doc = $_POST["doc"];
$desc = $_POST["desc"];


$mhb_rs = Database::search("SELECT * FROM `brand_has_model` WHERE 
`brand_brand_id` = '".$brand."' AND `model_model_id`='".$model."'");

$mhb_id ;

if($mhb_rs->num_rows > 0){
    $mhb_data = $mhb_rs->fetch_assoc();
    $mhb_id = $mhb_data["id"];
}else {

    Database::iud("INSERT INTO `brand_has_model`(`brand_brand_id`,`model_model_id`) 
    VALUES ('".$brand."' , '".$model."') ");

    $mhb_id = Database::$connection->insert_id;

}



$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

$status = 1;

Database::iud("INSERT INTO `product`(`price`,`qty`,`description`,`title1`,`datetime_added`,`delivery_fee_colombo`,`delivery_fee_other`,
`category_cat_id`,`brand_has_model_id`,`status_status_id`,`users_email`) 
VALUES ('".$cost."','".$qty."','".$desc."','".$title."','".$date."','".$dwc."','".$doc."',
'".$category."','".$mhb_id."','".$status."','".$email."')");

$product_id = Database::$connection->insert_id;

$length = sizeof($_FILES);

if($length <= 3 && $length > 0){

    $allowed_img_extentions = array("image/jpg","image/jpeg","image/png","image/svg+xml");

    for($x = 0;$x < $length;$x++){
        if(isset($_FILES["img".$x])){

            $img_file = $_FILES["img".$x];
            $file_extention = $img_file["type"];

            if(in_array($file_extention,$allowed_img_extentions)){

                $new_img_extention;

                if($file_extention == "image/jpg"){
                    $new_img_extention = ".jpg";
                }else if($file_extention == "image/jpeg"){
                    $new_img_extention = ".jpeg";
                }else if($file_extention == "image/png"){
                    $new_img_extention = ".png";
                }else if($file_extention == "image/svg+xml"){
                    $new_img_extention = ".svg";
                }

                $file_name = "resources//products//".$title."_".$x."_".uniqid().$new_img_extention;
                move_uploaded_file($img_file["tmp_name"],$file_name);

                Database::iud("INSERT INTO `product_img`(`img_path`,`product_id`) VALUES ('".$file_name."','".$product_id."')");

               

            }else{
                echo ("Not an allowed image type.");
            }

        }
    }

    echo ("success");

}else{
    echo ("Invalid Image Count");
}

Database::iud("SET foreign_key_checks = 1");

?>