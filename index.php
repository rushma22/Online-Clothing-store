<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GLAMOUR</title>
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="icon" href="resources/logo.svg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="main-body">

<div class="container-fluid vh-100 d-flex justify-content-center">
    <div class="row align-content-center">

    <!-- header -->

        <div class="col-12 col-lg-3">
            <div class="row">
                <div class="col-12 logo"></div>
                <div class="col-12">
                    <p class="text-center text-light title01">Feel The Glamour</p>
                </div>
            </div>
        </div>

    <!-- header -->

<!-- content -->

    <div class="col-12 p-3">
        <div class="row">
            <div class="d-none d-lg-block background"></div>

            <!-- signup box -->
            <div class="col-10 col-lg-6" id="signupbox"> 
                <div class="row g-2 text-light user1 ">
                    <div class="col-12">
                        <p class="title02 text-light">Create Your Account.</p>
                    </div>
                    <div class="col-12 d-none" id="msgdiv">
                        <div class="alert alert-info" role="alert" id="msg">
                                    
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">First Name</label>
                        <input class="form-control" type="text" placeholder="ex: Rushma" id="fname">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Last Name</label>
                        <input class="form-control" type="text" placeholder="ex: Safrin" id="lname">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email" placeholder="ex: RushSaf@gmail.com" id="email">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <input class="form-control" type="password" placeholder="ex: *******" id="password">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Mobile</label>
                        <input class="form-control" type="text" placeholder="ex: 0776640305" id="mobile">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Gender</label>
                        <select class="form-control" id="gender">
                            <option value="0">Select Your Gender</option>
                            <?php 
                            require "connection.php";

                            $rs = Database::search("SELECT * FROM `gender`");
                            $n = $rs->num_rows;

                            for ($x=0; $x < $n ; $x++) { 
                               $d = $rs->fetch_assoc();

                            ?>
                                <option value="<?php echo $d["id"]; ?>"> <?php echo $d["gender_name"];?></option>
                            <?php
         
                            }
                            
                            ?>
                            
                        </select>
                    </div>
                    <div class="col-12 col-lg-6 d-grid mt-3" >
                        <button class="btn btn-danger " onclick="signUppp();">Sign Up</button>
                    </div>
                    <div class="col-12 col-lg-6 d-grid mt-3">
                        <button class="btn btn-primary" onclick="changeView();">Already Have an Account? Sign In</button>
                    </div>
                </div>

            </div>
            <!-- signup box -->  
                            
            <!-- signin box -->
            <div class="col-12 col-lg-6 d-none" id="signinbox">
                <div class="row g-2 p-4 user1">
                    <div class="col-12">
                        <p class="title02 text-light">Sign in</p>
                    </div>
                            <?php
                                $email = "";
                                $password = "";

                                if (isset($_COOKIE["email"])) {
                                    $email = $_COOKIE["email"];
                                }

                                if (isset($_COOKIE["password"])) {
                                    $password = $_COOKIE["password"];
                                }
                            ?>

                              <div class="col-12 text-light">
                                  <label class="form-label">Email</label>
                                  <input class="form-control" type="email" id="email2" value="<?php echo $email; ?>" placeholder="ex:Jhon@gmail.com" />
                              </div>

                              <div class="col-12 text-light">
                                  <label class="form-label">Password</label>
                                  <input class="form-control" type="password" id="password2" value="<?php echo $password; ?>" placeholder="12345678" />
                              </div>
                <div class="col-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="rememberme">
                        <label class="form-check-label text-light" for="rememberme">
                        Remember Me
                        </label>
                    </div>      
                </div>

                <div class="col-12">
                    <div class="row">
                        <div class="col-3"  style="margin-right:350px;">

                        <p><a class="link-opacity-100 text-info" href="#" onclick="forgotPassword();">Forgot Password?</a></p>
                        </div>
                        <div class="col-3">

                        <p><a class="link-opacity-100 text-warning" href="admin.php">Admin? Login</a></p>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-lg-6 d-grid mt-3" >
                        <button class="btn btn-warning" onclick="signin();">Sign In</button>
                    </div>
                    <div class="col-12 col-lg-6 d-grid mt-3">
                        <button class="btn btn-danger" onclick="changeView();">New to Glamour? Join Now</button>
                    </div>

            </div>
            <!-- signin box -->

        </div>
    </div>

<!-- content -->

            <!-- modal -->
            <div class="modal" tabindex="-1" id="forgotPasswordModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Forgot Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <label for="" class="form-label">New Password</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" id="np">
                                    <button class="btn btn-outline-secondary" type="button" id="npb" onclick="showPassword();"><i class="bi bi-eye-fill"></i></button>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Retype New Password</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" id="rnp">
                                    <button class="btn btn-outline-secondary" type="button" id="rnpb" onclick="showPassword2();"><i class="bi bi-eye-fill"></i></button>
                                </div>
                            </div>

                            <div>
                                <label for="" class="form-label">Verification Code</label>
                                <input type="text" class="form-control" id="vc">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="resetPassword();">Reset Password</button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- modal -->

<!-- footer -->

<div class="col-12 d-large-block fixed-bottom">
    <p class="text-center">&copy; 2023 Glamour.lk || All Rights Reserved</p>
</div>

<!-- footer -->
    </div>
</div>

    <script src="bootstrap.js"></script>
    <script src="script.js"></script>
    
</body>
</html>
