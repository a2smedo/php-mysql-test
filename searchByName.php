<?php
session_start();
$title = "CLIENTS";
include "inc/header.php";
include "inc/conn.php";



if (isset($_POST['submit'])) {
  $search = $_POST['search'];



  $sql = "SELECT customerNumber ,customerName, contactFirstName, contactLastName 
  FROM customers WHERE contactFirstName LIKE '%$search%'
  limit 10  ";

  $regex = "/^[A-Za-z]$/";

  $errors = [];
  if (empty($search)) {
    $errors[] = "Faild Is Required";
  } elseif (is_numeric($search)) {
    $errors[] = "Please Insert String Not a Number";
  } elseif (!preg_match($regex, $search)) {
    $errors[] = "Please Insert Just String  Not String With a Number";
  }
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $total_search = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
 
  $limit = 10;
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $offset = $limit * ($page - 1);
  /*
  $result2 = $conn->query("SELECT COUNT(customerNumber) AS id FROM customers");
  $proCount = $result2->fetch_all(MYSQLI_ASSOC);

  $total = $proCount[0]['id'];
  $pages = ceil($total / $limit);

  $prev = $page - 1;
  $next = $page + 1;
 */




  mysqli_close($conn);
}
?>
<?php if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] == true) { ?>
  <section class="search ">
    <div class="container-fluid ">

      <div class="row">
        <?php require_once "inc/sidNav.php"; ?>

        <div class="col-md ">
          <h2 class="border-bottom w-25  mb-3"> <?= $title ?> </h2>
          <div class="row">
            <div class="col">
              <form method="post">
                <div class="form-group">
                  <input name="search" class="form-control" type="text" placeholder="Enter Name for Search">
                </div>

                <div class="form-group">
                  <input name="submit" class="btn btn-info float-right" type="submit" value="Search">
                </div>
              </form>
            </div>
          </div>

          <div class="row mt-2">

            <div class="col-md">




              <?php if (empty($errors)) { ?>

                <?php if (empty($search)) { ?>
                  <div> </div>
                <?php } else { ?>
                  <div class="row">
                    <div class="col">
                      <table class="table table-striped">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col"> Client Number </th>
                            <th scope="col"> Client Name</th>
                            <th scope="col"> contactFirstName</th>
                            <th scope="col"> contactLastName </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($total_search ?? [] as $sear => $val) { ?>
                            <tr>
                              <td> <?= $sear + 1;  ?> </td>
                              <td><?= $val['customerNumber']; ?></td>
                              <td><?= $val['customerName']; ?></td>
                              <td><?= $val['contactFirstName']; ?></td>
                              <td><?= $val['contactLastName']; ?></td>
                            </tr>

                          <?php } ?>

                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- <div class="row">
                    <div class="col-md-6">
                      <nav aria-label="Page navigation ">
                        <ul class="pagination w-50">
                          <li class="page-item">
                            <?php if ($page > 1) { ?>
                              <a class="page-link" href="searchByName.php?page=<?= $prev ?>">Previous</a>
                            <?php } else { ?>
                              <a class="page-link" href="">Previous</a>
                            <?php } ?>

                          </li>
                          <?php for ($i = 1; $i < $pages; $i++) :  ?>

                            <li class="page-item">
                              <a class="page-link" href="searchByName.php?page=<?= $i ?>">
                                <?= $i ?></a>
                            </li>

                          <?php endfor ?>

                          <li class="page-item">
                            <?php if ($page < $pages) { ?>
                              <a class="page-link" href="searchByName.php?page=<?= $next ?>">Next</a>
                            <?php } else { ?>
                              <a class="page-link" href="">Next</a>
                            <?php } ?>
                          </li>

                        </ul>
                      </nav>
                    </div>
                  </div> -->

                <?php } ?>

              <?php } else { ?>


              <?php
                $_SESSION['errors'] = $errors;
                require_once "inc/errors.php";
              }  ?>

            </div>


          </div>
        </div>
      </div>
    </div>
  </section>

<?php } ?>

<?php require_once "inc/footer.php"; ?>