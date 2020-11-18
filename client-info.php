<?php
session_start();
$title = "Client Info";
require_once "inc/header.php";
include "inc/conn.php";
global $client_info;

if (isset($_POST['submit'])) {
  $id = $_POST['id'];
  $sql = "SELECT * FROM customers WHERE `customerNumber`='$id'";
  $result = mysqli_query($conn, $sql);

  $errors = [];
  if (empty($id)) {
    $errors[] = "Client ID Is Required";
  } elseif (!is_numeric($id)) {
    $errors[] = "Please Insert Number Not String";
  } elseif ($result) {
    $row = mysqli_num_rows($result);
    if ($row <= 0) {
      $errors[] = "Client is not Defind";
    } else {
      $client_info = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
  }

  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
  }

  mysqli_close($conn);
}

?>
<?php if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true) { ?>

  <section class="client-info">
    <div class="container-fluid">

      <div class="row ">
        <?php require_once "inc/sidNav.php"; ?>

        <div class="col-md pt-2">

          <div class="row">
            <div class="col-md">
            <h2 class="border-bottom w-25 py-2 mb-3"> <?= $title ?> </h2>
              <form method="post">
                <div class="form-group">
                  <input type="text" class="form-control" name="id" placeholder="Enter Client ID">
                </div>
                <div class="form-group">
                  <input type="submit" name="submit" class="btn btn-primary float-right" value="Click Here">
                </div>
              </form>
            </div>
          </div>
          <div class="row pt-3">
            <div class="col-md">
              <div>
                <ul class="list-group">
                  <?php foreach ($client_info ?? []  as $value) { ?>
                    <li class="list-group-item">Client Number: <?= $value['customerNumber']; ?></li>
                    <li class="list-group-item">Client Name: <?= $value['customerName']; ?></li>
                    <li class="list-group-item">First name: <?= $value['contactFirstName']; ?></li>
                    <li class="list-group-item">Last Name: <?= $value['contactLastName']; ?></li>
                    <li class="list-group-item">Phone Number: <?= $value['phone']; ?></li>
                    <li class="list-group-item">Country: <?= $value['country']; ?></li>
                    <li class="list-group-item">City: <?= $value['city']; ?></li>
                    <li class="list-group-item">Address: <?= $value['addressLine1']; ?></li>
                    <li class="list-group-item">Postal Code: <?= $value['postalCode']; ?></li>
                    <li class="list-group-item">Sales EMP Number: <?= $value['salesRepEmployeeNumber']; ?></li>
                    <li class="list-group-item">ClientCredit Limit: <?= $value['creditLimit']; ?></li>

                  <?php } ?>

                </ul>

                <?php require_once "inc/errors.php"; ?>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
<?php } ?>

<?php require_once "inc/footer.php"; ?>