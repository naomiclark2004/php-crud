<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
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
  $title = "Login";
  include('view/header.php');
  $header = new Header($title);
  $header->showHeader();
  ?>

  <!-- Main Content -->
  <?php

  global $db;

  class Login
  {
    private $salt;

    function __construct()
    {
      $this->salt = 'f5XWCqTi0i6xAmW56wrmGU7rm92SeyFiC';
    }

    function set_salt($salt)
    {
      $this->salt = $salt;
    }

    function showForm()
    {
      echo
      "<form action='login.php' method='POST'>
            <label for='email'>Email:</label><br>
            <input type='text' id='email' name='email'><br>
            <label for='password'>Password:</label><br>
            <input type='password' id='password' name='password'><br><br>
            <input type='submit' value='Submit'>
            </form>";
    }

    function authenticate()
    {
      global $db;
      global $header;
      $password = $_POST['password'];
      $email = $_POST['email'];

      $password = crypt($password, $this->salt);

      $results = $db->isExisting($email, $password);

      if ($results->num_rows > 0) {
        while ($row = mysqli_fetch_array($results)) {
          $_SESSION['theme'] = $row['theme'];
          $_SESSION['valid_user'] = $email;
        }
        // save user email to show user is logged in
        // take user back to index
        header("Location: index.php");
      } else {
        // if no account is found
        echo "<section>";
        echo "<p>Error: Account does not exist.</p>";
        echo "</section>";
      }
    }
  }

  $login = new Login();
  // $login->showForm();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login->authenticate();
  } else {
    $login->showForm();
  }
  ?>

  <!-- Footer -->
  <?php
  include('view/footer.php')
  ?>
</body>

</html>