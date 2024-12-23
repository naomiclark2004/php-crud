<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Page</title>
    <?php
    include("./style/styles.php")
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
    $title = "Delete";
    include('view/header.php');
    $header = new Header($title);
    $header->showHeader();
    ?>

    <!-- Main Content -->
    <?php
    global $db;


    if (isset($_GET['id'])) {
        // retrieve id from url
        $id = $_GET['id'];

        // if id is given but access is not give error
        if ($_SESSION['admin_access'] == 'not_granted') {
            echo "<section>";
            echo "<p>Error: You must access delete page from the admin page.</p>";
            echo "<a href='admin.php'>Try again</a>";
            echo "</section>";
        } else {
            // use id to compare what account they are trying to delete and currently signed in account
            $result = $db->getAccountInfo($id);
            if (mysqli_num_rows($result) > 0) {
                // if user is trying to delete account they are currently signed into
                while ($row = mysqli_fetch_array($result)) {
                    $del_email = $row['email'];
                }
                // if they are the same account
                if ($_SESSION['valid_user'] == $del_email) {
                    echo "<section>";
                    echo "This is the account you are currently signed into.";
                    echo "<button onclick=(window.location='delete.php?id=" . $id . "&confirm=true')>Confirm</button>";
                    echo "<button onclick=(window.location='admin.php')>Back</button>";
                    echo "</section>";

                    // if user confirms deletion then delete account then log user out
                    if (isset($_GET['confirm'])) {
                        // delete account from database using id
                        $result = $db->deleteAccount($id);
                        if ($result === TRUE) {
                            // then if succesfully delete
                            // log user out of account
                            header("Location: logout.php");
                        } else {
                            // else show error
                            echo "<section>";
                            echo "<p>Error: Error" . $result . "</p>";
                            echo "<a href='signup.php'>Try again</a>";
                            echo "</section>";
                        }
                        // close connection
                        $conn->close();
                    }
                } else {
                    $result = $db->deleteAccount($id);
                    // show success message
                    if ($result === TRUE) {
                        echo "<section>";
                        echo "Account deleted successfully.";
                        echo "<a href='admin.php'>Admin</a>";
                        echo "</section>";
                    } else {
                        // else show error
                        echo "<section>";
                        echo "<p>Error: Error" . $result . "</p>";
                        echo "<a href='signup.php'>Try again</a>";
                        echo "</section>";
                    }
                    // close connection
                    $conn->close();
                }
            }
        }
    } else {
        // if user tries to access page without id and admin rights give error
        if ($_SESSION['admin_access'] == 'not_granted') {
            echo "<section>";
            echo "<p>Error: You must access edit page from the admin page.</p>";
            echo "<a href='admin.php'>Try again</a>";
            echo "</section>";
        }
    }
    ?>

    <!-- Footer -->
    <?php
    include('view/footer.php')
    ?>
</body>

</html>