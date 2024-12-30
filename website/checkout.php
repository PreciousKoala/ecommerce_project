<?php
include "../config.php";

$title = "Checkout";
include ROOT_DIR . "/website/partials/header.php";

$cart = json_decode($_COOKIE["cart"], true);
$products = array();

foreach ($cart as $cartItem) {
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cartItem["product_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    if ($product["stock"] != 0) {
        if ($cartItem["quantity"] > $product["stock"]) {
            $product["quantity"] = $product["stock"];
        } else {
            $product["quantity"] = $cartItem["quantity"];
        }
        $products[] = $product;
    }
}

$images = array();
foreach ($products as $product) {
    $sql = "SELECT image_name FROM images WHERE product_id = ? AND placement = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product["product_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        $images[]["image_name"] = "no-image.png";
    } else {
        $images[] = $result->fetch_assoc();
    }
}

for ($i = 0; $i < count($products); $i++) {
    $products[$i]["image_name"] = $images[$i]["image_name"];
}

if (empty($products)) {
    header("Location: " . HTML_ROOT_DIR . "/website/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $country = $_POST["country"];
    $city = $_POST["city"];
    $address = trim($_POST["address"]);

    if (empty($email) || empty($first_name) || empty($last_name) || empty($country) || empty($city) || empty($address)) {
        $_SESSION["checkout_error"] = "All required fields must be filled.";
    } else {
        $sql = "INSERT INTO orders (user_id, order_email, order_first_name, order_last_name, order_country, order_city, order_address) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssss", $_SESSION["user"]["user_id"], $email, $first_name, $last_name, $country, $city, $address);
        $stmt->execute();

        $order_id = mysqli_insert_id($conn);

        foreach ($products as $product) {
            $sql = "INSERT INTO orderProducts (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiid", $order_id, $product["product_id"], $product["quantity"], $product["price"]);
            $stmt->execute();

            $sql = "UPDATE products SET sales = sales + ?, stock = stock - ? WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $product["quantity"], $product["quantity"], $product["product_id"]);
            $stmt->execute();
        }

        $body = '<html>
        <head>
            <style>
                :root {
                    --bs-border-width: 1px;
                    --bs-border-style: solid;
                    --bs-border-color: #dee2e6;
                    --bs-border-radius: 0.375rem;
                    --bs-secondary-color: rgba(222, 226, 230, 0.75);
                    --bs-white-rgb: 255, 255, 255;
                }

                .container,
                .container-fluid {
                    --bs-gutter-x: 1.5rem;
                    --bs-gutter-y: 0;
                    width: 100%;
                    padding-right: calc(var(--bs-gutter-x) * .5);
                    padding-left: calc(var(--bs-gutter-x) * .5);
                    margin-right: auto;
                    margin-left: auto;
                }

                @media (min-width: 576px) {
                    .container, .container-sm {
                        max-width: 540px; 
                    } 
                }

                @media (min-width: 768px) {
                    .container {
                        max-width: 720px; 
                    } 
                }

                @media (min-width: 992px) {
                    .container {
                        max-width: 960px; 
                    } 
                }

                @media (min-width: 1200px) {
                    .container {
                        max-width: 1140px; 
                    } 
                }

                @media (min-width: 1400px) {
                    .container {
                        max-width: 1320px; 
                    } 
                }

                .p-3 {
                    padding: 1rem !important;
                }

                .my-5 {
                    margin-top: 3rem !important;
                    margin-bottom: 3rem !important;
                }

                .mx-auto {
                    margin-right: auto !important;
                    margin-left: auto !important; 
                }

                .ms-auto {
                    margin-left: auto !important;
                }

                .mb-4 {
                    margin-bottom: 1.5rem !important;
                }

                .border-bottom {
                    border-bottom: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important; 
                }
                
                .row {
                    --bs-gutter-x: 1.5rem;
                    --bs-gutter-y: 0;
                    display: flex;
                    flex-wrap: wrap;
                    margin-top: calc(-1 * var(--bs-gutter-y));
                    margin-right: calc(-.5 * var(--bs-gutter-x));
                    margin-left: calc(-.5 * var(--bs-gutter-x)); 
                }

                .row > * {
                    flex-shrink: 0;
                    width: 100%;
                    max-width: 100%;
                    padding-right: calc(var(--bs-gutter-x) * .5);
                    padding-left: calc(var(--bs-gutter-x) * .5);
                     margin-top: var(--bs-gutter-y); 
                }

                .text-muted {
                    --bs-text-opacity: 1;
                    color: var(--bs-secondary-color) !important; 
                }

                .col {
                    flex: 1 0 0%;
                }

                .col-2 {
                    flex: 0 0 auto;
                    width: 16.66666667%; 
                }

                .col-3 {
                    flex: 0 0 auto;
                    width: 25%; 
                }

                .col-7 {
                    flex: 0 0 auto;
                    width: 58.33333333%; 
                }

                .col-auto {
                    flex: 0 0 auto;
                    width: auto; 
                }

                .rounded {
                    border-radius: var(--bs-border-radius) !important; 
                }

                .text-wrap {
                    white-space: normal !important; 
                }

                .text-break {
                    word-wrap: break-word !important;
                    word-break: break-word !important; 
                }

                .ratio {
                    position: relative;
                    width: 100%; 
                }

                .ratio-1x1 {
                    --bs-aspect-ratio: 100%; 
                }

                .ratio::before {
                    display: block;
                    padding-top: var(--bs-aspect-ratio);
                    content: ""; 
                }

                .ratio > * {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                }

                .bg-white {
                    --bs-bg-opacity: 1;
                    background-color: rgba(var(--bs-white-rgb), var(--bs-bg-opacity)) !important; 
                }

                img {
                    max-width: 100px;
                    max-height: 100px;
                    aspect-ratio: 1 / 1;
                    object-fit: cover;
                }

            </style>
        </head>
        <body class="bg-white">
            <h1 class="mb-4">Order #' . $order_id . '</h1>';

        foreach ($products as $product) {
            $body .= '
        <div class="container p-3 my-5 row mx-auto border-bottom">
            <div class="col-2 mb-4">
                <img class="rounded ratio ratio-1x1" src="website/img/products/' . $product["image_name"] . '" alt="image"/>
            </div>
            <div class="col-7 mb-4 p-3">
                <h3 class="text-wrap text-break">' . $product["quantity"] . ' &times; ' . $product["name"] . '</h3>
                <div class="text-muted">' . number_format($product["price"] * (1 - $product["discount"]), 2, ".", "") . '&euro;</div>
            </div>
            <div class="col-3 mb-4">
                <h4>'
                . number_format($product["price"] * $product["quantity"] * (1 - $product["discount"]), 2, ".", "") . '&euro;
                </h4>
            </div>
        </div>';
        }

        $finalPrice = 0;
        foreach ($products as $product) {
            $finalPrice += $product["price"] * $product["quantity"] * (1 - $product["discount"]);
        }
        $body .= '
            <div class="p-3 row mx-auto">
                <div class="col-auto ms-auto">
                    <h1>Total: ' . number_format($finalPrice, 2, ".", "") . '&euro;</h1>
                </div>
            </div>';

        $subject = "Your order has been placed.";

        include ROOT_DIR . "/website/partials/mailer.php";

        setcookie("cart", "", 0, "/");
        unset($_SESSION["checkout_error"]);
        header("Location: " . HTML_ROOT_DIR . "/website/index.php");
        exit();
    }
}


