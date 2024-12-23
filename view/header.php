<?php
session_start();
class Header
{
  protected $title;

  function __construct($title = 'Page Title')
  {
    $this->title = $title;
  }

  function set_title($title)
  {
    $this->title = $title;
  }

  function showHeader()
  {
    echo "<header>
    <div class='head'>
    <img src='./images/logo.png' alt='' class='item1'>";

    // check if user is logged in
    if (empty($_SESSION['valid_user'])) {
      // if not logged in display login button
      echo "<button type='button' class='item3 btn' onclick=(window.location='login.php')>Login</button>";
    } else {
      // if logged in display logout button

      echo "<button type='button' class='btn item3' onclick=(window.location='logout.php')>Logout</button>";
    }

    echo "</div> <br><h1 class='item5'>" . $this->title . "</h1>
    </header>";
  }
};
