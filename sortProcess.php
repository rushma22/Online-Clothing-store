<?php

session_start();
require "connection.php";

$email = $_SESSION["u"]["email"];

$search = $_POST["s"];
$time = $_POST["t"];
$qty = $_POST["q"];

$query = "SELECT * FROM `product` WHERE `users_email` = '".$email."' ";

if(!empty($search)){
    $query .= " AND `title1` LIKE '%".$search."%'";
}


if ($time != "0") {
    if ($time == "1") {
        $query .= " ORDER BY `datetime_added` DESC";
    } else if ($time == "2") {
        $query .= " ORDER BY `datetime_added` ASC";
    }
}

if ($qty != "0") {
    if ($qty == "1") {
        if (strpos($query, 'ORDER BY') === false) {
            $query .= " ORDER BY `qty` DESC";
        } else {
            $query .= " , `qty` DESC";
        }
    } else if ($qty == "2") {
        if (strpos($query, 'ORDER BY') === false) {
            $query .= " ORDER BY `qty` ASC";
        } else {
            $query .= " , `qty` ASC";
        }
    }
}

?>

                    <div class="offset-1 col-10 text-center">
                                <div class="row justify-content-center">

                                    <?php
                                    
                                    if("0" != $_POST["page"]){
                                        $pageno = $_POST["page"];
                                    }else{
                                        $pageno = 1;
                                    }
                                    
                                    $product_rs = Database::search($query);
                                    $product_num = $product_rs->num_rows;

                                    $results_per_page = 6;
                                    $number_of_pages = ceil($product_num/$results_per_page);
                                    
                                    $page_results = ($pageno-1) * $results_per_page;
                                    $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " 
                                            OFFSET " . $page_results . " ");
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
                                                                    <button class="btn fw-bold" style="background-color:purple; color:white;">Update</button>
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
                                            <a class="page-link"
                                            <?php if($pageno <=1){
                                                echo("#");
                                            }else{
                                               ?>
                                               onclick = "sort(<?php echo ($pageno - 1)?>);"
                                               <?php
                                            }
                                            
                                            ?>
                                            
                                            aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php
                                        
                                        for($y = 1; $y <= $number_of_pages; $y++){
                                            if($y == $pageno){
                                                ?>
                                                <li class="page-item active">
                                                    <a class="page-link" onclick= "sort(<?php echo ($y);?>);"><?php echo $y; ?></a>
                                                </li>
                                                <?php
                                            } else {
                                                ?>
                                                <li class="page-item">
                                                <a class="page-link"  onclick= "sort(<?php echo ($y);?>);"><?php echo $y; ?></a>
                                                </li>
                                                
                                                <?php
                                            }
                                        }

                                        
                                        ?>
                                        

                                        <li class="page-item">
                                            <a class="page-link" 
                                            <?php if($pageno >= $number_of_pages){
                                                echo("#");
                                            }else{
                                                ?>
                                               onclick = "sort(<?php echo ($pageno + 1)?>);"
                                               <?php
                                            }
                                            
                                            ?>

                                             aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>