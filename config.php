<?php
// points to the directory ../website (whatever you name it), used for filepaths in php that need the server directory
define("ROOT_DIR", __DIR__);

// points to the directory of the website, used for hrefs in html code
// removes server document root from ROOT_DIR
define("HTML_ROOT_DIR", substr(ROOT_DIR, strlen($_SERVER["DOCUMENT_ROOT"])));

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
