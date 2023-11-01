<?php

session_start();
require "connection.php";

if(isset($_SESSION["u"])){
    $user = $_SESSION["u"]["email"];

    $total = 0;
    $subtotal = 0;
    $shipping = 0;
    
    ?>
    <!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>checkout | Glamour</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resources/logo.svg" />

</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php 
            include "header.php";
            ?>

                <div class="col-12 pt-2 mb-3">
                <div class="col-12 text-center" style="background-image: linear-gradient(to right, rgb(174, 0, 174) , rgba(64, 0, 109, 0.353));">
                                    <label class="form-label fs-1 fw-bolder text-light">CHECKOUT</label>
                                </div>
                </div>

                <div class="col-12  mb-3">
                    <div class="row">

                        <div class="col-12">
                            <hr />
                        </div>

                        <?php
                         $cart_rs =  Database::search("SELECT * FROM `cart` WHERE `users_email`='".$user."'");
                         $cart_num = $cart_rs->num_rows;
                         $cart_data = $cart_rs->fetch_assoc();
                         
                         $product_rs = Database::search("SELECT * FROM `product` WHERE 
                         `id`='".$cart_data["product_id"]."'");

                         $product_data = $product_rs->fetch_assoc();
                         $total = $total + ($product_data['price'] * $cart_data["qty"] );

                         $address_rs = Database::search("SELECT district.district_id AS `did` FROM users_has_address INNER JOIN 
                         `city` ON users_has_address.city_city_id = city.city_id INNER JOIN `district` 
                         ON city.district_district_id = district.district_id WHERE `users_email`='".$user."'"); 

                         $address_data = $address_rs->fetch_assoc();

                         $ship = 0;

                         if($address_data["did"] == 2){
                             $ship = $product_data["delivery_fee_colombo"];
                             $shipping = $shipping + $product_data["delivery_fee_colombo"];

                         }else{
                             $ship = $product_data["delivery_fee_other"];
                             $shipping = $shipping + $product_data["delivery_fee_other"];
                         }
                     

                         if($cart_num == 0 ){
                            ?>
                            <!-- Empty View -->
                            <div class="col-12  text-center">
                                        <div class="row">
                                            <div class="col-12 "></div>
                                            <div class="col-12 ">
                                                <label class="form-label fs-5 fw-bold">Your cart is currently empty</label>
                                            </div>
                                            <div class="offset-lg-5 col-12 col-lg-2 d-grid mb-3">
                                                
                                                <a href="home.php" class="text-light btn fs-5 fw-bold" style="background-image: linear-gradient(to left, rgb(174, 0, 174) , rgba(64, 0, 109, 100));">Return to shop</a>
                                            </div>
                                        </div>
                                    </div>
                            <!-- Empty View -->
                            <?php
                         }else{
                            ?>
                            <!-- products -->
                            <div class="col-md-5 offset-lg-1 " style="margin-right:200px;">
                            <div class="p-3 py-5 text-dark">
                                
                                <div class="d-flex  align-items-center mb-3">
                                    <h4 class="fw-bold">BILLING DETAILS</h4>
                                </div>

                        <div class="row mt-4 text-light">
                            <div class="col-6 mb-3">
                                <input type="text" class="form-control" id="fname" placeholder="First Name">

                            </div>

                            <div class="col-6 mb-3">
                                <input type="text" class="form-control" id="lname" placeholder="Last Name">

                            </div>
                            <div class="col-6 mb-3">
                                <input type="text" class="form-control" id="mobile" placeholder="Phone">

                            </div>
                            

                            <div class="col-6">
                                <input type="text" id="email" class="form-control" placeholder="Email">

                            </div>

                            
                            <div class="col-12 mb-3">
                                <input type="text" id="line1" class="form-control" placeholder="Address Line 01">
                            </div>

                                
                            
                            <div class="col-12 mb-3">
                                <input type="text" id="line2" class="form-control" placeholder=" Address Line 02">
                            </div>


                                <?php
                                
                               

                            $province_rs = Database::search("SELECT * FROM `province`");
                            $district_rs = Database::search("SELECT * FROM `district`");
                            $city_rs = Database::search("SELECT * FROM `city`");

                            $province_num = $province_rs->num_rows;
                            $district_num = $district_rs->num_rows;
                            $city_num = $city_rs->num_rows;
                            
                            ?>


                            <div class="col-6 mb-3">
                                <select name="" id="province" class="form-select">
                                    <option value="0">Select Province</option>
                                    <?php
                                    
                                    for($x = 0; $x < $province_num; $x++){
                                        $province_data = $province_rs->fetch_assoc();
                                        ?>
                                        
                                    <option value="<?php echo $province_data["province_id"]; ?>"
                                    <?php
                                    if(!empty($address_data["province_province_id"])){
                                        if($province_data["province_id"] == $address_data["province_province_id"]){
                                            ?> selected <?php
                                        }
                                    }
                                    ?>>
                                       <?php echo $province_data["province_name"]; ?>
                                    </option>

                                        <?php
                                    }

                                    ?>
                                    
                                </select>

                            </div>

                            <div class="col-6 mb-3">
                                <select name="" id="district" class="form-select">
                                    <option value="0">Select District</option>
                                    <?php
                                    
                                    for($x = 0; $x < $district_num; $x++){
                                        $district_data = $district_rs->fetch_assoc();
                                        ?>
                                        
                                    <option value="<?php echo $district_data["district_id"]; ?>"
                                    <?php
                                    if(!empty($address_data["district_district_id"])){
                                        if($district_data["district_id"] == $address_data["district_district_id"]){
                                            ?> selected <?php
                                        }
                                    }
                                    ?>>
                                       <?php echo $district_data["district_name"]; ?>
                                    </option>

                                        <?php
                                    }

                                    ?>
                                    
                                </select>

                            </div>

                            <div class="col-6 mb-3">
                                <select name="" id="city" class="form-select">
                                    <option value="0">Select City</option>
                                    <?php
                                    
                                    for($x = 0; $x < $city_num; $x++){
                                        $city_data = $city_rs->fetch_assoc();
                                        ?>
                                        
                                    <option value="<?php echo $city_data["city_id"]; ?>"
                                    <?php
                                    if(!empty($address_data["city_city_id"])){
                                        if($city_data["city_id"] == $address_data["city_city_id"]){
                                            ?> selected <?php
                                        }
                                    }
                                    ?>>
                                       <?php echo $city_data["city_name"]; ?>
                                    </option>

                                        <?php
                                    }

                                    ?>
                                    
                                </select>

                            </div>

                            <div class="col-6">
                                <input type="text" id="pc" class="form-control" placeholder="Postal code">

                            </div>
                            <div class="col-12 text-dark">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" onclick="changeshipping();">
                                <label class="form-check-label" for="flexCheckDefault">
                                Ship to a different address?
                                </label>
                            </div>
                            
                            
                            <!-- shipping to other -->
                           
                            <div class="row mt-4 text-light" style="display:none;" id="shipping">
                            
                            <div class="col-6 mb-3">
                                <input type="text" class="form-control" id="fname" placeholder="First Name">

                            </div>

                            <div class="col-6 mb-3">
                                <input type="text" class="form-control" id="lname" placeholder="Last Name">

                            </div>
                            <div class="col-6 mb-3">
                                <input type="text" class="form-control" id="mobile" placeholder="Phone">

                            </div>
                            

                            <div class="col-6 mb-3">
                                <input type="text" id="email" class="form-control" placeholder="Email">

                            </div>

                            
                            <div class="col-12 mb-3">
                                <input type="text" id="line1" class="form-control" placeholder="Address Line 01">
                            </div>

                                
                            
                            <div class="col-12 mb-3">
                                <input type="text" id="line2" class="form-control" placeholder=" Address Line 02">
                            </div>

                                <?php
                            
                                ?>
                            

                                <?php
                            

                            $province_rs = Database::search("SELECT * FROM `province`");
                            $district_rs = Database::search("SELECT * FROM `district`");
                            $city_rs = Database::search("SELECT * FROM `city`");

                            $province_num = $province_rs->num_rows;
                            $district_num = $district_rs->num_rows;
                            $city_num = $city_rs->num_rows;
                            
                            ?>


                            <div class="col-6 mb-3">
                                <select name="" id="province" class="form-select">
                                    <option value="0">Select Province</option>
                                    <?php
                                    
                                    for($x = 0; $x < $province_num; $x++){
                                        $province_data = $province_rs->fetch_assoc();
                                        ?>
                                        
                                    <option value="<?php echo $province_data["province_id"]; ?>"
                                    <?php
                                    if(!empty($address_data["province_province_id"])){
                                        if($province_data["province_id"] == $address_data["province_province_id"]){
                                            ?> selected <?php
                                        }
                                    }
                                    ?>>
                                       <?php echo $province_data["province_name"]; ?>
                                    </option>

                                        <?php
                                    }

                                    ?>
                                    
                                </select>

                            </div>

                            <div class="col-6 mb-3">
                                <select name="" id="district" class="form-select">
                                    <option value="0">Select District</option>
                                    <?php
                                    
                                    for($x = 0; $x < $district_num; $x++){
                                        $district_data = $district_rs->fetch_assoc();
                                        ?>
                                        
                                    <option value="<?php echo $district_data["district_id"]; ?>"
                                    <?php
                                    if(!empty($address_data["district_district_id"])){
                                        if($district_data["district_id"] == $address_data["district_district_id"]){
                                            ?> selected <?php
                                        }
                                    }
                                    ?>>
                                       <?php echo $district_data["district_name"]; ?>
                                    </option>

                                        <?php
                                    }

                                    ?>
                                    
                                </select>

                            </div>

                            <div class="col-6 mb-3">
                                <select name="" id="city" class="form-select">
                                    <option value="0">Select City</option>
                                    <?php
                                    
                                    for($x = 0; $x < $city_num; $x++){
                                        $city_data = $city_rs->fetch_assoc();
                                        ?>
                                        
                                    <option value="<?php echo $city_data["city_id"]; ?>"
                                    <?php
                                    if(!empty($address_data["city_city_id"])){
                                        if($city_data["city_id"] == $address_data["city_city_id"]){
                                            ?> selected <?php
                                        }
                                    }
                                    ?>>
                                       <?php echo $city_data["city_name"]; ?>
                                    </option>

                                        <?php
                                    }

                                    ?>
                                    
                                </select>

                            </div>
                                    <!-- shipping to other -->
                            <div class="col-6">
                                <input type="text" id="pc" class="form-control" placeholder="Postal code">

                            </div>
                                </div>
                            
                            </div>
                        </div>
                        
                    </div>
                </div>

                            <!-- products -->
                            <?php
                         }
                        
                        ?>

                            

                            
                        
                        <!-- summary -->
                        <div class="col-12 col-lg-3 border border-2 ms-5" >
                            <div class="row">

                                <div class="col-12">
                                    <label class="form-label fs-3 fw-bold">Summary</label>
                                </div>

                                <div class="col-12">
                                    <hr />
                                </div>

                                <div class="col-6 mb-3">
                                    <span class="fs-6 fw-bold">PRICE DETAILS (<?php echo $cart_num; ?> ITEMS)</span>
                                </div>

                                <div class="col-6 text-end mb-3">
                                    <span class="fs-6 fw-bold">Rs. <?php echo $total; ?> .00</span>
                                </div>

                                <div class="col-6">
                                    <span class="fs-6 fw-bold">Shipping</span>
                                </div>

                                <div class="col-6 text-end">
                                    <span class="fs-6 fw-bold">Rs. <?php echo $shipping; ?> .00</span>
                                </div>

                                <div class="col-12 pt-5">
                                <div class="input-group mb-3 border border-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">APPLY COUPEN</span>
                                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <hr />
                                </div>

                                <div class="col-6 mt-2">
                                    <span class="fs-4 fw-bold">Total</span>
                                </div>

                                <div class="col-6 mt-2 text-end">
                                    <span class="fs-4 fw-bold">Rs. <?php echo $total + $shipping; ?> .00</span>
                                </div>

                                <div class="col-12 mt-3 mb-3 d-grid">
                                    <button onclick="paynow(<?php echo $pid?>);" class="btn btn-success fs-5 fw-bold" type="submit" id="payhere-payment">PAY NOW</button>
                                </div>

                            </div>
                        </div>
                        <!-- summary -->
                     
                    </div>
                </div>

            <?php include "footer.php"; ?>

        </div>
    </div>

    
    <script src="bootstrap.bundle.js"></script>
    
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
    <script src="script.js"></script>
    
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

</body>

</html>
    <?php
}

?>