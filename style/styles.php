<?php
// when session_start is not written it gives error but when its written it gives notice

error_reporting(E_ALL ^ E_NOTICE); // to get rid of php notice on session
session_start();
if (!empty($_SESSION['theme'])) {
    $theme = $_SESSION['theme'];
} else {
    $theme = 'default';
}
echo "<link rel='stylesheet' href='./style/" . $theme . ".css'>";
