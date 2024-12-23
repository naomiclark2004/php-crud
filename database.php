<!-- all functions for database interactions -->
<?php
// [x] connect to database 
// [] create new user
// [] get user from users table
// [] edit user in users table
// [] delete user in users table
// [] get active links from menu
// [] get full name for welcome

class DB
{
  public $host;
  public $username;
  public $password;
  public $database;

  function __construct()
  {
    $this->host = 'localhost';
    $this->username = "root";
    $this->password = "";
    $this->database = "final";
  }

  function connect()
  {
    // Create connection
    $conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
    // Check connection
    if (!$conn) {
      return "Connection failed: " . mysqli_connect_error();
    } else {
      return $conn;
    }
  }

  function isExisting($email, $password)
  {
    global $conn;
    $sql = ("SELECT id, theme FROM users WHERE email = '$email' and password = '$password'");
    $results = mysqli_query($conn, $sql);
    return $results;

    $conn->close();
  }

  function createAccount($data)
  {
    global $conn;
    $sql = "SELECT id FROM users WHERE email='" . $data['email'] . "'";
    $results = mysqli_query($conn, $sql);

    if (mysqli_num_rows($results) > 0) {
      //if account already exists
      return "This email address is already in use.";
    } else {
      // eles create account
      $sql = "INSERT INTO users (first_name, last_name, full_name, email, password, theme) VALUES ('" . $conn->real_escape_string($data['first_name']) . "', '" . $conn->real_escape_string($data['last_name']) . "', '" . $conn->real_escape_string($data['full_name']) . "', '" . $conn->real_escape_string($data['email']) . "', '" . $conn->real_escape_string($data['password']) . "', '" . $conn->real_escape_string($data['theme']) . "')";
      // check if insert was successfull
      $results = mysqli_query($conn, $sql);
      return $results;
    }
    //close connection
    $conn->close();
  }

  function showAdmin()
  {
    global $conn;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    return $result;
  }

  function getAccountInfo($id)
  {
    global $conn;
    $sql = ("SELECT * FROM users WHERE id='$id'");
    $result = mysqli_query($conn, $sql);
    return $result;

    $conn->close();
  }

  function updateAccount($data)
  {
    global $conn;

    if ($data['password'] == "") {
      $sql = ("UPDATE users SET first_name='" . $data['first_name'] . "', last_name='" . $data['last_name'] . "', email='" . $data['email'] . "', theme='" . $data['theme'] . "' WHERE id='" . $data['id'] . "'");
    } else {
      $sql = ("UPDATE users SET first_name='" . $data['first_name'] . "', last_name='" . $data['last_name'] . "', email='" . $data['email'] . "', password='" . $data['password'] . "', theme='" . $data['theme'] . "' WHERE id='" . $data['id'] . "'");
    }

    $result = mysqli_query($conn, $sql);
    return $result;
  }

  function newInfo($data)
  {
    global $conn;
    // get new info after edit is made
    $sql = ("SELECT theme, email FROM users WHERE id='" . $data['id'] . "'");
    $result = mysqli_query($conn, $sql);
    return $result;
  }

  function deleteAccount($id)
  {
    global $conn;
    $sql = ("DELETE FROM users WHERE id='$id'");
    $result = $conn->query($sql);

    return $result;

    $conn->close();
  }

  function getFullName($email)
  {
    global $conn;
    $sql = ("SELECT full_name FROM users WHERE email='$email'");
    $result = $conn->query($sql);

    return $result;

    $conn->close();
  }

  function getActiveLinks()
  {
    global $conn;
    $sql = ("SELECT * FROM menu WHERE link_status='active' ORDER BY link_order ASC");
    $result = mysqli_query($conn, $sql);
    return $result;
  }

  function getImageInfo()
  {
    global $conn;
    $sql = ("SELECT * FROM images");
    $result = mysqli_query($conn, $sql);
    return $result;
  }
};

// automaticly make a connection so it can be included in any file
$request = new DB();
$conn = $request->connect();
return $conn;

?>