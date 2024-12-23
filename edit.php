<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Page</title>
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
  $title = "Edit";
  include('view/header.php');
  $header = new Header($title);
  $header->showHeader();
  ?>

  <!-- Main Content -->
  <?php
  global $db;

  class Edit
  {
    private $salt;

    function __construct()
    {
      $this->salt = 'f5XWCqTi0i6xAmW56wrmGU7rm92SeyFiC';
    }

    function showForm($id)
    {
      global $result;
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
          // save fields retrieved from database
          $first_name = $row["first_name"];
          $last_name = $row["last_name"];
          $email = $row['email'];
          $theme = $row['theme'];
          $themes = ['default' => 'Default', 'light_mode' => 'Light', 'dark_mode' => 'Dark', 'modern_mode' => 'Modern'];
          // display form with fields set as the values

          echo "<form action='edit.php' method='POST'>
          <input type='hidden' id='id' name='id' value='" . $id . "'>
                    <label for='first_name'>First Name: </label></br>
                    <input type='text' name='first_name' id=first_name' value='" . $first_name . "'/></br>
                    <label for='last_name'>Last Name: </label></br>
                    <input type='text' name='last_name' id=last_name' value='" . $last_name . "'/></br>
                    <label for='pass'>Password: </label></br>
                    <input type='password' name='password' id='password'/></br>
                    <label for='email'>Email: </label></br>
                    <input type='email' name='email' id=email' value='" . $email . "'/></br>
                    <select name='theme'>";

          foreach ($themes as $key => $value) {
            if ($theme == $key) {
              echo "<option value='" . $key . "' selected>" . $value . "</option>";
            } else {
              echo "<option value='" . $key . "'>" . $value . "</option>";
            }
          };

          echo "</select><br>
                    <input type='submit' value='Submit' /></form>";
        }
      } else {
        echo "<section>";
        echo "<p>Error: No account has this id.</p>";
        echo "<a href='admin.php'>Try again</a>";
        echo "</section>";
      }
    }

    function authenticate()
    {
      global $db;
      $data = [];
      $data['id'] = $_POST['id'] ?? '';
      $data['first_name'] = $_POST['first_name'] ?? '';
      $data['last_name'] = $_POST['last_name'] ?? '';
      $data['email'] = $_POST['email'] ?? '';
      $data['password'] = $_POST['password'] ?? '';
      $data['theme'] = $_POST['theme'] ?? 'default';
      $data['full_name'] = $data['first_name'] . " " . $data['last_name'];


      $continue = true;

      // check if any are empty
      foreach ($data as $key => $value) {
        if ($value == '') {
          // if password is left empty allow else give error
          if ($key !==  "password") {
            echo "<section>";
            echo "<p>Error: Empty field(s) found.</p>";
            echo "</section>";
            $continue = false;
          }
        }
      }

      // if password is not empty encrpyt new password
      // else leave blank
      if ($data['password'] !== '') {
        $data['password'] = crypt($data['password'], $this->salt);
      }


      if ($continue === true) {
        // check if email is valid
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          echo "<section>";
          echo "<p>Error: Email is not valid</p>";
          echo "<a href='admin.php'>Try again</a>";
          echo "</section>";
        } else {
          // update fields into database
          $result = $db->updateAccount($data);
          // if success display success message
          if ($result == 1) {
            // get updated info (theme and email)
            $results = $db->newInfo($data);
            // get info is successfull
            // get email and theme that was returned and update session variables
            if (mysqli_num_rows($results) > 0) {
              while ($row = mysqli_fetch_array($results)) {
                $_SESSION['theme'] = $row['theme'];
                $_SESSION['valid_user'] = $row['email'];
              }

              echo "<section>";
              echo "Account updated successfully";
              echo "<a href='admin.php'>Admin</a>";
              echo "</section>";
            } else {
              echo "<section>";
              echo "<p>Error: " . $results . "</p>";
              echo "<a href='admin.php'>Try again</a>";
              echo "</section>";
            }
          } else {
            // else show error message
            echo "<section>";
            echo "<p>Error: " . $result . "</p>";
            echo "<a href='admin.php'>Try again</a>";
            echo "</section>";
          }
        }
      }
    }
  };

  $edit = new Edit();

  if (isset($_GET['id'])) {
    // get id
    $id = $_GET['id'];
    // if id is given but access is not give error
    // aka: if user tries to access edit without signing in as admin
    if ($_SESSION['admin_access'] == 'not_granted') {
      echo "<section>";
      echo "<p>Error: You must access edit page from the admin page.</p>";
      echo "<a href='admin.php'>Try again</a>";
      echo "</section>";
    } else {
      // use id to get all info on specific account
      $result = $db->getAccountInfo($id);
      // show form 
      $edit->showForm($id);
    }
  } else {
    // if user tries to access edit page without id and admin rights give error
    if ($_SESSION['admin_access'] == 'not_granted') {
      echo "<section>";
      echo "<p>Error: You must access edit page from the admin page.</p>";
      echo "<a href='admin.php'>Try again</a>";
      echo "</section>";
    }
    // else they have just submitted edit and are being redirected back to edit after
    // they will get success or not success message from authenticate()
  }

  // if form is submitted authenticate
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $edit->authenticate();
  }
  ?>

  <!-- Footer -->
  <?php
  include('view/footer.php')
  ?>
</body>

</html>