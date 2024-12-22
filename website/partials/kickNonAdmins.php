<?php
if (!isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION["user"]["role"] != "admin")) {
    header("Location: " . HTML_ROOT_DIR . "/website/index.php");
    exit();
}