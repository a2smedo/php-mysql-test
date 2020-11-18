<?php
session_start();
$title = "Rich Men Of City";
include "inc/header.php";
include "inc/conn.php";

if (isset($_POST['submit'])) {
  $city = trim($_POST['city']);

  $sql = "SELECT * FROM customers where `city` ='$city'
            order by `creditLimit` desc
            limit 3";
  $result = mysqli_query($conn, $sql);

  $errors = [];
  $regxCity = "/(^[A-Za-z]{2,10})([ ]{0,1}([A-Za-z]{2,10}))$/";
  //$cityLen = strlen($city);

  if (empty($city)) {
    $errors[] = "City Field Is Required";
  } elseif (!preg_match($regxCity, $city)) {
    $errors[] = "City Is Not Valid";
  } elseif ($result) {
    $row = mysqli_num_rows($result);
    if ($row <= 0) {
      $errors[] = "City is not found";
    } else {
      $rich_men = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
        <h2 class="border-bottom w-50 py-2 mb-3"> <?= $title ?> </h2>
        <div class="row">

          <div class="col-md">
            <form method="post">
              <div class="form-group mb-3">
                <input type="text" name="city" class="form-control" placeholder="Enter Name of city">
              </div>

              <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Click" name="submit">
              </div>
            </form>
            <?php require_once "inc/errors.php"; ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md">
            <?php if (empty($errors)) { ?>
              <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col"> Client Number </th>
                    <th scope="col"> Client Name</th>
                    <th scope="col"> Country</th>
                    <th scope="col"> City</th>
                    <th scope="col"> Credit Limit </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($rich_men ?? [] as $rich => $val) { ?>
                    <tr>
                      <td> <?= $rich + 1;  ?> </td>
                      <td><?= $val['customerNumber']; ?></td>
                      <td><?= $val['customerName']; ?></td>
                      <td><?= $val['country']; ?></td>
                      <td><?= $val['city']; ?></td>
                      <td><?= $val['creditLimit']; ?></td>
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