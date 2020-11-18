<?php
session_start();
$title = "VIP CLIENT";
include "inc/header.php";
include "inc/conn.php";

$limit = 11;
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($page - 1) * $limit;

$sql = "SELECT customerNumber,customerName, country, creditLimit 
  FROM customers
  WHERE creditLimit >= 20000
  limit $start, $limit";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  $clients = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
$result2 = $conn->query("SELECT COUNT(customerNumber) AS id FROM customers");
$customerCount = $result2->fetch_all(MYSQLI_ASSOC);
$total = $customerCount[0]['id'];
$pages = floor($total / $limit);

$prev = $page - 1;
$next = $page + 1;

mysqli_close($conn);
?>

<?php if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true) { ?>
  <section class="clients">
    <div class="container-fluid">
      <div class="row">

        <?php require_once "inc/sidNav.php"; ?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 mt-3 ">
          <h2 class="border-bottom w-25 py-2 mb-3"> <?= $title ?> </h2>
          <div class="row">
            <div class="col-md">
              <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col"> Client Number </th>
                    <th scope="col"> Client Name</th>
                    <th scope="col"> Country</th>
                    <th scope="col"> Credit Limit </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($clients as $client => $val) { ?>
                    <tr>
                      <td> <?= $client + 1;  ?> </td>
                      <td><?= $val['customerNumber']; ?></td>
                      <td><?= $val['customerName']; ?></td>
                      <td><?= $val['country']; ?></td>
                      <td><?= $val['creditLimit']; ?></td>
                    </tr>

                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-md">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item">
                    <?php if ($page > 1) { ?>
                      <a class="page-link" href="vip-clients.php?page=<?= $prev ?>">Previous</a>
                    <?php } else { ?>
                      <a class="page-link" href="">Previous</a>
                    <?php } ?>

                  </li>
                  <?php for ($i = 1; $i < $pages - 1; $i++) : ?>
                    <li class="page-item">
                      <a class="page-link" href="vip-clients.php?page=<?= $i ?>">
                        <?= $i ?></a>
                    </li>
                  <?php endfor ?>

                  <li class="page-item">
                    <?php if ($page > ($pages - 1)) { ?>
                      <a class="page-link" href="vip-clients.php?page=<?= $next ?>">Next</a>
                    <?php } else { ?>
                      <a class="page-link" href="">Next</a>
                    <?php } ?>
                  </li>

                </ul>
              </nav>
            </div>
          </div>
        </main>

      </div>
  </section>

<?php } ?>

<?php require_once "inc/footer.php"; ?>