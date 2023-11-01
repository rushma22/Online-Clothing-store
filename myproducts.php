<?php
 session_start();

 require "connection.php";

 if(isset($_SESSION["u"])){

    $email = $_SESSION["u"]["email"];

    $pageno;

?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Products | Glamour</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resources/logo.svg" />

</head>

<body style="background-color: #E9EBEE;">

    <div class="container-fluid">
        
        <div class="row">
            <?php require "header.php"?>
            <div class="col-12">
            <div class="row" style="background-image: linear-gradient(to right, rgb(190, 0, 174) , rgba(205, 43, 208, 0.603));">
                            <div class="col-2 mt-1 mb-1  text-center">

                            <?php
                            
                            $profile_image_rs = Database::search("SELECT * FROM `profile_img` 
                            WHERE `users_email`= '".$email."'");

                            if($profile_image_rs->num_rows ==1){

                                $profile_image_data = $profile_image_rs->fetch_assoc();

                                ?>
                                 <img src="<?php echo $profile_image_data["path"];?>" width="90px" height="90px" class="rounded-circle" />
                                <?php


                            }else{
                                ?>

                                <img src="resources/person.svg" width="90px" height="90px" class="rounded-circle" />
                                
                                <?php

                            }
                            
                            ?>
                        </div>
                        <div class="col-8 pt-4 text-center" >
                           <h1> My Products</h1>
                        </div>
                     </div>
                        <div class="col-12 col-lg-8">
                                <div class="row text-lg-start">
                                    <div class="col-3 mt-0 mt-lg-4  text-center">
                                        <span class="text-dark fw-bold">
                                        <?php echo $_SESSION["u"]["fname"]." ". $_SESSION["u"]["lname"];?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-3 text-center">
                                        <span class="text-black-50 fw-bold">
                                            <?php echo $email;?>
                                        </span>
                                    </div>
                            </div>
                <div class="col-12">
                
                <div class="row">

                <!-- filter -->
                <div class="col-11 col-lg-2 mx-3 my-3 border-end border-danger">
                        <div class="row">
                            <div class="col-12 mt-3 fs-5">
                                <div class="row">

                                    <div class="col-12">
                                        <label class="form-label fw-bold fs-3">Sort Products</label>
                                    </div>
                                    <div class="col-11">
                                        <div class="row">
                                            <div class="col-10">
                                                <input type="text" placeholder="Search..." class="form-control" id="s" />
                                            </div>
                                            <div class="col-1 p-1">
                                                <label class="form-label"><i class="bi bi-search fs-5"></i></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold">Active Time</label>
                                    </div>
                                    <div class="col-12">
                                        <hr style="width: 80%;" />
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="r1" id="n">
                                            <label class="form-check-label" for="n">
                                                Newest to oldest
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="r1" id="o">
                                            <label class="form-check-label" for="o">
                                                Oldest to newest
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <label class="form-label fw-bold">By quantity</label>
                                    </div>
                                    <div class="col-12">
                                        <hr style="width: 80%;" />
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="r2" id="h">
                                            <label class="form-check-label" for="h">
                                                High to low
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="r2" id="l">
                                            <label class="form-check-label" for="l">
                                                Low to high
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12 text-center mt-3 mb-3">
                                        <div class="row g-2">
                                            <div class="col-12 col-lg-6 d-grid">
                                                <button class="btn btn-success fw-bold" onclick="sort(0);">Sort</button>
                                            </div>
                                            <div class="col-12 col-lg-6 d-grid">
                                                <button class="btn btn-primary fw-bold" onclick="clearSort();">Clear</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center mt-3 mb-3">
                                        <div class="row g-2">
                                            <div class="col-12 d-grid">
                                            <a href="addproduct.php" class="btn text-light col-12 mt-2"style="background-color:purple;" >Add Product</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- filter -->
                    <!-- product -->
                    <div class="col-12 col-lg-9 mt-3 mb-3 bg-white">
                        <div class="row" id="sort">

                            <div class="offset-1 col-10 text-center">
                                <div class="row justify-content-center">

                                    <?php
                                    
                                    if(isset($_GET["page"])){
                                        $pageno = $_GET["page"];
                                    }else{
                                        $pageno = 1;
                                    }
                                    
                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `users_email`='".$email."'");
                                    $product_num = $product_rs->num_rows;

                                    $results_per_page = 6;
                                    $number_of_pages = ceil($product_num/$results_per_page);
                                    
                                    $page_results = ($pageno-1) * $results_per_page;
                                    $selected_rs = Database::search("SELECT * FROM `product` WHERE `users_email`='".$email."' 
                                    LIMIT ".$results_per_page." OFFSET ".$page_results." ");

                                    $selected_num = $selected_rs->num_rows;

                                    for($x = 0; $x < $selected_num; $x++){
                                        $selected_data = $selected_rs->fetch_assoc();

                                        ?>

                                        <!-- card -->
                                        <div class="card me-3 mt-3" style="width: 18rem;">
                                        <?php 
                                            $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE 
                                            `product_id` = '".$selected_data["id"]."'");
                                            $product_img_data = $product_img_rs->fetch_assoc();
                                            
                                            ?>
                                                <img src="<?php echo $product_img_data["img_path"]; ?>" class="card-img-top h-100" alt="...">
                                                <div class="card-body">
                                                <h5 class="card-title"><?php echo $selected_data["title1"]?></h5>
                                               
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                <li class="list-group-item">Rs.<?php echo $selected_data["price"]?></li>
                                                <li class="list-group-item"><?php echo $selected_data["qty"]?> items available</li>
                                                <li class="list-group-item">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" 
                                                        id="<?php echo $selected_data["id"]; ?>" 
                                                        onchange="changeStatus(<?php echo $selected_data['id']; ?>);"
                                                        <?php if($selected_data["status_status_id"] == 2){?> checked<?php } ?>/>
                                                        <label class="form-check-label fw-bold text-info  text-danger" for="<?php echo $selected_data["id"]; ?>">
                                                            <?php if($selected_data["status_status_id"] == 2){ ?>
                                                                Activate Product
                                                            
                                                            <?php }else{
                                                            ?>
                                                                Deactivate Product
                                                            <?php
                                                            }
                                                             ?>
                                                        </label>
                                                    </div>
                                                </li>
                                                </ul>
                                                <div class="card-body">
                                                    <div class="row">
                                                    <div class="col-12 col-lg-6 d-grid">
                                                                    <button class="btn fw-bold" style="background-color:purple; color:white;"onclick="sendId(<?php echo $selected_data['id']; ?>);">Update</button>
                                                                </div>
                                                                <div class="col-12 col-lg-6 d-grid">
                                                                    <button class="btn btn-danger fw-bold">Delete</button>
                                                                </div>
                                                
                                                </div>

                                                    </div>
                                                
                                                </div>
                                    <!-- card -->
                                        
                                        <?php
                                    }

                                    ?>

                                    

                                </div>
                            </div>

                            <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination pagination-lg justify-content-center">
                                        <li class="page-item">
                                            <a class="page-link" href="
                                            <?php if($pageno <=1){
                                                echo("#");
                                            }else{
                                                echo("?page=". ($pageno - 1) );
                                            }
                                            
                                            ?>
                                            
                                            " aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                        
                                        for($y = 1; $y <= $number_of_pages; $y++){
                                            if($y == $pageno){
                                                ?>
                                                <li class="page-item active">
                                                    <a class="page-link" href="<?php echo "?page=". ($y);?>"><?php echo $y; ?></a>
                                                </li>
                                                <?php
                                            } else {
                                                ?>
                                                <li class="page-item">
                                                <a class="page-link" href="<?php echo "?page=". ($y);?>"><?php echo $y; ?></a>
                                                </li>
                                                
                                                <?php
                                            }
                                        }

                                        
                                        ?>

                                       <li class="page-item">
                                            <a class="page-link" href="
                                            <?php if($pageno >= $number_of_pages){
                                                echo("#");
                                            }else{
                                                echo("?page=". ($pageno + 1) );
                                            }
                                            
                                            ?>

                                            " aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>
                    <!-- product -->

                </div>
            </div>
            <?php require "footer.php"?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
<?php

}

?>