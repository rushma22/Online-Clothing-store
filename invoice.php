<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice | Glamour</title>

    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css" />

    <link rel="icon" href="resources/logo.svg" />
</head>

<body class="mt-2" style="background-color: #f7f7ff;">

    <div class="container-fluid">
        <div class="row">
            <?php 
              session_start();
              
            
            include "header.php";
          
            require "connection.php";

            if (isset($_SESSION["u"])) {
                $umail = $_SESSION["u"]["email"];
                $oid = $_GET["id"];

                ?>
                 <div class="col-12 mb-3">
                <div class="col-12 justify-content-center">
                <div class="row">

                        <div class="col-12 py-4 text-center fw-bold text-light" style="background-image: linear-gradient(to right, rgb(190, 0, 174) , rgba(205, 43, 208, 0.603));" >
                           <h1>INVOICE</h1>
                        </div>

                        <div class="col-12 btn-toolbar justify-content-end mt-4">
                            <button class="btn border-dark me-2" onclick="printInvoice();"><i class="bi bi-printer-fill"></i> Print</button>
                            <button class="btn border-danger text-danger me-2"><i class="bi bi-filetype-pdf"></i> Export as PDF</button>
                         </div>

                         <div class="col-12 text-center">
                            
                            <h3>Thank you for your purchase from Glamour
                                <div class="logo mt-2" style="height:50px;"></div>
                            </h3>
                         </div>

                         <div class="col-12">
                            <hr>
                         </div>
                        <div class="col-12 p-5" id="page">
                            <div class="row">
                            <div class="col-6 mb-3" style="padding-left:280px;">
                            <?php
                            
                            $address_rs = Database::search("SELECT * FROM `users_has_address` WHERE `users_email`='".$umail."'");
                            $address_data =$address_rs->fetch_assoc();
    
                            $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='".$oid."'");
                            $invoice_data = $invoice_rs->fetch_assoc();
                            
                            
                            
                            ?>
                            <div class="row fw-bold">

                                    To: <?php echo $_SESSION["u"]["fname"]." ".$_SESSION["u"]["lname"]; ?>
                                    </div>
                                <div class="row">

                                <?php echo $address_data["line1"]." ".$address_data["line2"]; ?>
                                </div>
                                <div class="row">

                                <?php echo $umail; ?>
                                </div>
                                

                                <div class="row">
                                Invoice No. : <?php echo $invoice_data["id"]; ?>
                                </div>
                                <div class="row">

                                Date and time : <?php echo $invoice_data["date"]; ?>
                                </div>
                                
                            </div>
                            <div class="col-6 mb-3 justify-content-end" style="padding-right:280px;">
                            <div class="row">
                                <div class="col-12 text-end" style="color:purple;">
                                Glamour
                                </div>
                                
                                </div>
                                <div class="row">

                                <div class="col-12 text-end">
                                Peradeniya Rd, kandy
                                </div>
                                
                                </div>
                                <div class="row">

                                <div class="col-12 text-end">
                                +9478561548
                                </div>
                                
                                </div>
                                <div class="row">

                                <div class="col-12 text-end">
                                glamour@gmail.com
                                </div>
                                
                                </div>
                            </div>
                            <hr>
                            </div>
                        <div class="row">
                            
                            <div class="col-12"  style="padding-left:280px; padding-right:280px;">
                                <table class="table table-striped">
                                <thead class="table-info ">
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Order ID & Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$invoice_data["product_id"]."'");
                                        $product_data = $product_rs->fetch_assoc();
                                        ?>
                                    <th scope="row"><?php echo $invoice_data["id"]; ?></th>
                                    <td><?php echo $oid; ?>
                                    <span class="fw-bold"><?php echo $product_data["title1"]; ?></span>
                                </td>
                                    <td><?php echo $product_data["price"]; ?></td>
                                    <td><?php echo $invoice_data["qty"]; ?></td>
                                    <td>Rs. <?php echo $product_data["price"]; ?> .00</td>
                                    </tr>
                                    
                                </tbody>
                                </table>

                                <div class="row">
                                <div class="col-12" style="padding-left:680px; ">
                                
                                <table class="table table-striped">
                               
                                <tbody>
                                    <tr>
                                    <th scope="row">Subtotal</th>
                                    <td><?php echo $product_data["price"]; ?></td>
                                    </tr>
                                    <tr>
                                    <th scope="row">Delivery</th>
                                    <td><?php echo $product_data["delivery_fee_colombo"]; ?></td>
                                    </tr>
                                    <tr>
                                    <th scope="row">Total</th>
                                    <td><?php echo $product_data["delivery_fee_colombo"] + $product_data["price"];   ?></td>
                                    </tr>
                                </tbody>
                                </table>
                                
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        * Notice: Purchased items can be returned before 7 days of Delivery.
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12 text-center">
                                    Invoice was created on a computer and is valid without the Signature and Seal.
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
            }
            ?>

              

            <?php include "footer.php"; ?>
        </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>





