<?php

session_start();

$config_json = file_get_contents("./config.json");
$config = json_decode($config_json);

?>