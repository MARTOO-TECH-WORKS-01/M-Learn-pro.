<?php
$host = "sql113.infinityfree.com";
$dbname = "if0_38632840_mlearn_db";
$username = "if0_38632840";
$password = "xIw72eCPFLD";

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
