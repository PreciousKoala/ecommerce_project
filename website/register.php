<?php
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/dbConn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    $first_name = htmlspecialchars(trim($_POST["first_name"]));
    $last_name = htmlspecialchars(trim($_POST["last_name"]));
    $country = htmlspecialchars($_POST["country"]);
    $city = htmlspecialchars($_POST["city"]);
    $address = htmlspecialchars(trim($_POST["address"]));

    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION["register_error"] = "This email is already in use.";
        header("Location: /ecommerce_project/website/register.php");
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
        header("Location: /ecommerce_project/website/index.php");
        exit();
    }
}

$title = "Register Account";
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/header.php";
?>

<div class="container p-5 my-5 rounded border border-2 border-black" id="registerForm">
    <h2 class="text-center mb-4">Register Account</h2>

    <?php
    if (isset($_SESSION["register_error"])) {
        echo '<div class="alert alert-danger rounded alert-dismissible fade show" role="alert">'
            . $_SESSION["register_error"] .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password *</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name *</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name *</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="mb-3">
            <label for="country" class="form-label">Country:</label>
            <select name="country" id="country" class="form-select" onchange="updateCities(this)">
                <option value="" selected>Country</option>
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
        </div>
        <div class="mb-3">
            <label for="city">City:</label>
            <select name="city" id="city" class="form-select" disabled>
                <option value="" selected>City</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address">
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/footer.php"; ?>