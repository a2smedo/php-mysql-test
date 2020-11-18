<?php
session_start();
$title = "search by Product id";
include "inc/header.php";
include "inc/conn.php";

if (isset($_POST['submit'])) {
  $id = trim($_POST['id']);

  $sql = "SELECT  orderdetails.productCode AS id, orderdetails.quantityOrdered AS total,
  products.productName AS pro_name, customers.customerName as customer_Name , customers.creditLimit AS credits, orders.orderNumber AS oreder_no
  FROM customers JOIN orders JOIN orderdetails JOIN products
  ON customers.customerNumber = orders.customerNumber
  AND orders.orderNumber = orderdetails.orderNumber
  AND orderdetails.productCode = products.productCode
  WHERE orderdetails.productCode = '$id'
  order by credits desc ";

  $result = mysqli_query($conn, $sql);


  $errors = [];
  if (empty($id)) {
    $errors[] = "ID Is Required";
  } elseif ($result) {
    $row = mysqli_num_rows($result);
    if ($row > 0) {
      $ids = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
      $errors[] = "ID Is Not  Defind";
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
      <?php require_once "inc/sidNav.php"; ?>

      <div class="col-md">
        <h2 class="border-bottom w-50 py-2 mb-3 text-uppercase"> <?= $title ?> </h2>
        <div class="row">
          <div class="col-md">
            <form method="post">
              <div class="form-group">
                <input type="text" class="form-control" name="id">
              </div>
              <div class="form-group d-flex justify-content-end">
                <input type="submit" class="btn btn-info" value="Search" name="submit">
              </div>
            </form>

            <?php require_once "inc/errors.php"; ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md">
            <?php if (!empty($id)) { ?>
              <table class="table table-striped text-center">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col"> Product ID </th>
                    <th scope="col"> Total Orders</th>
                    <th scope="col"> Product Name</th>
                    <th scope="col"> Client Name</th>
                    <th scope="col"> Credit Limit </th>
                    <th scope="col"> Order Number</th>

                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($ids ?? [] as $rich => $val) { ?>
                    <tr>
                      <td> <?= $rich + 1;  ?> </td>
                      <td><?= $val['id']; ?></td>
                      <td><?= $val['total']; ?></td>
                      <td><?= $val['pro_name']; ?></td>
                      <td><?= $val['customer_Name']; ?></td>
                      <td><?= $val['credits']; ?></td>
                      <td><?= $val['oreder_no']; ?></td>

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