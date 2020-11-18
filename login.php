<?php
session_start();
$title = "Login";
require_once "inc/header.php";
?>

<section class="py-3 login" style="height: 87.3vh;">
  <div class="container">
    <div class="row py-5">
      <div class="col-md-6 mx-auto text-center">
        <h2>Please LogIn</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 mx-auto">
        <form action="h-login.php" method="post">

          <div class="form-group mb-3">
            <label for="userName">User Name</label>
            <input type="text" id="userName" name="userName" class="form-control" placeholder="User Name">
          </div>
          <div class="form-group mb-3-">
            <label for="password">Password</label>
            <input type="password" id="password" name="pass" class="form-control" placeholder="Password">
          </div>
          <div class="form-group">
            <input type="submit" value="Login" name="login" class="btn btn-block btn-success">
          </div>

        </form>

        <?php require_once("inc/errors.php"); ?>
      </div>
    </div>
  </div>
</section>





<?php require_once "inc/footer.php"; ?>