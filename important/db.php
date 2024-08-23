<?php

$db_host = "localhost";
$db_user = "";
$db_pass = "";
$db_name = "";

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $protocol = 'https';  
} elseif (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    $protocol = 'https';  
} else {
    $protocol = 'http';   
}

$host = $_SERVER['HTTP_HOST'] ?? '';

if (strpos($host, 'loogle.cc') !== false) {
    $siteurl = $protocol . "://loogle.cc";  
} elseif (strpos($host, 'plus.loogle.mooo') !== false) {
    $siteurl = $protocol . "://plus.loogle.mooo";  
} else {

    header('HTTP/1.0 400 Bad Request');
    exit;  
}

$logFile = __DIR__ . '/server_log.txt';  
$logContent = "Host: " . $host . "\nProtocol: " . $protocol . "\nSite URL: " . $siteurl . "\n";
file_put_contents($logFile, $logContent, FILE_APPEND);  
?>
