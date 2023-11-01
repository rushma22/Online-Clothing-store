<!DOCTYPE html>
<html lang="en">
<head>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
 <div class="row text-danger" >
    <div class="col-lg-4">
    <a href="home.php"><div class="col-4 logo mt-3 mb-3" style="height:80px;"></div></a>
    </div>

    <div class=" col-lg-4 offset-sm-2 offset-2 offset-lg-3 mt-5 fs-2 ">
    <nav class="navbar navbar-expand-lg" style="">
  <div class="container-fluid" >
   
    <div class="collapse navbar-collapse"  id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 " style="font-size:20px;">
        <li class="nav-item active">
          <a class="nav-link" style="color:purple; font-size:15px;" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" style="color:purple; font-size:15px;" href="#">Blog</a>
        </li>
        <li class="nav-item ">
          <a class="nav-link active " aria-current="page"  style="color:purple; font-size:15px;" href="#">Contact</a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle me-5 " style="color:purple; font-size:15px;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Shop Now
          </a>
          <ul class="dropdown-menu" style="color:purple; font-size:20px;">
            <li><a class="dropdown-item" href="#">Men's</a></li>
            <li><a class="dropdown-item" href="#">Women's</a></li>
            <li><a class="dropdown-item" href="#">Kids and Babies</a></li>
          </ul>
        </li>

        <li class="nav-item"  style="height:10px" >
          <a class="nav-link active  me-3"aria-current="page" style="color:purple; font-size:15px;" href="cart.php"><i class="bi bi-cart3 fs-5"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active  me-3" aria-current="page" style="color:purple; font-size:15px;" href="watchlist.php"><i class="bi bi-heart fs-5"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active  me-3" aria-current="page" style="color:purple; font-size:15px;" href="userprofile.php"><i class="fs-5 bi bi-person-circle"></i></a>
        </li>
        <li class="nav-item col-4">
          <a class="nav-link active" style="color:purple; font-size:15px;" aria-current="page" href="#">
          <?php

                if(isset($_SESSION["u"])){
                    $session_data = $_SESSION["u"];

                    ?>
                    <span class="text-lg-start"><b>Welcome </b>
                    <?php echo $session_data["fname"]." ";?> !
                </span> 
                    <?php

                }else{
                    ?>
                    
                    <a href="index.php" class="text-decoration-none text-warning fw-bold">
                        Sign In or Register
                    </a>

                    <?php
                }

                ?>
                        </a>
        </li>

        
      </ul>
      
    </div>
  </div>
</nav>
    </div>
<hr>
    
 </div>
</body>
</html>


