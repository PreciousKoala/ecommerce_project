<?php
session_start();
session_unset();
session_destroy();
header("Location: /ecommerce_project/website/index.php");