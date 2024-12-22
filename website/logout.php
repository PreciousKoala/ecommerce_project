<?php
include "../config.php";
session_unset();
session_destroy();
header("Location: " . HTML_ROOT_DIR . "/website/index.php");