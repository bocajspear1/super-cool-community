<?php
include 'includes/head.php';
$_SESSION['logged_in'] = false;
$_SESSION['username'] = '';
header('Location: index.php');
?>