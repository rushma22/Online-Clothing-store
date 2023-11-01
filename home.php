<?php 

session_start();

require "connection.php";  

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="icon" href="resources/logo.svg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Glamour</title>

</head>
<body>
    <div class="container-fluid">
        <div class="row">


        <?php require "header.php"; ?>

        <div class="col-12 justify-content-center">
            <div class="row mb-3">
               
                <div class="col-12 col-lg-6 offset-1">
                <div class="input-group mb-3 mt-3">
                <select class="form-select  border-3" style="max-width:250px;" name="" id="c">
                    
                    <option value="0">Search By Category</option>
                    
                    <?php
    
                    $category_rs = Database::search("SELECT * FROM `category`");
                    $category_num = $category_rs->num_rows;
    
                    for($x = 0; $x < $category_num; $x++){
                        $category_data = $category_rs->fetch_assoc();
                        ?>
                        
                            <option value="<?php echo $category_data["cat_id"];?>">
                                <?php echo $category_data["cat_name"];?>
                            
                            </option>
                        
                        
                        <?php
                    }
                    
                    ?>
    
    
                    </select>
                    <input type="text" class="form-control border-3" aria-label="Text input with dropdown button" id="kw">
                </div>
            </div>
            <div class="col-3 col-md-2 col-lg-1 d-grid">
                <button class="btn btn-primary mt-3 mb-3" onclick="basicSearch(0);"><i class="bi bi-search"></i></button>
            </div>

            <div class="col-12 col-lg-2 mt2 mt-lg-4 text-center text-lg-start">
                <a href="advancedSearch.php" class="text-decoration-none link-secondary fw-bold">Advanced Search</a>
            </div>
        </div>

        <hr>
        <div class="col-12" id="basicSearchResult">

            <div class="row">
            <div id="carouselExampleFade" class="carousel slide carousel-fade offset-2 col-8" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner" >
                            <div class="carousel-item active" data-bs-interval="1500">
                            <img src="img/img7.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item" data-bs-interval="1500">
                            <img src="img/img8.jpg" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item" data-bs-interval="1500">
                            <img src="img/img9.jpg" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
            </div>
        </div>
                <hr>
        <div class="row m-5">
        <div class="col-12 text-center h2 fw-bold mb-5" style="color:purple;">
                    _____ SHOP NOW _____
            </div>
            <div class="col-4 container">
                <img src="img/man1.jpg" class="d-block w-100  h-100" alt="...">
                <div class="overlay">
                <div class="text">Men's Fashion</div>
                </div>
            </div>
            
            <div class="col-4 container">
                <img src="img/img13.jpg" class="d-block w-100  h-100" alt="...">
                <div class="overlay">
                    <div class="text">Women's Fashion</div>
                </div>
            </div>

            <div class="col-4 container">
            <img src="img/kids.jpg" class="d-block w-100 h-100" alt="...">
            <div class="overlay">
                <div class="text">Kids Fashion</div>
            </div>
            </div>
            
        </div>

        <hr>
        <!-- Category names -->

        <?php

$c_rs = Database::search("SELECT * FROM `category` " );
$c_num = $c_rs->num_rows;

for($y = 0; $y < $c_num; $y++) {

    $c_data = $c_rs->fetch_assoc();

?>

            <div class="col-12 text-center h2 fw-bold mb-5 py-4 text-dark" style="background-image: linear-gradient(to right, rgb(174, 0, 174) , rgba(64, 0, 109, 0.353));">
            <?php echo $c_data["cat_name"];?>
            </div>

    <!-- Products -->

    <div class="col-12 mb-3">
        <div class="row border ">
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
                                    <button class="col-3 btn btn-light btn-outline-danger mt-2"onclick="addToCart(<?php echo $product_data['id']?>)">
                                        <i class="bi bi-cart3 text-wight fs-5" ></i>
                                    </button>
                                    <button  onclick="addToWatchList(<?php echo $product_data['id']?>)" class="col-3 offset-5 btn btn-outline-info mt-2 border border-primary">
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
        <?php include "footer.php";?>
    </div>
    </div>
    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>
</html>
