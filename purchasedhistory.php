<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Purchasing History | eShop</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php 
            session_start();
            include "header.php";
            
            require "connection.php";
            if (isset($_SESSION["u"])) {
                $mail = $_SESSION["u"]["email"];

                $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `users_email`='" . $mail . "'");
                $invoice_num = $invoice_rs->num_rows;
            ?>

<div class="col-12">
                    <div class="row">
                        <div class="col-12 border border-1 border-primary rounded mb-2">
                            <div class="row">

                                <div class="col-12 text-center" style="background-image: linear-gradient(to right, rgb(174, 0, 174) , rgba(64, 0, 109, 0.353));">
                                    <label class="form-label fs-1 fw-bolder text-light">Purchased History</label>
                                </div>

                                <div class="col-12">
                                    <hr />
                                </div>

                                

                                <?php

                                 if($invoice_num ==0){
                                    ?>
                                    <!-- empty view -->
                                    <div class="col-12  text-center">
                                        <div class="row">
                                            <div class="col-12 "></div>
                                            <div class="col-12 ">
                                                <label class="form-label fs-5 fw-bold">You have not purchased anything</label>
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
                                                <th  class="fs-4" scope="col">DATE PURCHASED</th>
                                                
                                                <th  class="fs-4" scope="col">&nbsp;</th>
                                                </tr>
                                            </thead>

                                            <?php
                                            for($x = 0; $x < $invoice_num; $x++){
                                                $invoice_data = $invoice_rs->fetch_assoc();
                                                


                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$invoice_data["product_id"]."'");
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
                                                        <td class="fs-5  pt-5">Rs. <?php echo $invoice_data["total"] ?></td>
                                                        <td class="fs-5  pt-5"><?php echo $invoice_data["date"] ?></td>
                                                        
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



            <?php
            }?>
            <?php include "footer.php"; ?>

        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>