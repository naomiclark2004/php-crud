<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
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
    $title = "Admin";
    include('view/header.php');
    $header = new Header($title);
    $header->showHeader();
    ?>
    <!-- Main Content -->
    <?php

    global $db;

    class Admin
    {
        private $username = 'admin123';
        private $password = 'password123';


        function __construct()
        {
            $this->username = 'admin123';
            $this->password = 'password123';
        }

        function showForm()
        {
            echo
            "<form action='admin.php' method='POST'>
            <label for='username'>Username:</label><br>
            <input type='text' id='username' name='username'><br>
            <label for='password'>Password:</label><br>
            <input type='password' id='password' name='password'><br><br>
            <input type='submit' value='Submit'>
            </form>";
        }

        function authenticate()
        {
            global $db;

            $given_username = $_POST['username'] ?? " ";
            $given_password = $_POST['password'] ?? " ";

            if ($given_password == $this->password && $given_username == $this->username) {
                // if special username and password is correct
                // show admin page
                $_SESSION['admin_access'] = 'granted';
                $result = $db->showAdmin();
                if (mysqli_num_rows($result) > 0) {
                    echo "<table>";
                    // display table
                    // added edit and delete link
                    // first_name, last_name, full_name, email, password, theme
                    echo "<tr><th>Id</th><th>First Name</th><th>Last Name<th>Full Name</th><th>Email</th><th>Password</th><th>Theme</th><th>Actions</th></tr>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["first_name"] . "</td><td>" . $row["last_name"] . "</td><td>" . $row["full_name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["password"] . "</td><td>" . $row["theme"] . "</td><td><a href='edit.php?id=" . $row['id'] . "'>Edit</a><a href='delete.php?id=" . $row['id'] . "'>Delete</a></td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No accounts";
                }
            } else if ($given_password == " " || $given_username == " ") {
                echo "<section>";
                echo "<p>Error: Empty username or password.</p>";
                echo "</section>";
            } else {
                echo "<section>";
                echo "<p>Error: Invalid username or password. You do not have admin authority.</p>";
                echo "</section>";
            }
        }
    }

    $login = new Admin();
    // $login->showForm();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login->authenticate();
    } else {
        // if already signed in as admin show admin page
        if ($_SESSION['admin_access'] == 'granted') {
            $result = $db->showAdmin();
            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                // display table
                // added edit and delete link
                // first_name, last_name, full_name, email, password, theme
                echo "<tr><th>Id</th><th>First Name</th><th>Last Name<th>Full Name</th><th>Email</th><th>Password</th><th>Theme</th><th>Actions</th></tr>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr><td>" . $row["id"] . "</td><td>" . $row["first_name"] . "</td><td>" . $row["last_name"] . "</td><td>" . $row["full_name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["password"] . "</td><td>" . $row["theme"] . "</td><td><a href='edit.php?id=" . $row['id'] . "'>Edit</a><a href='delete.php?id=" . $row['id'] . "'>Delete</a></td></tr>";
                }
                echo "</table>";
            } else {
                echo "No accounts";
            }
        } else {
            // else show login from for admin page
            $login->showForm();
        }
    }
    ?>

    <!-- Footer -->
    <?php
    include('view/footer.php')
    ?>
</body>

</html>