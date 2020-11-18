<?php //session_start();
?>


<?php if (isset($_SESSION['errors'])) { ?>

  <div class="alert alert-danger" role="alert">

    <ul>
      <?php foreach ($_SESSION['errors']  as $error) { ?>
        <li><?= $error; ?> </li>
      <?php } ?>
    </ul>

  </div>
<?php } ?>

<?php unset($_SESSION['errors']); ?>