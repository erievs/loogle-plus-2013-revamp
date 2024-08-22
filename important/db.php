<?php
$db_host = "";
$db_user = "";
$db_pass = "";
$db_name = "";

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

$host = $_SERVER['HTTP_HOST'];

if (strpos($host, 'loogle.cc') !== false) {
    $siteurl = $protocol . "://loogle.cc";
} elseif (strpos($host, 'plus.loogle.mooo') !== false) {
    $siteurl = $protocol . "://plus.loogle.mooo";
} else {

    header('HTTP/1.0 400 Bad Request');
    echo "Unrecognized domain.";
    exit;
}
?>
