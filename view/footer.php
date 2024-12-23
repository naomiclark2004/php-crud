<?php
// set timezone for phoenix
date_default_timezone_set("America/Phoenix");

// current date
$date = new DateTime();
$date = $date->format('d/m/Y');

// current time
$time = new DateTime();
$time = $time->format('h:i');

// display current date and time and copywrite
echo "<footer>" . $time . "<br> " . $date . "<br> &copy;2024 Naomi Clark </footer>";