?>

<main>
    <?php
    if (isset($_SESSION["checkout_error"])) {
        echo '<div class="alert alert-danger rounded alert-dismissible fade show" role="alert">'
            . $_SESSION["checkout_error"] .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    ?>
    <div id="checkoutShipping" class="container w-35-max p-5 my-5 rounded border border-1 border-secondary">
        <h1 class="text-center mb-4">Shipping Details</h1>
        <form id="shippingForm" action="" method="POST">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" required
                    value="<?php echo $_SESSION["user"]["email"] ?>">
                <label for="email" class="form-label">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="first_name" name="first_name" required
                    value="<?php echo $_SESSION["user"]["first_name"] ?>">
                <label for="first_name" class="form-label">First Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="last_name" name="last_name" required
                    value="<?php echo $_SESSION["user"]["last_name"] ?>">
                <label for="last_name" class="form-label">Last Name</label>
            </div>
            <div class="form-floating mb-3">
                <select name="country" id="country" class="form-select" onchange="updateCities(this)">
                    <option value=""></option>
                    <?php
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, "https://countriesnow.space/api/v0.1/countries");
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($response, true);
                    foreach ($response["data"] as $index => $countryData) {
                        $country = $countryData["country"];
                        echo "<option value='$country' data-index='$index'";
                        if ($_SESSION["user"]["country"] == $country) {
                            echo " selected";
                        }
                        echo ">$country</option>";
                    }
                    ?>
                </select>
                <label for="country" class="form-label">Country</label>
            </div>
            <div class="form-floating mb-3">
                <select name="city" id="city" class="form-select" disabled>
                    <option value="<?php echo $_SESSION["user"]["city"] ?>" id="defaultCity" selected>
                        <?php echo $_SESSION["user"]["city"] ?>
                    </option>
                </select>
                <label for="city">City</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="address" name="address"
                    value="<?php echo $_SESSION["user"]["address"] ?>">
                <label for="address" class="form-label">Address</label>
            </div>
            <div class="form-text">All fields are required.</div>
        </form>
        <div class="container row mx-auto mt-4">
            <div class="col-md-6 col-sm-12 mb-2 ms-auto">
                <button class="btn btn-primary p-3 w-100" onclick="if (validateForm('shippingForm')) showPaymentForm()">
                    Enter Shipping Details
                </button>
            </div>
        </div>
    </div>

    <div id="checkoutPayment" class="d-none container w-35-max p-5 my-5 rounded border border-1 border-secondary">
        <h1 class="text-center mb-4">Payment Details</h1>
        <form id="paymentForm">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="cardName" name="cardName" required>
                <label for="cardName" class="form-label">Name on Card</label>
            </div>
            <div class="form-floating mb-3">
                <input name="cardNum" class="form-control" type="tel" pattern="\d*" minlength="16" maxlength="16"
                    required>
                <label for="cardNum" class="form-label">Credit Card Number</label>
            </div>
            <div class="form-floating mb-3">
                <input type="tel" class="form-control" id="cardExp" name="cardExp" minlength="5" maxlength="5"
                    pattern="^(0[1-9]|1[0-2])\/\d{2}$" title="MM/YY" required>
                <label for="cardExp" class="form-label">Expiration Date</label>
            </div>
            <div class="form-floating mb-3">
                <input type="tel" class="form-control" id="cardCVC" name="cardCVC" minlength="3" maxlength="3" required>
                <label for="cardCVC" class="form-label">CVC</label>
            </div>
            <div class="form-text">All fields are required.</div>
        </form>
        <div class="container row mx-auto mt-4 align-items-end">
            <div class="col-md-6 col-sm-12 mb-2 me-auto">
                <button class="btn btn-secondary p-3 w-100" onclick="showShippingForm()">
                    Go Back
                </button>
            </div>
            <div class="col-md-6 col-sm-12 mb-2 ms-auto">
                <button class="btn btn-primary p-3 w-100" onclick="if (validateForm('paymentForm')) showConfirmForm()">
                    Enter Payment Details
                </button>
            </div>
        </div>
    </div>

    <div id="checkoutConfirm" class="d-none container w-35-max p-5 my-5 rounded border border-1 border-secondary">
        <?php
        echo '<h1 class="text-center my-4">Confirm Order</h1>';

        foreach ($products as $product) {
            echo '
            <div class="container p-3 my-5 row mx-auto border-bottom">
                <div class="container-fluid col-md-3 col-sm-12 col-12 mb-4">
                    <img class="rounded ratio ratio-1x1" src="' . HTML_ROOT_DIR . '/website/img/products/' . $product["image_name"] . '" alt="image"/>
                </div>
                <div class="container-fluid col-md-7 col-sm-12 col-12 mb-4">
                    <h5 class="text-wrap text-break">' . $product["quantity"] . ' &times; ' . $product["name"] . '</h5>
                    <div class="text-muted">' . number_format($product["price"] * (1 - $product["discount"]), 2, ".", "") . '&euro;</div>
                </div>
                <div class="container-fluid col-md-2 col-sm-12 col-12 mb-4">
                    <h5>'
                . number_format($product["price"] * $product["quantity"] * (1 - $product["discount"]), 2, ".", "") . '&euro;
                    </h5>
                </div>
            </div>';
        }

        if (!empty($products)) {
            $finalPrice = 0;
            foreach ($products as $product) {
                $finalPrice += $product["price"] * $product["quantity"] * (1 - $product["discount"]);
            }
            echo '
            <div class="container p-3 my-2 row mx-auto">
                <div class="col-auto ms-auto">
                    <h4>Total: ' . number_format($finalPrice, 2, ".", "") . '&euro;</h4>
                </div>
            </div>';
        }
        ?>
        <div class="container row mx-auto align-items-end">
            <div class="col-md-6 col-sm-12 mb-2 me-auto mt-4">
                <button class="btn btn-secondary p-3 w-100" onclick="showPaymentForm()">
                    Go Back
                </button>
            </div>
            <div class="col-md-6 col-sm-12 mb-2 ms-auto">
                <button type="submit" form="shippingForm" class="btn btn-primary p-3 w-100" onclick="showConfirmForm()">
                    Confirm Order
                </button>
            </div>
        </div>
    </div>
</main>

<?php
include ROOT_DIR . "/website/partials/footer.php";
?>