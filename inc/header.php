<?php //session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Link => Font  -->
  <!-- Bootstrap Css -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <!-- FontAwesome Css -->
  <link rel="stylesheet" href="css/all.min.css">
  <!-- Style Css -->
  <link rel="stylesheet" href="css/style.css">

  <title> <?php echo $title; ?></title>
</head>

<body>


 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
   <div class="container">
     
 
    <a class="navbar-brand" href="index.php">MYSQL&PHP </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <?php if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true) { ?>

          <li class="nav-item ">
            <a class="nav-link" href="#"><?= $_SESSION['userName'] ?></a>
          </li>

          <!-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Manage System
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="vip-clients.php">Vip Clients</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li> -->


          <li class="nav-item ">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>



        <?php } else { ?>
          <li class="nav-item ">
            <a class="nav-link" href="login.php">Login</a>
          </li>
        <?php }  ?>
      </ul>

    </div>

    </div>
  </nav>