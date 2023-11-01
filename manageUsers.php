<?php
session_start();
require "connection.php";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Users | Admins | Glamour</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />

</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php
            $query = "SELECT * FROM `users`";
            $pageno;

            if (isset($_GET["page"])) {
                $pageno = $_GET["page"];
            } else {
                $pageno = 1;
            }

            $user_rs = Database::search($query);
            $user_num = $user_rs->num_rows;

            $results_per_page = 20;
            $number_of_pages = ceil($user_num / $results_per_page);

            $page_results = ($pageno - 1) * $results_per_page;
            $selected_rs =  Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

            $selected_num = $selected_rs->num_rows
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
                                        <a class="nav-link active" href="manageUsers.php">Manage Users</a>
                                        <a class="nav-link" href="manageProduct.php">Manage Products</a>
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
                                <?php
                                $image_rs = Database::search("SELECT * FROM `profile_img` WHERE 
                                `users_email`='".$selected_data["email"]."'");
                                $image_data = $image_rs->fetch_assoc();
                                
                                
                                ?>
                                <td class="fs-5">
                                    <?php
                            if(isset($image_data["path"])){
                                ?>
                                
                        <img src="<?php echo $image_data["path"]?>" style="height: 40px;margin-left: 80px;" />
                                <?php
                            }else{
                                ?>
                                
                        <img src="resources/person.svg" style="height: 40px;margin-left: 80px;" />
                        
                                <?php

                            }
                            ?>
                            </td>
                                <td class="fs-5"><?php echo $selected_data["fname"] . " " . $selected_data["lname"]; ?></td>
                                <td class="fs-5"><?php echo $selected_data["email"]?></td>
                                <td class="fs-5"><?php echo $selected_data["mobile"]?></td>
                                <td class="fs-5"><?php echo $selected_data["joined_date"]?></td>
                                <td class="fs-5"><?php

                                if ($selected_data["status"] == 1) {
                                ?>
                                    <button id="ub<?php echo $selected_data['email']; ?>" class="btn btn-danger" onclick="blockUser('<?php echo $selected_data['email']; ?>');">Block</button>
                                <?php
                                } else {
                                ?>
                                    <button id="ub<?php echo $selected_data['email']; ?>" class="btn btn-success" onclick="blockUser('<?php echo $selected_data['email']; ?>');">Unblock</button>
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



        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>