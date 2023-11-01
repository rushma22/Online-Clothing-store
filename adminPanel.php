<?php

session_start();

require "connection.php";

if (isset($_SESSION["au"])) {

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Admin Panel | eShop</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resource/logo.svg" />
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

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
                                        <a class="nav-link active"  aria-current="page" href="#">Dashboard</a>
                                        <a class="nav-link" href="manageUsers.php">Manage Users</a>
                                        <a class="nav-link" href="manageProduct.php">Manage Products</a>
                                    </nav>
                                </div>
                                <div class="col-12 mt-5">
                                    <hr class="border border-1 border-dark" />
                                    <h4 class="text-dark fw-bold">Selling History</h4>
                                    <hr class="border border-1 border-dark" />
                                </div>
                                <div class="col-12 mt-3 d-grid">
                                    <label class="form-label fs-6 fw-bold text-dark">From Date</label>
                                    <input type="date" class="form-control" />
                                    <label class="form-label fs-6 fw-bold text-dark mt-2">To Date</label>
                                    <input type="date" class="form-control" />
                                    <a href="#" class="btn btn-primary mt-2">Search</a>
                                    <hr class="border border-1 border-dark" />
                                    <label class="form-label fs-6 fw-bold text-dark">Daily Sellings</label>
                                    <hr class="border border-1 border-dark" />
                                    <hr class="border border-1 border-dark" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-10">
                    <div class="row">

                        <div class="text-white fw-bold mb-1 mt-3">
                            <h2 class="fw-bold" style="color:purple;">Dashboard</h2>
                        </div>
                        <div class="col-12">
                            <hr />
                        </div>
                        <div class="col-12" style="background-color:#cdb8fc;background-image: linear-gradient(90deg,#cdb8fc 0%,#fc49f1 100%);">
                            <div class="row g-1 py-5">

                                <div class="col-6 col-lg-4 px-1 shadow">
                                    
                                    <div class="row g-1">
                                        <div class="col-12 bg-light text-black text-center rounded" style="height: 200px;">
                                        <div class="row">
                                        <i class="bi bi-people fs-1 mt-4"></i>
                                        </div>
                                            <br />
                                            <span class="fs-4 fw-bold">Total Users</span>
                                            <br />
                                            <?php

                                            $today = date("Y-m-d");
                                            $thismonth = date("m");
                                            $thisyear = date("Y");

                                            $a = "0";
                                            $b = "0";
                                            $c = "0";
                                            $e = "0";
                                            $f = "0";

                                            $invoice_rs = Database::search("SELECT * FROM `invoice`");
                                            $invoice_num = $invoice_rs->num_rows;

                                            
                                            $user_rs = Database::search("SELECT * FROM `users`");
                                            $user_num = $user_rs->num_rows;
                                            

                                            for ($x = 0; $x < $invoice_num; $x++) {
                                                $invoice_data = $invoice_rs->fetch_assoc();

                                                $f = $f + $invoice_data["qty"]; //total qty

                                                $d = $invoice_data["date"];
                                                $splitDate = explode(" ", $d); //separate date from time
                                                $pdate = $splitDate[0]; //sold date

                                                if ($pdate == $today) {
                                                    $a = $a + $invoice_data["total"];
                                                    $c = $c + $invoice_data["qty"];
                                                }

                                                $splitMonth = explode("-", $pdate); //separate date as year,month & date
                                                $pyear = $splitMonth[0]; //year
                                                $pmonth = $splitMonth[1]; //month

                                                if ($pyear == $thisyear) {
                                                    if ($pmonth == $thismonth) {
                                                        $b = $b + $invoice_data["total"];
                                                        $e = $e + $invoice_data["qty"];
                                                    }
                                                }
                                            }

                                            ?>
                                            <span class="fs-5"> <?php echo $user_num; ?> Users</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1 shadow ">
                                    <div class="row g-1">
                                        <div class="col-12 bg-white text-black text-center rounded" style="height: 200px;">
                                        <div class="row">
                                            <i class="bi bi-cart3 fs-1 mt-4"></i>

                                        </div>
                                            <br />
                                            <span class="fs-4 fw-bold">Total Sellings</span>
                                            <br />

                                            <span class="fs-5"><?php echo $f; ?> Items</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1 shadow">
                                    <div class="row g-1">
                                        <div class="col-12 bg-light text-dark text-center rounded" style="height: 200px;">
                                        <div class="row">
                                            <i class="bi bi-currency-dollar fs-1 mt-4"></i>

                                        </div>
                                            <br />
                                            <span class="fs-4 fw-bold">Monthly Earnings</span>
                                            <br />
                                            <span class="fs-5">Rs. <?php echo $b; ?> .00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-12 ps-1 mt-3">
                                            
                                    <div class="row g-1">
                                        <div class="col-lg-4 my-5 fs-3 text-center">
                                        Total Users
                                        </div>
                                        
                                        <div class="col-lg-4 my-5 fs-3  text-center">
                                        Total Sellings
                                        </div>
                                        
                                        <div class="col-lg-4 my-5 fs-3 text-center">
                                        Monthly Earnings
                                        </div>
                                        <div class="col-lg-4">
                                        <div class="progress mb-3 mx-3" role="progressbar" aria-label="Example 20px high" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 20px">
                                       <div class="progress-bar" style="width: <?php echo $user_num/100; ?>%"></div>
                                        </div>
                                        </div>
                                        <div class="col-lg-4">
                                        <div class="progress mb-3  mx-3" role="progressbar" aria-label="Example 20px high" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 20px">
                                       <div class="progress-bar" style="width:<?php echo $f/100; ?>%"></div>
                                        </div>
                                        </div>
                                        <div class="col-lg-4">
                                        <div class="progress mb-3  mx-3" role="progressbar" aria-label="Example 20px high" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 20px">
                                       <div class="progress-bar" style="width: <?php echo $b/100; ?>%"></div>
                                        </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="col-12">
                            <hr />
                        </div>

                        <div class="col-12  shadow">
                            <div class="row">
                                <div class="col-12 col-lg-2 text-center my-3">
                                    <label class="form-label fs-4 fw-bold">Total Active Time</label>
                                </div>
                                <div class="col-12 col-lg-8 text-center my-3">
                                    <?php

                                    $start_date = new DateTime("2022-09-27 00:00:00");

                                    $tdate = new DateTime();
                                    $tz = new DateTimeZone("Asia/Colombo");
                                    $tdate->setTimezone($tz);

                                    $end_date = new DateTime($tdate->format("Y-m-d H:i:s"));

                                    $difference = $end_date->diff($start_date);

                                    ?>
                                    <label class="form-label fs-4 fw-bold">
                                        <?php

                                        echo $difference->format('%Y') . " Years " . $difference->format('%m') . " Months " .
                                            $difference->format('%d') . " Days " . $difference->format('%H') . " Hours " .
                                            $difference->format('%i') . " Minutes " . $difference->format('%s') . " Seconds ";
                                        ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        
                        

                    </div>
                </div>

            </div>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

    </html>

<?php

} else {
    echo ("You are Not a valid user");
}

?>