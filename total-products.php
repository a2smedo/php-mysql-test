<?php
session_start();
$title = "TOTAL PRODUCTS";
include "inc/header.php";
include "inc/conn.php";

if (isset($_POST['submit'])) {
  $prod_no = $_POST['prod_no'];

  $sql = "SELECT * FROM products 
          WHERE quantityInStock >'$prod_no' 
          group by quantityInStock
          having quantityInStock between 100 and 5000
          order by quantityInStock";

  $errors = [];
  if (empty($prod_no)) {
    $errors[] = "Filed Is Required";
  } elseif (!is_numeric($prod_no)) {
    $errors[] = "Please Insert Number Not String";
  } elseif ($prod_no < 100 or $prod_no >= 5000) {
    $errors[] = "Please Insert Number Between 100 And 5000";
  } elseif ($prod_no >= 100 and $prod_no <= 5000) {
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
  }

  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
  }

  mysqli_close($conn);
}
?>

<section class="">
  <div class="container-fluid">
    <div class="row">
      <?php require_once "inc/sidNav.php";  ?>

      <div class="col-md pt-3">
        <h2 class="border-bottom w-50 py-2 mb-3"> <?= $title ?> </h2>
        <div class="row">
          <div class="col-md">
            <form method="POST">
              <div class="form-group">
                <input class="form-control" type="text" name="prod_no" placeholder="Enter a Number Between 100 And 5000">
              </div>
              <div class="form-group">
                <input class="btn btn-primary " type="submit" name="submit" value="GET PRODUCTS">
              </div>

            </form>
            <?php require_once "inc/errors.php"; ?>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col">
            <?php if (empty($prod_no)) { ?>
                <div> </div>
          
            <?php } else { ?>
              <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col"> Product Name </th>
                    <th scope="col"> Quantity In Stock</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($products ?? [] as $product => $val) { ?>
                    <tr>
                      <td> <?= $product + 1;  ?> </td>
                      <td><?= $val['productName']; ?></td>
                      <td><?= $val['quantityInStock']; ?></td>
                    </tr>

                  <?php } ?>

                </tbody>
              </table>
            <?php } ?>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>


<?php require_once "inc/footer.php"; ?>