<?php
session_start();
$title = "Employees";
include "inc/header.php";
include "inc/conn.php";

$limit = 11;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = $limit * ($page - 1);

$sql = "SELECT emp.firstName AS employee_fn, emp.lastName AS employee_ln,
               mange.firstName AS manger_fn, mange.lastName AS manger_ln
        FROM employees AS emp JOIN employees AS mange 
        ON emp.reportsTo = mange.employeeNumber
        limit $limit OFFSET $offset ";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $employees = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$result2 = $conn->query("SELECT COUNT(employeeNumber) AS emp FROM employees");
$empCount = $result2->fetch_all(MYSQLI_ASSOC);

$total = $empCount[0]['emp'];
$pages = ceil($total / $limit);

$prev = $page - 1;
$next = $page + 1;


mysqli_close($conn);
?>

<?php if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true) { ?>

  <section class="employees ">
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
                    <th scope="col"> Employees Name</th>
                    <th scope="col"> Manger Name</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($employees as $employee => $val) { ?>
                    <tr>
                      <td><?= $employee + 1; ?></td>
                      <td><?= $val['employee_fn'] . " " . $val['employee_ln']; ?></td>
                      <td><?= $val['manger_fn'] . " " . $val['manger_ln']; ?></td>
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
                      <a class="page-link" href="employees.php?page=<?= $prev ?>">Previous</a>
                    <?php } else { ?>
                      <a class="page-link" href="">Previous</a>
                    <?php } ?>

                  </li>
                  <?php for ($i = 1; $i < $pages; $i++) :  ?>

                    <li class="page-item">
                      <a class="page-link" href="employees.php?page=<?= $i ?>">
                        <?= $i ?></a>
                    </li>

                  <?php endfor ?>

                  <li class="page-item">
                    <?php if ($page < $pages) { ?>
                      <a class="page-link" href="employees.php?page=<?= $next ?>">Next</a>
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