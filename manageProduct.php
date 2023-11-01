<?php
session_start();
require "connection.php";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Products | Admins | Glamour</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />

</head>

<body >

    <div class="container-fluid">
        <div class="row">
        <?php
            $query = "SELECT * FROM `product`";
            $pageno;

            if (isset($_GET["page"])) {
                $pageno = $_GET["page"];
            } else {
                $pageno = 1;
            }

            $product_rs = Database::search($query);
            $product_num = $product_rs->num_rows;

            $results_per_page = 20;
            $number_of_pages = ceil($product_num / $results_per_page);

            $page_results = ($pageno - 1) * $results_per_page;
            $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

            $selected_num = $selected_rs->num_rows;

            ?>
            <div class="col-12 col-lg-2">
                    <div class="row">
                        <div class="col-12 align-items-start vh-100">
                            <div class="row g-1 text-center">

                                <div class="col-12 mt-5">
                                    <h4 class="text-dark"><?php echo $_SESSION["au"]["fname"] . " " . $_SESSION["au"]["lname"]; ?></h4>
                                    <hr class="border border-1 border-dark" />
                                </div>
                                <div class="nav flex-column nav-pills me-3 mt-3" role="tablist" aria-orientation="vertical">
                                    <nav class="nav flex-column">
                                        <a class="nav-link "  aria-current="page" href="adminPanel.php">Dashboard</a>
                                        <a class="nav-link " href="manageUsers.php">Manage Users</a>
                                        <a class="nav-link active" href="manageProduct.php">Manage Products</a>
                                    </nav>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-10">
                    <div class="row">

                    <div class="text-white fw-bold mb-1 mt-3">
                            <h2 class="fw-bold" style="color:purple;">Manage Users</h2>
                        </div>
                        <div class="col-12">
                            <hr />
                        </div>
                        <div class="col-12 ">
                            <div class="row g-1">
                            <table class="table">
                            <thead>
                                <tr>
                                <th scope="col"class="fs-5" >#</th>
                                <th scope="col" class="text-center fs-5">Profile image</th>
                                <th scope="col" class="fs-5">User Name</th>
                                <th scope="col" class="fs-5">Email</th>
                                <th scope="col" class="fs-5">Mobile</th>
                                <th scope="col" class="fs-5">Registered Date</th>
                                <th scope="col" class="fs-5">&nbsp;</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                
                            for ($x = 0; $x < $selected_num; $x++) {
                                $selected_data = $selected_rs->fetch_assoc();

                            ?>
                                    <tr>
                                <th scope="row" class="fs-5"><?php echo $x + 1; ?></th>
                                <td onclick="viewProductModal('<?php echo $selected_data['id']; ?>');" >
                                <?php
                            $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_data["id"] . "'");
                            $image_num = $image_rs->num_rows;
                            if ($image_num == 0) {
                            ?>
                                <img src="img/girl1" style="height: 40px;margin-left: 80px;" />
                            <?php
                            } else {
                                $image_data = $image_rs->fetch_assoc();
                            ?>
                                <img src="<?php echo $image_data["img_path"]; ?>" style="height: 150px;margin-left: 0px;" />
                            <?php
                            }

                            ?>
                            </td>
                                <td class="fs-5" ><?php echo $selected_data["title1"] ?></td>
                                <td class="fs-5"><?php echo $selected_data["price"]?></td>
                                <td class="fs-5"><?php echo $selected_data["qty"]?></td>
                                <td class="fs-5"><?php echo $selected_data["datetime_added"]?></td>
                                <td class="fs-5"><?php

                                if ($selected_data["status_status_id"] == 1) {
                                ?>
                                    <button id="pb<?php echo $selected_data['id']; ?>" class="btn btn-danger" onclick="blockProduct('<?php echo $selected_data['id']; ?>');">Block</button>
                                <?php
                                } else {
                                ?>
                                    <button id="pb<?php echo $selected_data['id']; ?>" class="btn btn-success" onclick="blockProduct('<?php echo $selected_data['id']; ?>');">Unblock</button>
                                <?php

                                }

                                ?>
                                    </td>
                                </tr>
                                    
                                    
                                    <?php
                                
                                    }
                                ?>
                                
                                
                            </tbody>
                            </table>
                            </div>
                        </div>


                        
                        

                    </div>
                </div>

           


                <!-- modal 01 -->
                <div class="modal" tabindex="-1" id="viewProductModal<?php echo $selected_data["id"]?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold text-success"><?php echo $selected_data["title1"]; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="offset-4 col-4">
                                    <img src="resources/mobile_images/iphone12.jpg" class="img-fluid" style="height: 150px;" />
                                </div>
                                <div class="col-12">
                                    <span class="fs-5 fw-bold">Price :</span>&nbsp;
                                    <span class="fs-5">Rs. <?php echo $selected_data["price"]; ?> .00</span><br />
                                    <span class="fs-5 fw-bold">Quantity :</span>&nbsp;
                                    <span class="fs-5"><?php echo $selected_data["qty"]; ?> Products left</span><br />
                                    
                                    <span class="fs-5 fw-bold">Seller :</span>&nbsp;
                                    <span class="fs-5">Rushma </span><br />
                                    <span class="fs-5 fw-bold">Description :</span>&nbsp;
                                    <span class="fs-5"><?php echo $selected_data["description"]; ?> </span><br />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal 01 -->

            <?php

            

            ?>

            <!--  -->
            <div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-lg justify-content-center">
                        <li class="page-item">
                            <a class="page-link" href="
                                                <?php if ($pageno <= 1) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($pageno - 1);
                                                } ?>
                                                " aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php

                        for ($x = 1; $x <= $number_of_pages; $x++) {
                            if ($x == $pageno) {
                        ?>
                                <li class="page-item active">
                                    <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                </li>
                        <?php
                            }
                        }

                        ?>

                        <li class="page-item">
                            <a class="page-link" href="
                                                <?php if ($pageno >= $number_of_pages) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($pageno + 1);
                                                } ?>
                                                " aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!--  -->

            <hr />

            <div class="col-12 text-center">
                <h3 class="text-black-50 fw-bold">Manage Categories</h3>
            </div>

            <div class="col-12 mb-3">
                <div class="row gap-1 justify-content-center">

                    <?php
                    $category_rs = Database::search("SELECT * FROM `category`");
                    $category_num = $category_rs->num_rows;
                    for ($x = 0; $x < $category_num; $x++) {
                        $category_data = $category_rs->fetch_assoc();
                    ?>
                        <div class="col-12 col-lg-3 border border-danger rounded" style="height: 50px;">
                            <div class="row">
                                <div class="col-8 mt-2 mb-2">
                                    <label class="form-label fw-bold fs-5"><?php echo $category_data["cat_name"]; ?></label>
                                </div>
                                <div class="col-4 border-start border-secondary text-center mt-2 mb-2">
                                    <label class="form-label fs-4"><i class="bi bi-trash3-fill text-danger"></i></label>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="col-12 col-lg-3 border border-success rounded" style="height: 50px;" onclick="addNewCategory();">
                        <div class="row">
                            <div class="col-8 mt-2 mb-2">
                                <label class="form-label fw-bold fs-5">Add new Category</label>
                            </div>
                            <div class="col-4 border-start border-secondary text-center mt-2 mb-2">
                                <label class="form-label fs-4"><i class="bi bi-plus-square-fill text-success"></i></label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- modal 2 -->
            <div class="modal" tabindex="-1" id="addCategoryModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <label class="form-label">New Category Name : </label>
                                <input type="text" class="form-control" id="n"/>
                            </div>
                            <div class="col-12 mt-2">
                                <label class="form-label">Enter Your Email : </label>
                                <input type="text" class="form-control" id="e"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="verifyCategory();">Save New Category</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal 2 -->
            <!-- modal 3 -->
            <div class="modal" tabindex="-1" id="addCategoryVerificationModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Verification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 mt-3 mb-3">
                                <label class="form-label">Enter Your Verification Code : </label>
                                <input type="text" class="form-control" id="txt"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="saveCategory();">Verify & Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal 3 -->

        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>