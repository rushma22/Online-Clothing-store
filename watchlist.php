<?php
session_start();
require "connection.php";

if(isset($_SESSION["u"])){
    ?>
    <!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Watchlist | Glamour</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php";


            ?>

                <div class="col-12">
                    <div class="row">
                        <div class="col-12 border border-1 border-primary rounded mb-2">
                            <div class="row">

                                <div class="col-12 text-center" style="background-image: linear-gradient(to right, rgb(174, 0, 174) , rgba(64, 0, 109, 0.353));">
                                    <label class="form-label fs-1 fw-bolder text-light">Watchlist &hearts;</label>
                                </div>

                                <div class="col-12">
                                    <hr />
                                </div>

                                

                                <?php
                                $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE
                                 `users_email`='".$_SESSION["u"]["email"]."'");
                                 $watchlist_num = $watchlist_rs->num_rows;

                                 if($watchlist_num ==0){
                                    ?>
                                    <!-- empty view -->
                                    <div class="col-12  text-center">
                                        <div class="row">
                                            <div class="col-12 "></div>
                                            <div class="col-12 ">
                                                <label class="form-label fs-5 fw-bold">Your watchlist is currently empty</label>
                                            </div>
                                            <div class="offset-lg-5 col-12 col-lg-2 d-grid mb-3">
                                                
                                                <a href="home.php" class="text-light btn fs-5 fw-bold" style="background-image: linear-gradient(to left, rgb(174, 0, 174) , rgba(64, 0, 109, 100));">Return to shop</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- empty view -->
                                    <?php
                                 }else{ 
                                    ?>
                                    <div class="container-fluid">
                                    <div class="row d-flex justify-content-center">
                                        
                                        <div class="col-lg-12">
                                        <div class="p-5">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                <th  class="fs-4" scope="col">PRODUCT</th>
                                                
                                                <th  class="fs-4" scope="col">TITLE</th>
                                                <th  class="fs-4" scope="col">PRICE</th>
                                                <th  class="fs-4" scope="col">STOCK</th>
                                                
                                                <th  class="fs-4" scope="col">&nbsp;</th>
                                                </tr>
                                            </thead>

                                            <?php
                                            for($x = 0; $x < $watchlist_num; $x++){
                                                $watchlist_data = $watchlist_rs->fetch_assoc();


                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$watchlist_data["product_id"]."'");
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
                                                        <td class="fs-5  pt-5"><?php echo $product_data["qty"] ?> Items Available</td>
                                                        <td class="fs-5  pt-5">
                                                        <div class="row mb-3">
                                                            <button class="btn btn-warning text-light fw-bold" >
                                                                ADD TO CART
                                                            </button>
                                                         </div>
                                                         <div class="row mb-3">
                                                            <button class="btn btn-success text-light fw-bold" style="background-image: linear-gradient(to bottom left, rgb5, 146, 0.118) , rgba(200, 15, 242, 0.053));">
                                                                BUY NOW
                                                            </button>
                                                         </div>
                                                         <div class="row">
                                                            <button onclick="removeFromWatchlist(<?php echo $watchlist_data['id']; ?>);" class="btn btn-danger text-light fw-bold" style="background-image: linear-gradient(to bottom left, rgb5, 146, 0.118) , rgba(200, 15, 242, 0.053));">
                                                               REMOVE
                                                            </button>
                                                         </div>
                                                        </td>
                                                        </tr>
                                                     </tbody>
                                                     <?php
                                                     }
                                                     ?>
                                        </table>
                                        </div>
                                        </div>  
    
                                        </div>
                                    </div>
                                    <?php
                                    
                                 }
                                ?>

                                    
                                
                                    <!-- have products -->
                                    
                                    <!-- have products -->


                            </div>
                        </div>
                    </div>
                </div>

            <?php include "footer.php"; ?>

        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>
    <?php
}
?>



