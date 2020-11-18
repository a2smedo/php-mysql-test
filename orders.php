<?php
session_start();
$title = "ORDERS";
include "inc/header.php";
include "inc/conn.php";

$limit = 11;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = $limit * ($page - 1);

$sql = "SELECT customers.customerName, orderdetails.quantityOrdered 
FROM customers JOIN orders JOIN orderdetails
ON customers.customerNumber = orders.customerNumber
AND orders.orderNumber = orderdetails.orderNumber
GROUP BY orders.orderNumber
limit $limit OFFSET $offset";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$result2 = $conn->query("SELECT COUNT(orderNumber) AS orderNum FROM orders");
$orderCount = $result2->fetch_all(MYSQLI_ASSOC);

$total = $orderCount[0]['orderNum'];
$pages = ceil($total / $limit);

$prev = $page - 1;
$next = $page + 1;


mysqli_close($conn);
?>

<?php if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true) { ?>

  <section class="orders ">
    <div class="container-fluid">

      <div class="row">

        <?php require_once "inc/sidNav.php"; ?>

        <div class="col-md pt-1">
          <h2 class="border-bottom w-25 py-2 mb-3"> <?= $title ?> </h2>

          <div class="row">
            <div class="col-md">

              <table class="table table-striped text-center">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col"> Client Name</th>
                    <th scope="col"> Client Orders</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($orders as $order => $val) { ?>
                    <tr>
                      <td> <?= $order + 1;  ?> </td>
                      <td><?= $val['customerName']; ?></td>
                      <td><?= $val['quantityOrdered']; ?></td>
                    </tr>

                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>


          <div class="row">
            <div class="col-md-6">
              <nav aria-label="Page navigation ">
                <ul class="pagination w-50">
                  <li class="page-item">
                    <?php if ($page > 1) { ?>
                      <a class="page-link" href="orders.php?page=<?= $prev ?>">Previous</a>
                    <?php } else { ?>
                      <a class="page-link" href="">Previous</a>
                    <?php } ?>

                  </li>
                  <?php for ($i = 1; $i <= $pages; $i++) :  ?>

                    <li class="page-item">
                        <a class="page-link" href="orders.php?page=<?= $i ?>">
                          <?= $i ?></a>
                      </li>
              
                  <?php endfor ?>

                  <li class="page-item">
                    <?php if ($page < $pages) { ?>
                      <a class="page-link" href="orders.php?page=<?= $next ?>">Next</a>
                    <?php } else { ?>
                      <a class="page-link" href="">Next</a>
                    <?php } ?>
                  </li>

                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php } ?>

<?php require_once "inc/footer.php"; ?>