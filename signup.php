<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Page</title>
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
  $title = "Signup";
  include('view/header.php');
  $header = new Header($title);
  $header->showHeader();
  ?>

  <!-- Main Content -->
  <?php

  global $db;

  class Signup
  {
    private $salt;

    function __construct()
    {
      $this->salt = 'f5XWCqTi0i6xAmW56wrmGU7rm92SeyFiC';
    }

    // function set_salt($salt)
    // {
    //   $this->salt = $salt;
    // }

    function showForm()
    {
      echo
      "<form action='signup.php' method='POST'>
            <label for='fname'>First Name:</label><br>
            <input type='text' id='fname' name='fname'><br>
            <label for='lname'>Last Name:</label><br>
            <input type='text' id='lname' name='lname'><br>

            <label for='email'>Email:</label><br>
            <input type='text' id='email' name='email'><br>
            <label for='password'>Password:</label><br>
            <input type='password' id='password' name='password'><br><br>
            <label for='themes'>Choose a theme:</label>
            <select name='theme'>
                <option value='default'>Select</option>
                <option value='light_mode'>Light</option>
                <option value='dark_mode'>Dark</option>
                <option value='modern_mode'>Modern</option>
            </select><br>
            <input type='submit' value='Submit'>
            </form>";
    }

    function authenticate()
    {
      global $db;

      // save fields in array
      $data = [];

      $data['first_name'] = $_POST['fname'] ?? '';
      $data['last_name'] = $_POST['lname'] ?? '';
      $data['email'] = $_POST['email'] ?? '';
      $data['password'] = $_POST['password'] ?? '';
      $data['full_name'] = $data['first_name'] . " " . $data['last_name'];
      $data['theme'] = $_POST['theme'] ?? 'default';


      $continue = true;
      // check if any are empty
      foreach ($data as $key => $value) {
        if ($value == '') {
          echo "<section>";
          echo "<p>Error: Empty " . $key . " found.</p>";
          echo "</section>";
          $continue = false;
        }
      }
      if ($continue === true) {
        // encrypt password for security
        $data['password'] = crypt($data['password'], $this->salt);
        // check if email is valid
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          // if not valid display error
          echo "<section>";
          echo "<p>Error: Email is not valid</p>";
          echo "<a href='signup.php'>Try again</a>";
          echo "</section>";
        } else {
          // if valid check if account already exists using email and password
          $results = $db->isExisting($data['email'], $data['password']);
          if (mysqli_num_rows($results) == 0) {
            // account does not exist yet
            // add create new account by passing data array
            $result = $db->createAccount($data);
            if ($result == 1) {
              header("Location: login.php");
            } else {
              // else show error
              echo "<section>";
              echo "<p>Error: " . $result . "</p>";
              echo "<a href='signup.php'>Try again</a>";
              echo "</section>";
            }
          } else {
            // account already exists and duplicates are not allowed
            echo "<section>";
            echo "<p>Error: Account already exists.</p>";
            echo "<a href='signup.php'>Try again</a>";
            echo "</section>";
          }
        }
      }
    }
  }


  $login = new Signup();
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