<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $country = $_POST["country"];
    $city = $_POST["city"];
    $address = trim($_POST["address"]);

    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION["register_error"] = "This email is already in use.";
        header("Location: " . HTML_ROOT_DIR . "/website/register.php");
        exit();
    } elseif (empty($email) || empty($password) || empty($first_name) || empty($last_name)) {
        $_SESSION["register_error"] = "All required fields must be filled.";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, password, first_name, last_name, country, city, address) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $email, $password, $first_name, $last_name, $country, $city, $address);

        $stmt->execute();

        $user_id = mysqli_insert_id($conn);

        $_SESSION["user"]["user_id"] = $user_id;
        $_SESSION["user"]["email"] = $email;
        $_SESSION["user"]["first_name"] = $first_name;
        $_SESSION["user"]["last_name"] = $last_name;
        $_SESSION["user"]["country"] = $country;
        $_SESSION["user"]["city"] = $city;
        $_SESSION["user"]["address"] = $address;
        $_SESSION["user"]["role"] = "user";

        unset($_SESSION["register_error"]);

        $subject = "Welcome to our website.";
        $body =
            "<html>
                <body>
                    <h1>Welcome, $first_name!</h1>
                    <p>Thank you for creating an account for our website. We hope you enjoy our catalogue of premium books and materials.</p>
                </body>
            </html>";
        
        include ROOT_DIR . "/website/partials/mailer.php";

        header("Location: " . HTML_ROOT_DIR . "/website/index.php");
        exit();
    }
}

$title = "Register Account";
include ROOT_DIR . "/website/partials/header.php";
?>

<main>
    <div class="container w-35-max p-5 my-5 rounded border border-1 border-secondary" id="registerForm">
        <h1 class="text-center mb-4">Register Account</h1>

        <?php
        if (isset($_SESSION["register_error"])) {
            echo '<div class="alert alert-danger rounded alert-dismissible fade show" role="alert">'
                . $_SESSION["register_error"] .
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>

        <form action="" method="POST">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" required>
                <label for="email" class="form-label">Email*</label>
                <div class="form-text">Email must be unique</div>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" required>
                <label for="password" class="form-label">Password*</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="first_name" name="first_name" required>
                <label for="first_name" class="form-label">First Name*</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="last_name" name="last_name" required>
                <label for="last_name" class="form-label">Last Name*</label>
            </div>
            <div class="form-floating mb-3">
                <select name="country" id="country" class="form-select" onchange="updateCities(this)">
                    <option value="" selected></option>
                    <?php
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, "https://countriesnow.space/api/v0.1/countries");
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($response, true);
                    foreach ($response["data"] as $index => $countryData) {
                        $country = $countryData["country"];
                        echo "<option value='$country' data-index='$index'>$country</option>";
                    }
                    ?>
                </select>
                <label for="country" class="form-label">Country</label>
            </div>
            <div class="form-floating mb-3">
                <select name="city" id="city" class="form-select" disabled>
                    <option value="" id="defaultCity" selected></option>
                </select>
                <label for="city">City</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="address" name="address">
                <label for="address" class="form-label">Address</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
            <div class="form-text">*Required fields</div>
        </form>
    </div>
</main>

<?php include ROOT_DIR . "/website/partials/footer.php"; ?>