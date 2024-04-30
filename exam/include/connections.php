<?php 

ini_set('display_errors', '1');

$conn = new mysqli('localhost', 'root', '', 't123');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("SET NAMES 'utf8'");

?>