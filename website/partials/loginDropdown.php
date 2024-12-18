<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["login_email"]), FILTER_SANITIZE_EMAIL);
    $password = $_POST["login_password"];

    $sql = "SELECT user_id, email, password, first_name, last_name, country, city, address, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["user"]["user_id"] = $row["user_id"];
            $_SESSION["user"]["email"] = $row["email"];
            $_SESSION["user"]["first_name"] = $row["first_name"];
            $_SESSION["user"]["last_name"] = $row["last_name"];
            $_SESSION["user"]["country"] = $row["country"];
            $_SESSION["user"]["city"] = $row["city"];
            $_SESSION["user"]["address"] = $row["address"];
            $_SESSION["user"]["role"] = $row["role"];

            unset($_SESSION["login_error"]);
            header("Location: .");
            exit();
        } else {
            $_SESSION["login_error"] = "The password is incorrect";
        }
    } else {
        $_SESSION["login_error"] = "This user doesn't exist.";
    }
}
?>



<li class="nav-item dropdown text-center mx-2 mx-lg-1 rounded">
    <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        <div>
            <i class="fas fa-user fa-lg mb-3"></i>
            Login
        </div>
    </a>
    <div class="dropdown-menu p-3 border border-1 border-black" aria-labelledby="loginDropdown">
        <form method="post" action="">
            <div class="form-group mb-3">
                <label for="DropdownFormEmail1">Email address</label>
                <input name="login_email" type="text" class="form-control" id="DropdownFormEmail"
                    placeholder="email@example.com" required>
            </div>
            <div class="form-group mb-3">
                <label for="DropdownFormPassword">Password</label>
                <input name="login_password" type="password" class="form-control" id="DropdownFormPassword"
                    placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item rounded" href="/ecommerce_project/website/register.php">Click here to create an
            account</a>
        <?php
        if (isset($_SESSION["login_error"])) {
            echo '<div class="alert alert-danger rounded alert-dismissible fade show" role="alert">'
                . $_SESSION["login_error"] .
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>';
        }
        ?>
    </div>
</li>