<?php
session_start();
unset($_SESSION['employeeid']);
header('location:index.php');
?>