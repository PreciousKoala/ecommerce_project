<?php
// points to the directory ../website (whatever you name it), used for filepaths in php that need the server directory
// ex: /opt/lampp/htdocs/e21155/my_files
define("ROOT_DIR", __DIR__);

// points to the directory of the website, used for hrefs in html code
// removes server document root from ROOT_DIR
// ex: /e21155/my_files
define("HTML_ROOT_DIR", substr(ROOT_DIR, strlen($_SERVER["DOCUMENT_ROOT"])));

// starts session
session_start();

// used when redirecting the user somewhere
ob_start();

// connection to mySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerceDB";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// loads environmental variables from the .env file
$env = file_get_contents(ROOT_DIR . "/.env");
$lines = explode("\n", $env);

foreach ($lines as $line) {
    preg_match("/([^#]+)\=(.*)/", $line, $matches);
    if (isset($matches[2])) {
        putenv(trim($line));
    }
}

define("MAIL_USER", getenv("MAIL_USER"));
define("MAIL_PASS", getenv("MAIL_PASS"));
define("DEEPGRAM_API_KEY", getenv("DEEPGRAM_API_KEY"));

// timezone set to GMT+2
date_default_timezone_set("Europe/Athens");
