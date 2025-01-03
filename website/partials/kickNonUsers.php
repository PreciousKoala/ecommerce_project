<?php
if (!isset($_SESSION["user"])) {
    header("Location: " . HTML_ROOT_DIR . "/website/index.php");
    exit();
}