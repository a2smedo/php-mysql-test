<?php
session_start();
require_once "inc/conn.php";

//global $userInfo;

if (isset($_POST['login'])) {
  $userName = trim($_POST['userName']);
  $pass = trim($_POST['pass']);
  $sql = "SELECT * FROM `customers` WHERE `contactFirstName`='$userName'
          AND `password`='$pass'";

  $result = mysqli_query($conn, $sql);

  //Validation
  $errors = [];
  if (empty($userName) ) {
    $errors[] = "User Name is Required";
  } 
  if(empty($pass)){
    $errors[] = "Password is Required";
  }

  //Is user Register
  else {
    if ($result) {
      $row = mysqli_num_rows($result);
      if ($row > 0) {
        $userInfo = mysqli_fetch_array($result);
      }else {
        $errors[] = "Username or Password Not Registered!";
      }
    }
  }
  
  //Session 
  if (empty($errors)) {
    $_SESSION['isLogin'] = true;
    $_SESSION['userName'] = $userInfo['contactFirstName'];
    header("location: index.php");
  } else {
    $_SESSION['errors'] = $errors;
    header("location: login.php");
  }
  mysqli_close($conn);
}
