<?php
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/dbConn.php";
$title = "Home Page";
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/header.php";
//echo password_verify("test", password_hash("test", PASSWORD_DEFAULT));
echo password_hash("test", PASSWORD_DEFAULT);

include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/footer.php";
?>