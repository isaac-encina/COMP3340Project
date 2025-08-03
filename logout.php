<?php
session_start();
$_SESSION = [];
session_destroy(); //destroys session and returns user to the home page.
header("Location: index.php");
exit;
?>