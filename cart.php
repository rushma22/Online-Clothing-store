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

    <title>Cart | Glamour</title>

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
                                    <label class="form-label fs-1 fw-bolder text-light">My Cart  <i class="bi bi-cart4 fs-1 text-light"></i></label>
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

                            <div class="col-12 col-lg-9">
                                <div class="row">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-center">
                                    <div class="col-lg-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                <th  class="fs-4" scope="col">PRODUCT</th>
                                                
                                                <th  class="fs-4" scope="col">TITLE</th>
                                                <th  class="fs-4" scope="col">PRICE</th>
                                                <th  class="fs-4" scope="col">QUANTITY</th>
                                                
                                                <th  class="fs-4" scope="col">&nbsp;</th>
                                                </tr>
                                            </thead>

                                <?php
                                for($x=0;$x<$cart_num;$x++){
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
                    
                                            // for($x=0;$x<$cart_num;$x++){
                                            //     $cart_data = $cart_rs->fetch_assoc();

                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$cart_data["product_id"]."'");
                                                $product_num = $product_rs->num_rows;

                                                //for($x = 0; $x < $product_num;  $x++){
                                                    $product_data = $product_rs->fetch_assoc();
                                                    ?>
                                                    <tbody>
                                                        <tr>
                                                        <td >
                                                        <div class="card col-12 col-lg-2 mt-2 mb-2" style="width: 10rem;">

                                                                <?php

                                                                $img_rs = Database::search("SELECT * FROM `product_img` WHERE 
                                                                `product_id` = '".$product_data['id']."'");

                                                                $img_data = $img_rs->fetch_assoc();

                                                                ?>
                                                                    <img src="<?php echo $img_data["img_path"]; ?>" class="card-img-top" alt="...">
                                                        </div>
                                                        </td>
                                                        <td  class="fs-5 pt-5"><?php echo $product_data["title1"] ?></td>
                                                        <td class="fs-5  pt-5">Rs. <?php echo $product_data["price"] ?></td>
                                                        <td class="fs-5  pt-5">
                                                        <div class="row">
                                                            <div class="col-12 my-2">
                                                                
                                                                <div class="row g-2">

                                                                    <div class="ms-2 col-4 border border-1 border-secondary overflow-hidden 
                                                        float-left mt-1 position-relative product-qty">
                                                                        <div class="col-12">
                                                                            
                                                                            
                                                                            <input type="text" class="border-0 fs-5 fw-bold text-start" style="outline: none;" 
                                                                            pattern="[0-9]" value="1" 
                                                                            onkeyup='check_value(<?php echo $product_data["qty"]; ?>);' id="qty_input" />

                                                                            <div class="position-absolute qty-buttons border-0">
                                                                                <div class="justify-content-center d-flex flex-column align-items-center qty-inc">
                                                                                    <i class="bi bi-caret-up-fill text-dark " onclick='qty_inc(<?php echo $product_data["qty"]; ?>);'></i>
                                                                                </div>
                                                                                <div class="justify-content-center d-flex flex-column align-items-center qty-dec">
                                                                                    <i class="bi bi-caret-down-fill text-dark" onclick='qty_dec();'></i>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                        </td>
                                                                        <td class="fs-5  pt-5">
                                                                        <button type="button" class="btn-close" aria-label="Close" onclick="removeFromCart(<?php echo $cart_data['cart_id']; ?>);"></button>
                                                                        </td>

                                                        </tr>
                                                        
                                                     </tbody>
                                                     <?php
                                                    //  }
                                                     ?>
                                            </div>
                                        </div>
                                    <?php

                                }
                                
                                ?>

                                    </table>
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
                        <div class="col-12 col-lg-3 border border-2">
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
                                    <button class="btn fs-5 fw-bold" style="background-color:#D3D3D3;" onclick="checkout();">PROCEED TO CHECKOUT</button>
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
    <script src="script.js"></script>

    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
</body>

</html>
    <?php
}

?>





