<?php
$haystack = $_SERVER['REQUEST_URI'];
$needle   = "/assets/profilepics/";

if (strpos($haystack, $needle) !== false) {
     header("Content-Type: image/png");
        die(readfile("assets/icons/default.png"));
} else {
  include "errors/".http_response_code().".php";
}
  
  
  
?>
