<?php
session_start();
$title = "Home";
require_once "inc/header.php";

?>


  
<?php if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true) { ?>
  <section class="home">
    <div class="container-fluid">
      <div class="row">
        
        <?php require_once "inc/sidNav.php"; ?>

        <main id="main" role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 ">
          
          <h1> Welcome To MYSQL</h1>
        
         
        </main>
      </div>

    </div>

  </section>

<?php } else{?>
  <section class="home1">

  </section>
<?php }?>


<?php require_once "inc/footer.php"; ?>