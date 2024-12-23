<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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
    $title = "Contact Us";
    include('view/header.php');
    $header = new Header($title);
    $header->showHeader();
    ?>

    <!-- Main Content -->
    <?php
    class Contact
    {
        function showForm()

        // show form
        // if issue is picked give two options of issues
        // if question is picked give text area for user to input question
        {
            echo "<form action='contact-us.php' method='POST' id='form'>

            <label for='subject' >Subject:</label>
            <select id='subject' name='subject' onchange='sendEmail()'>
            <option value='default'>Select</option>
              <option value='question'>Question</option>
              <option value='issue'>Issue</option>
            </select>

            <p id='demo'></p>
          </form>";

            echo "<script type=\"text/javascript\">
            function sendEmail() {
                var x = document.getElementById('subject').value;
                if(x == 'question'){
                    let textarea = document.createElement('textarea');
                    let label = document.createElement('label');
                    const newtext = document.createTextNode('Text:');
                    label.appendChild(newtext);
                    document.getElementById('form').append(label);
                    label.setAttribute('for', 'text');
                    textarea.setAttribute('name', 'text');

                    document.getElementById('form').append(label);
                    document.getElementById('form').append(textarea);
                    let submit = document.createElement('input');
                    submit.setAttribute('type', 'submit');
                    document.getElementById('form').append(submit);
                }else{
                    let select = document.createElement('select');
                    select.setAttribute('name', 'issue');
                    select.setAttribute('id', 'issue');

                    let option0 = document.createElement('option');
                    option0.innerHTML = 'Select';

                    let option1 = document.createElement('option');
                    option1.innerHTML = 'Product Issue';
                    
                    let option2 = document.createElement('option');
                    option2.innerHTML = 'Website Issue';

                    select.append(option0);
                    select.append(option1);
                    select.append(option2);
                    
                    document.getElementById('form').append(select);

                    let submit = document.createElement('input');
                    submit.setAttribute('type', 'submit');
                    submit.setAttribute('value', 'Submit');
                    document.getElementById('form').append(submit);
                    console.log(label);
                }
              }
            </script>";
        }

        function getInfo()
        // get subject
        // show that question / issue has been reported

        {
            $subject = $_POST['subject'] ?? '';;
            if ($subject == "issue") {
                $issue = $_POST['issue'] ?? '';
                echo "<section>";
                echo "<p>The " . $issue . " has been reported.</p>";
                echo "</section>";
            } elseif ($subject == "question") {
                $text = $_POST['text'] ?? '';
                echo "<section>";
                echo "<p>The question: " . $text . ", has been reported.</p>";
                echo "</section>";
            } else {
                echo "<section>";
                echo "<p>Invalid.</p>";
                echo "</section>";
            }
        }
    }

    $contact = new Contact();
    // $login->showForm();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $contact->getInfo();
    } else {
        $contact->showForm();
    }
    ?>



    <!-- Footer -->
    <?php
    include('view/footer.php')
    ?>
</body>

</html>