<?php
session_start();
$title = "CITIES";

include "inc/header.php";
include "inc/conn.php";


$sql = "SELECT * FROM customers";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $all_cites = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

if (isset($_POST['submit'])) {
  $city = $_POST['city'];
  $sql_2 = "SELECT * FROM customers 
            where city = '$city' 
            ORDER BY customerName";
  $res_2 = mysqli_query($conn, $sql_2);

  if (mysqli_num_rows($res_2) > 0) {
    $all_clients = mysqli_fetch_all($res_2, MYSQLI_ASSOC);
  }

  mysqli_close($conn);
}
?>


<section class="">
  <div class="container-fluid">
    <div class="row">
      <?php require_once "inc/sidNav.php"; ?>

      <div class="col-md">
        <h2 class="border-bottom w-25 py-2 mb-3"> <?= $title ?> </h2>
        <div class="row ">
          <div class="col">
            <form action="" method="post">
              <select name="city" class="custom-select custom-select-lg mb-3">
                <?php foreach ($all_cites as $val) { ?>
                  <option selected='selected' value="<?= $val['city']; ?>"><?= $val['city']; ?></option>
                <?php } ?>

              </select>
          
              <input class="btn btn-primary float-right" type="submit" value="Check By City" name="submit">
            </form>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-md">

            <?php if (empty($city)) { ?>
              <div> </div>
            <?php } else { ?>
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
                  <?php foreach ($all_clients ?? [] as $client => $val) { ?>
                    <tr>
                      <td> <?= $client + 1;  ?> </td>
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