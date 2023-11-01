<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin SignIn | Glamour</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resource/logo.svg" />
</head>

<body class="main-body1" >

    <div class="container-fluid" >
        <div class="row align-content-center">

            <div class="col-12">
                <div class="row">

                    <div class="col-12 logo mt-3"></div>
                    <div class="col-12">
                        <p class="text-center title01 text-light">Hi, Welcome to Glamour Admins.</p>
                    </div>

                </div>
            </div>

            <div class="col-12 p-5">
                <div class="row">

                    <div class="col-12 col-lg-6 d-block user1 text-light">
                        <div class="row g-3">
                            <div class="col-12">
                                <p class="title02">Sign In to your Account.</p>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="ex : Rushma@gmail.com" id="e" />
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn" onclick="adminVerification();" style="background-color:#dd63f2;">Send Verification Code</button>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <a href="index.php" class="btn link link-underline-opacity-0"  style="background-color:#df24ff">Back to Customer Log In</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--  -->

            <div class="modal" tabindex="-1" id="verificationModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Admin Verification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label">Enter Your Verification Code</label>
                            <input type="text" class="form-control" id="vcode">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="verify();">Verify</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--  -->

            <div class="col-12 fixed-bottom text-center text-danger">
                <p>&copy; 2023 Glamour.lk | All Rights Reserved</p>
            </div>

        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>