<?php

// Want to see errors!!!!!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$config_json = file_get_contents("./config.json");
$config = json_decode($config_json);

?>