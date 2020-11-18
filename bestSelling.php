<?php
session_start();
$title = "Best Selling";
require_once "inc/header.php";
require_once "inc/conn.php";

$limit = 11;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = $limit * ($page - 1);

$sql = "SELECT products.productName, orderdetails.quantityOrdered, (orderdetails.quantityOrdered * orderdetails.priceEach) AS total   FROM orderdetails JOIN products
ON orderdetails.productCode = products.productCode
ORDER BY orderdetails.quantityOrdered DESC
limit $limit OFFSET $offset ";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$result2 = $conn->query("SELECT COUNT(quantityOrdered) AS proNum FROM orderdetails");
$proCount = $result2->fetch_all(MYSQLI_ASSOC);

$total = $proCount[0]['proNum'];
$pages = ceil($total / $limit);

$prev = $page - 1;
$next = $page + 1;


mysqli_close($conn);
?>

<section class=" ">
  <div class="container-fluid">
    <div class="row">
      <?php require_once "inc/sidNav.php" ?>
      <div class="col-md">
        <h2 class="border-bottom w-25 py-2 mb-3 text-uppercase"> <?= $title ?> </h2>
        <div class="row">
          <div class="col-md">
            <table class="table table-striped text-center">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col"> Product Name </th>
                  <th scope="col"> Count Orders</th>
                  <th scope="col"> Total Selling</th>

                </tr>
              </thead>
              <tbody>
                <?php foreach ($products as $product => $val) { ?>
                  <tr>
                    <td> <?= $product + 1;  ?> </td>
                    <td><?= $val['productName']; ?></td>
                    <td><?= $val['quantityOrdered']; ?></td>
                    <td><?= $val['total']; ?></td>

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
                    <a class="page-link" href="bestSelling.php?page=<?= $prev ?>">Previous</a>
                  <?php } else { ?>
                    <a class="page-link" href="">Previous</a>
                  <?php } ?>

                </li>
                <?php for ($i = 1; $i < $pages; $i++) :  ?>

                  <li class="page-item">
                    <a class="page-link" href="bestSelling.php?page=<?= $i ?>">
                      <?= $i ?></a>
                  </li>

                <?php endfor ?>

                <li class="page-item">
                  <?php if ($page < $pages) { ?>
                    <a class="page-link" href="bestSelling.php?page=<?= $next ?>">Next</a>
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

<?php require_once "inc/footer.php"; ?>