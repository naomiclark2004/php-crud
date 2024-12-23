<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Page</title>
  <?php
  include("./style/styles.php");
  ?>
</head>

<body>
  <!-- Nav -->
  <?php

  include('view/menu.php');
  include('database.php');
  $db = new DB();

  $menu = new Menu($db);
  $menu->showMenu();
  ?>

  <!-- Header -->
  <?php
  $title = "Homepage";
  include('view/header.php');
  $header = new Header($title);
  $header->showHeader();
  ?>

  <!-- Main Content -->
  <?php
  global $db;

  // by default admin access is not given
  // so user can't access edit or delete page until theyve logged as admin
  $_SESSION['admin_access'] = 'not_granted';
  if (empty($_SESSION['valid_user'])) {
    // if not logged in display default weclome message
    echo "<section><p>Welcome, this is my website!</p><button onclick=(window.location='signup.php')>Sign Up</a></button></section>";
  } else {
    // get name from email
    $result = $db->getFullName($_SESSION['valid_user']);
    if ($result->num_rows > 0) {
      $row = mysqli_fetch_array($result);
      $full_name = $row['full_name'];
    }
    // if logged in display user's full name in welcome message
    echo "<section><p>Welcome, " . $full_name . " this is my website!</p></section>";
  }
  ?>

  <!-- Footer -->
  <?php
  include('view/footer.php')
  ?>
</body>

</html>