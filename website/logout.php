<?php
require "../config.php";

$sql = "UPDATE userLogs 
        SET logout_datetime = current_timestamp() 
        WHERE user_id = ? AND login_datetime = (SELECT MAX(login_datetime) 
                                                FROM userLogs 
                                                WHERE user_id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $_SESSION["user"]["user_id"], $_SESSION["user"]["user_id"]);
$stmt->execute();

session_unset();
session_destroy();
header("Location: " . HTML_ROOT_DIR . "/website/index.php");