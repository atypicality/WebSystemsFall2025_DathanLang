<?php
$servername = "localhost";
$username = "root";
$password = "229Huntsman##";
$dbname = "ITWS2110-Fall2025-langd4-Quiz2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
