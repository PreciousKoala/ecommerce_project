<?php
session_start();
ob_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerceDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}