<?php

session_start();
require "connection.php";

if(isset($_GET["id"])){
    $pid = $_GET["id"];

    $user = $_SESSION["u"];

    $product_rs = Database::search("SELECT product.id,product.price,product.qty,product.description,product.title1,
    product.datetime_added,product.delivery_fee_colombo,product.delivery_fee_other,product.category_cat_id,
    product.brand_has_model_id,product.status_status_id,product.users_email,
    model.model_name AS mname, brand.brand_name AS bname FROM `product` INNER JOIN `brand_has_model` 
    ON brand_has_model.id = product.brand_has_model_id INNER JOIN `brand` ON 
    brand.brand_id=brand_has_model.brand_brand_id INNER JOIN `model` ON 
    model.model_id=brand_has_model.model_model_id WHERE product.id='".$pid."';");

    $product_num= $product_rs->num_rows;

    if($product_num == 1){
        $product_data = $product_rs->fetch_assoc();

        ?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title><?php echo $product_data["title1"]; ?> | Glamour</title>

            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
            <link rel="stylesheet" href="style.css" />

            <link rel="icon" href="resources/logo.svg" />
        </head>

        <body>

            <div class="container-fluid">
                <div class="row">
                    <?php include "header.php"; ?>

                    <div class="col-12 mt-0 bg-white singleProduct">
                        <div class="row">
                            <div class="col-12" style="padding: 10px;">
                                <div class="row">

                                    <div class="col-12 col-lg-2 order-2 order-lg-1">
                                        <ul>
                                            <?php 
                                            $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='".$pid."'");
                                            $img_num = $img_rs->num_rows;
                                            $img_list = array();

                                            if($img_num !=0){
                                                for($x = 0; $x < $img_num;$x++){
                                                    $img_data  = $img_rs->fetch_assoc();
                                                    $img_list[$x]= $img_data["img_path"];
                                                    ?>
                                                    <li class="d-flex flex-column justify-content-center align-items-center 
                                border border-1 border-secondary mb-1">
                                                    <img src="<?php echo $img_list["$x"];?>" id="product_img<?php echo $x;?>" 
                                                    onclick="changeMainImg(<?php echo $x; ?>);" 
                                                    class="img-thumbnail mt-1 mb-1" />
                                                </li>
                                                    <?php

                                                }
                                            }else {
                                                ?>
                                                 <li class="d-flex flex-column justify-content-center align-items-center 
                                border border-1 border-secondary mb-1">
                                                    <img src="resources/addproductimg.png" class="img-thumbnail mt-1 mb-1" />
                                                </li>
                                                <li class="d-flex flex-column justify-content-center align-items-center 
                                border border-1 border-secondary mb-1">
                                                    <img src="resources/addproductimg.png" class="img-thumbnail mt-1 mb-1" />
                                                </li>
                                                <li class="d-flex flex-column justify-content-center align-items-center 
                                border border-1 border-secondary mb-1">
                                                    <img src="resources/addproductimg.png" class="img-thumbnail mt-1 mb-1" />
                                                </li>
                                                
                                                <?php

                                            }
                                            ?>
                                        </ul>
                                    </div>

                                    <div class="col-lg-4 order-2 order-lg-1 d-none d-lg-block">
                                        <div class="row">
                                            <div class="col-12 align-items-center border border-1 
                                border-secondary">
                                                <div class="mainImg" id="mainImg"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6 order-3">
                                        <div class="row">
                                            <div class="col-12">

                                                <div class="row ">
                                                    <nav aria-label="breadcrumb">
                                                        <ol class="breadcrumb">
                                                            <li class="breadcrumb-item "><a href="home.php" class="link-dark link-underline-light">Home</a></li>
                                                            <li class="breadcrumb-item active" style="color:purple;" aria-current="page"><?php echo $product_data["title1"]?></li>
                                                        </ol>
                                                    </nav>
                                                </div>

                                                <div class="row ">
                                                    <div class="col-12 my-2">
                                                        <span class="fs-4 fw-bold text-dark"><?php echo $product_data["title1"]?></span>
                                                    </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-12 my-2">
                                                    <span class="fs-5 text-dark"><?php echo $product_data["description"]?></span>
                                                    </div>
                                                </div>

                                                
                                                <?php
                                                $price = $product_data["price"];
                                                $add = ($price/100)*10;
                                                $new_price = $price + $add;
                                                $diff = $new_price - $price;
                                                $percent = ($diff / $price) * 100;


                                                ?>


                                                <div class="row ">
                                                    <div class="col-12 my-2">
                                                        <span class="fs-4 text-dark fw-bold">Rs. <?php echo $price ?> .00</span>
                                                    </div>
                                                </div>
                                                

                

                                                <div class="row">
                                                    <div class="col-12">
                                                    <div class="row">
                                                                    <div class="col-4 overflow-hidden 
                                                        float-left mt-1 position-relative product-qty">
                                                                        
                                                                            
                                                                            
                                                                            <select class="form-select" aria-label="Default select example">
                                                                                <option selected>Select Size</option>
                                                                                <option value="1">Small</option>
                                                                                <option value="2">Medium</option>
                                                                                <option value="3">Large</option>
                                                                                </select>

                                                                        
                                                                    </div>
                                                                    </div>
                                                        <div class="row">
                                                            <div class="col-12 my-5">
                                                                
                                                                <div class="row g-2">

                                                                    <div class="ms-2 col-1 border border-1 border-secondary overflow-hidden 
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
                                                                    

                                                                    <div class="row">
                                                    <div class="col-12 my-2">
                                                        <div class="row">
                                                            <?php 
                                                            $user_rs = Database::search("SELECT * FROM `users` WHERE 
                                                            `email`='".$product_data["users_email"]."'");
                                                            $user_data = $user_rs->fetch_assoc();

                                                            
                                                            
                                                            ?>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                                    <div class="row">
                                                                        <div class="col-12 mt-5">
                                                                            <div class="row">
                                                                                <div class="col-4 d-grid">
                                                                                    
                                                                                    <button onclick="paynow(<?php echo $pid?>);" class="btn fw-bold" style="background-image: linear-gradient(to bottom right, rgb(0, 174, 75) ,rgba(73, 255, 133, 0.353));" id="payhere-payment" > Pay Now</button>
                                                                                </div>
                                                                                <!-- <div class="col-3 d-grid"> -->
                                                                                <button class="col-2 btn btn-light btn-outline-danger d-grid"onclick="addToCart(<?php echo $product_data['id']?>)">
                                                                                    <i class="bi bi-cart3 text-wight fs-5" ></i>
                                                                                </button>
                                                                                <!-- </div> -->
                                                                                <div class="col-1 d-grid">
                                                                                    <button onclick="addToWatchList(<?php echo $product_data['id']?>)" class="btn btn-light">
                                                                                        <i class="bi bi-heart-fill fs-4 text-danger"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 bg-white">
                                <div class="row d-block me-0 mt-4 mb-3 border-bottom border-1 border-dark">
                                    <div class="col-12 text-center py-3" style="background-image: linear-gradient(to right, rgb(174, 0, 174) , rgba(64, 0, 109, 0.353));">
                                        <span class="fs-1 fw-bold">RELATED ITEMS</span>
                                    </div>
                                </div>
                            </div>

                            

                            <!-- Category names -->

        <?php

$c_rs = Database::search("SELECT * FROM `category` INNER JOIN `product` ON product.category_cat_id=category.cat_id 
                          WHERE cat_id='".$product_data['category_cat_id']."'" );
$c_num = $c_rs->num_rows;

for($y = 0; $y < 1; $y++) {

    $c_data = $c_rs->fetch_assoc();

?>

            <div class="col-12 text-center h2 fw-bold mb-5 text-dark" >
            <?php echo $c_data["cat_name"];?>
            </div>

    <!-- Products -->

    <div class="col-12 mb-3">
        <div class="row border border-primary">
        <div class="col-12">
            <div class="row justify-content-center gap-2 ">

            <?php
                $product_rs = Database::search("SELECT * FROM `product` WHERE 
                `category_cat_id`='".$c_data["cat_id"]."' AND `status_status_id`='1'
                 ORDER BY `datetime_added` DESC LIMIT 4 OFFSET 0");

                 $product_num = $product_rs->num_rows;

                 for($x = 0; $x < $product_num;  $x++){
                    $product_data = $product_rs->fetch_assoc();

            ?>
                <div class="card col-12 col-lg-2 mt-2 mb-2" style="width: 18rem;">

                    <?php

                    $img_rs = Database::search("SELECT * FROM `product_img` WHERE 
                    `product_id` = '".$product_data['id']."'");

                    $img_data = $img_rs->fetch_assoc();
                    
                    ?>

        
                        <img src="<?php echo $img_data["img_path"]; ?>" class="card-img-top" alt="...">
                        <div class="card-body ms-0 m-0">
                            <h5 class="card-title fw-bold fs-6"><?php echo $product_data["title1"] ?></h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><?php echo $c_data["cat_name"];?></li>
                            <li class="list-group-item">Rs.<?php echo $product_data["price"] ?></li>
                        </ul>
                        <div class="card-body">
                                    <button class="col-3 btn btn-light btn-outline-danger mt-2" onclick="addToCart(<?php echo $product_data['id']?>)">
                                        <i class="bi bi-cart3 text-wight fs-5" ></i>
                                    </button>
                                    <button onclick="addToWatchList(<?php echo $product_data['id']?>)" class="col-3 offset-5 btn btn-outline-info mt-2 border border-primary">
                                    <i class="bi bi-heart text-dark fs-5"></i>
                                    </button>
                                    <a href="<?php echo "singleproductview.php?id=". ($product_data["id"])?>" class="btn text-light col-12 mt-2"style="background-color:purple;" >Buy Now</a>
                                    
                                   
                        </div>    
            </div>
                    
                    
            <?php


                 }
            ?>

            
        </div>
    </div>
</div>
</div>
    <!-- products -->
    


<?php
}

?>

<!-- Category names -->
                                        
                                  
                                </div>
                            </div>

                        

                            
                    </div>

                    <?php include "footer.php"; ?>
                </div>
            </div>

            <script src="bootstrap.bundle.js"></script>
            <script src="script.js"></script>
            <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
            
        </body>

        </html>
        
        
        <?php
    }else{
        ?><script> alert("Something went wrong")</script><?php
    }
}

?>
        
