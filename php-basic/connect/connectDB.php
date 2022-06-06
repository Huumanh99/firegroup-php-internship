<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "db";
    
    $conn = new mysqli($servername, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection mysql failed: " . $conn->connect_error);
    }

?>
