<?php
// end session and take user back to index
session_start();
session_destroy();
header("Location: index.php");
