<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "nicknick";
$db_name = "loogle";

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $protocol = 'https';  
} elseif (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    $protocol = 'https';  
} else {
    $protocol = 'http';   
}

$host = $_SERVER['HTTP_HOST'] ?? '';

if (strpos($host, 'localhost:8090') !== false) {
    $siteurl = $protocol . "://localhost:8090";  
} elseif (strpos($host, 'localhost:8090') !== false) {
    $siteurl = $protocol . "://localhost:8090";  
} else {

    header('HTTP/1.0 400 Bad Request');
    exit;  
}

$logFile = __DIR__ . '/server_log.txt';  
$logContent = "Host: " . $host . "\nProtocol: " . $protocol . "\nSite URL: " . $siteurl . "\n";
file_put_contents($logFile, $logContent, FILE_APPEND);  
?>
