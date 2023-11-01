<?php

require "connection.php";

$search_text = $_POST["t"];
$category = $_POST["cat"];
$brand = $_POST["b"];
$model = $_POST["mo"];
$from = $_POST["pf"];
$to = $_POST["pt"];
$sort = $_POST["s"];

$query = "SELECT * FROM `product`";

$status = 0;

if($sort == 0){

    if(!empty($search_text)){
        $query.= " WHERE `title1` LIKE '%".$search_text."%'";
        $status=1;
    }

    if($category != 0 && $status == 0){
        $query.= " WHERE `category_cat_id` = '".$category."'";
        $status=1;
    }else if($category != 0 && $status != 0){
        $query.= " AND `category_cat_id` = '".$category."'";
    }

    $pid = 0;
    if($brand != 0 && $model == 0){

        $modelHasBrand_rs = Database::search("SELECT * FROM `brand_has_model` WHERE 
        `brand_brand_id`='".$brand."'");
        $modelHasBrand_num = $modelHasBrand_rs->num_rows;

        for($x = 0; $x < $modelHasBrand_num; $x++){
            $modelHasBrand_data = $modelHasBrand_rs->fetch_assoc();
            $pid = $modelHasBrand_data["id"];
        }

        if($status == 0){
            $query.= " WHERE `brand_has_model_id`='".$pid."'" ;
            $status=1;

        }else if($status != 0){
            $query.= " AND `brand_has_model_id`='".$pid."'" ;

        }

    }else if($brand == 0 && $model != 0){

        $modelHasBrand_rs = Database::search("SELECT * FROM `brand_has_model` WHERE `model_model_id`='".$model."' 
        AND `brand_brand_id`='".$brand."'");

        $modelHasBrand_num = $modelHasBrand_rs->num_rows;

        for($x = 0; $x < $modelHasBrand_num; $x++){
            $modelHasBrand_data = $modelHasBrand_rs->fetch_assoc();
            $pid = $modelHasBrand_data["id"];
        }

        if($status == 0){
            $query.= " WHERE `brand_has_model_id`='".$pid."'" ;
            $status=1;

        }else if($status != 0){
            $query.= " AND `brand_has_model_id`='".$pid."'" ;

        }



    }else if($brand != 0 && $model != 0){
        $modelHasBrand_rs = Database::search("SELECT * FROM `brand_has_model`  WHERE `model_model_id`='".$model."'");

        $modelHasBrand_num = $modelHasBrand_rs->num_rows;

        for($x = 0; $x < $modelHasBrand_num; $x++){
            $modelHasBrand_data = $modelHasBrand_rs->fetch_assoc();
            $pid = $modelHasBrand_data["id"];
        }

        if($status == 0){
            $query.= " WHERE `brand_has_model_id`='".$pid."'" ;
            $status=1;

        }else if($status != 0){
            $query.= " AND `brand_has_model_id`='".$pid."'" ;

        }
    }

        

        if(!empty($from) && empty($to)){
            if($status == 0){
                $query.= " WHERE `price` >= '".$from."'" ;
                $status = 1;
                
            }else if($status != 0){
                $query.= " AND `price` >= '".$from."'" ;

            }

        }else if(empty($from) && !empty($to)){
            if($status == 0){
                $query.= " WHERE `price` <= '".$to."'" ;
                $status = 1;
                
            }else if($status != 0){
                $query.= " AND `price` <= '".$to."'" ;

            }

        }else if(!empty($from) && !empty($to)){
            if($status == 0){
                $query.= " WHERE `price` BETWEEN '".$from."' AND '".$to."' " ;
                $status = 1;
                
            }else if($status != 0){
                $query.= " AND `price` BETWEEN '".$from."' AND '".$to."'" ;

            }
        }


    

}else if($sort == 1){
    if(!empty($search_text)){
        $query.= " WHERE `title1` LIKE '%".$search_text."%' ORDER BY `price` ASC";
        $status=1;
    }

}else if($sort == 2){
    if(!empty($search_text)){
        $query.= " WHERE `title1` LIKE '%".$search_text."%' ORDER BY `price` DESC";
        $status=1;
    }

}else if($sort == 3){
    if(!empty($search_text)){
        $query.= " WHERE `title1` LIKE '%".$search_text."%' ORDER BY `qty` ASC";
        $status=1;
    }

}else if($sort == 4){
    if(!empty($search_text)){
        $query.= " WHERE `title1` LIKE '%".$search_text."%' ORDER BY `qty` DESC";
        $status=1;
    }

}

?>

<div class="row">
    <div class="text-center">
        <div class="row">
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
                                    $selected_rs = Database::search( $query . " LIMIT " . $results_per_page. " OFFSET ".$page_results. " ");

                                    $selected_num = $selected_rs->num_rows;

                                    for($x = 0; $x < $selected_num; $x++){
                                        $selected_data = $selected_rs->fetch_assoc();
                                        $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE 
                                            `product_id` = '".$selected_data["id"]."'");
                                            $product_img_data = $product_img_rs->fetch_assoc();

                                        ?>

                                    <!-- card -->
                                    <div class="card col-12 col-lg-2 mt-2 mb-2 me-3" style="width: 18rem;">
                                    <?php
                                    $c_rs = Database::search("SELECT * FROM `category` INNER JOIN `product` ON product.category_cat_id=category.cat_id 
                                    WHERE cat_id='".$selected_data['category_cat_id']."'");
                                    $c_num = $c_rs->num_rows;
                                    $c_data = $c_rs->fetch_assoc();
                                    ?>
                                    <div class="row">
                                    <img src="<?php echo $product_img_data["img_path"]; ?>" class="card-img-top" alt="...">

                                    </div>
                                    
                                            <div class="card-body ms-0 m-0">
                                                <h5 class="card-title fw-bold fs-6"><?php echo $selected_data["title1"] ?></h5>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item"><?php echo $c_data["cat_name"];?></li>
                                                <li class="list-group-item">Rs.<?php echo $selected_data["price"] ?></li>
                                            </ul>
                                            <div class="card-body">
                                                        <button class="col-3 btn btn-light btn-outline-danger mt-2"onclick="addToCart(<?php echo $selected_data['id']?>)">
                                                            <i class="bi bi-cart3 text-wight fs-5" ></i>
                                                        </button>
                                                        <button onclick="addToWatchList(<?php echo $selected_data['id']?>)" class="col-3 offset-5 btn btn-outline-info mt-2 border border-primary">
                                                        <i class="bi bi-heart text-dark fs-5"></i>
                                                        </button>
                                                        <button class="col-12 btn btn-light mt-2"onclick="addToCart(<?php echo $selected_data['id']?>)">
                                                        <a href="<?php echo "singleproductview.php?id=". ($selected_data["id"])?>" class="btn text-light"style="background-color:purple;" >Buy Now</a>
                                                        </button>
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
                                               onclick = "advancedSearch(<?php echo ($pageno - 1)?>);"
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
                                                    <a class="page-link" onclick= "advancedSearch(<?php echo ($y);?>);"><?php echo $y; ?></a>
                                                </li>
                                                <?php
                                            } else {
                                                ?>
                                                <li class="page-item">
                                                <a class="page-link"  onclick= "advancedSearch(<?php echo ($y);?>);"><?php echo $y; ?></a>
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
</div>