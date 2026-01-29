<?php 
session_start();

$_SESSSION = []; // kosongkan session
session_destroy();

header("Location: login.php");
exit;
