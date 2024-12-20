<?php
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/dbConn.php";
$title = "Home Page";
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/header.php";

include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/mailer.php";

var_dump($_SESSION);
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/footer.php";
?>