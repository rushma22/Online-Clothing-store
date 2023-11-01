<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glamour | My Profile</title>

    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="resources/logo.svg" type="image/x-icon">


</head>
<body>

<div class="container-fluid">
    <div class="row">

    <?php
    
    session_start();

    require "header.php";

    require "connection.php";
 
    if(isset($_SESSION["u"])){

        $email = $_SESSION["u"]["email"];

        $details_rs = Database::search("SELECT * FROM `users` INNER JOIN `gender` ON 
        users.gender_id = gender.id WHERE `email` = '".$email."'"); //only 1 result

        $image_rs = Database::search("SELECT * FROM `profile_img` WHERE 
        `users_email`='".$email."'"); //only 1 result

        $address_rs = Database::search("SELECT * FROM `users_has_address` INNER JOIN 
        `city` ON users_has_address.city_city_id = city.city_id INNER JOIN district
         ON city.district_district_id = district.district_id INNER JOIN province 
         ON district.province_province_id=province.province_id WHERE 
        `users_email`='".$email."'"); //only 1 result

        $details_data = $details_rs->fetch_assoc(); // read only that row of column
        $image_data = $image_rs->fetch_assoc();
        $address_data = $address_rs->fetch_assoc();

        ?>
        
        <div class="col-12 bg=primary">
        <div class="row ">
            
            <div class="col-12 bg-body mt-4 mb-4 ">
                <div class="row g-2">

                <div class="col-md-3 border-end">
                    <div class="user2">
                    <div class="d-flex text-center p-3 py-5 flex-column align-items-center">
                        
                        
                    <?php

                    if(empty($image_data["path"])){

                        ?>
                         <img src="resources/person.svg" class="rounded mt-5" style="width:150px" alt="">

                        <?php

                    }else{
                        ?>
                         <img src="<?php echo $image_data["path"];?>" class="rounded mt-5" style="width:150px" alt="">
                        <?php
                    }
                    
                    ?>
                    
                   
                        <br>
                        <span class="fw-bold "><?php echo $details_data["fname"]." ".$details_data["lname"];?></span><br>
                        <span class="fw-bold text-black-50"><?php echo $email;?></span>

                        <input type="file" class="d-none" id="profileImage">
                        <label for="profileImage" class="btn btn-primary mt-5">Update Profile Image</label>

                    </div>
                    
                    </div>
                </div>

                <div class="col-md-5 border-end">
                    <div class="p-3 py-5 user2 text-light">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <h4 class="fw-bold">Profile Settings</h4>
                        </div>

                        <div class="row mt-4">
                            <div class="col-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" id="fname" value="<?php echo $details_data["fname"]?>">

                            </div>

                            <div class="col-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lname" value="<?php echo $details_data["lname"]?>">

                            </div>
                            <div class="col-12">
                                <label  class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile" value="<?php echo $details_data["mobile"]?>">

                            </div>
                            <div class="col-12">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <input value="<?php echo $details_data["password"]?>" id="iup" type="password" class="form-control"aria-label="Recipient's username" aria-describedby="basic-addon2" >
                                    <span class="input-group-text" id="basic-addon2">
                                        <button class="btn btn-outline-secondary" type="button" id="up" onclick="showPassword3();">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    </span>
                                </div>
                                    
                            </div>

                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="text" id="email" class="form-control" value="<?php echo $email; ?>">

                            </div>

                            <div class="col-12">
                                <label   class="form-label">Registered Date</label>
                                <input type="text" class="form-control"  readonly value="<?php echo $details_data["joined_date"]?>">

                            </div>

                            <?php 
                            
                            if(empty($address_data["line1"])){
                                ?>
                            <div class="col-12">
                                <label   class="form-label">Address Line 01</label>
                                <input type="text" id="line1" class="form-control" placeholder="Enter Address Line 01">
                            </div>

                                <?php
                            }else{
                                ?>
                            <div class="col-12">
                                <label   class="form-label">Address Line 01</label>
                                <input type="text" id="line1" class="form-control"value="<?php echo $address_data["line1"];?>">
                            </div>

                                <?php
                            }

                            if(empty($address_data["line2"])){
                                ?>
                            <div class="col-12">
                                <label   class="form-label">Address Line 02</label>
                                <input type="text" id="line2" class="form-control" placeholder="Enter Address Line 02">
                            </div>

                                <?php
                            }else{
                                ?>
                            <div class="col-12">
                                <label   class="form-label">Address Line 02</label>
                                <input type="text" id="line2" class="form-control"value="<?php echo $address_data["line2"];?>">
                            </div>

                                <?php
                            }

                            $province_rs = Database::search("SELECT * FROM `province`");
                            $district_rs = Database::search("SELECT * FROM `district`");
                            $city_rs = Database::search("SELECT * FROM `city`");

                            $province_num = $province_rs->num_rows;
                            $district_num = $district_rs->num_rows;
                            $city_num = $city_rs->num_rows;
                            
                            ?>


                            <div class="col-6">
                                <label   class="form-label">Province</label>
                                <select name="" id="province" class="form-select">
                                    <option value="0">Select Province</option>
                                    <?php
                                    
                                    for($x = 0; $x < $province_num; $x++){
                                        $province_data = $province_rs->fetch_assoc();
                                        ?>
                                        
                                    <option value="<?php echo $province_data["province_id"]; ?>"
                                    <?php
                                    if(!empty($address_data["province_province_id"])){
                                        if($province_data["province_id"] == $address_data["province_province_id"]){
                                            ?> selected <?php
                                        }
                                    }
                                    ?>>
                                       <?php echo $province_data["province_name"]; ?>
                                    </option>

                                        <?php
                                    }

                                    ?>
                                    
                                </select>

                            </div>

                            <div class="col-6">
                                <label   class="form-label">District</label>
                                <select name="" id="district" class="form-select">
                                    <option value="0">Select District</option>
                                    <?php
                                    
                                    for($x = 0; $x < $district_num; $x++){
                                        $district_data = $district_rs->fetch_assoc();
                                        ?>
                                        
                                    <option value="<?php echo $district_data["district_id"]; ?>"
                                    <?php
                                    if(!empty($address_data["district_district_id"])){
                                        if($district_data["district_id"] == $address_data["district_district_id"]){
                                            ?> selected <?php
                                        }
                                    }
                                    ?>>
                                       <?php echo $district_data["district_name"]; ?>
                                    </option>

                                        <?php
                                    }

                                    ?>
                                    
                                </select>

                            </div>

                            <div class="col-6">
                                <label   class="form-label">City</label>
                                <select name="" id="city" class="form-select">
                                    <option value="0">Select City</option>
                                    <?php
                                    
                                    for($x = 0; $x < $city_num; $x++){
                                        $city_data = $city_rs->fetch_assoc();
                                        ?>
                                        
                                    <option value="<?php echo $city_data["city_id"]; ?>"
                                    <?php
                                    if(!empty($address_data["city_city_id"])){
                                        if($city_data["city_id"] == $address_data["city_city_id"]){
                                            ?> selected <?php
                                        }
                                    }
                                    ?>>
                                       <?php echo $city_data["city_name"]; ?>
                                    </option>

                                        <?php
                                    }

                                    ?>
                                    
                                </select>

                            </div>

                            <?php
                            
                            if(empty($address_data["postal_code"])){
                                ?>
                            <div class="col-6">
                                <label   class="form-label">Postal Code</label>
                                <input type="text" id="pc" class="form-control" placeholder="Please enter postal code">

                            </div>
                                <?php
                            }else{
                                ?>
                            <div class="col-6">
                                <label   class="form-label">Postal Code</label>
                                <input type="text" id="pc" class="form-control" value="<?php echo $address_data["postal_code"];?>">

                            </div>
                                <?php
                            }
                            ?>

                            

                            <div class="col-12">
                                <label   class="form-label">Gender</label>
                                <input type="text" class="form-control" readonly value="<?php echo $details_data["gender_name"]?>">

                            </div>

                            <div class="col-12 d-grid mt-2">
                                <button class="btn btn-primary" onclick="updateProfile();">Update My Profile</button>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="col-11 col-lg-3 mx-3 user2 text-light p-5 ">
                        <div class="row">
                            <div class="col-12 ps-5 mt-3 fs-5">
                                <div class="row">
                                    <ul>
                                        <li class="pb-5"><a href="myproducts.php"
                                        class=" pb-5 fs-5 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">My Products</a></li>
                                        <li class="pb-5"><a href="addproduct.php"
                                        class=" pb-5 fs-5 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Add Products</a></li>
                                        <li class="pb-5"><a href="purchasedhistory.php"
                                        class=" pb-5 fs-5 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Purchased History</a></li>
                                        <li class="pb-5"><a href="messages.php"
                                        class=" pb-5 fs-5 link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Messages</a></li>
                                        <a href="" class="btn text-light col-12 fs-5"style="background-color:purple;" onclick="signout();" >Sign Out</a>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                </div>

            </div>


        </div>


    </div>
        
        <?php

    }else{

    }

    ?>
    
    <?php

    require "footer.php";
    
    
    ?>

    </div>


</div>




<script src="bootstrap.bundle.js"></script>
<script src="script.js"></script>
</body>
</html>
