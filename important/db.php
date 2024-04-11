<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "nicknick";
$db_name = "loogle_main";

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

$siteurl = $protocol . "://localhost:8090";

?>
