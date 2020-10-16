<?php
$link = new mysqli("localhost","digicono_HRadmin","DigiC0n0nlin3!", "internal");
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
} 
?>