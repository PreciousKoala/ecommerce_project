<?php
include "../../config.php";
include ROOT_DIR . "/website/partials/kickNonUsers.php";
$title = "User Profile";
include ROOT_DIR . "/website/partials/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $country = ($_POST["country"]);
    $city = $_POST["city"];
    $address = trim($_POST["address"]);

    if (empty($first_name) || empty($last_name)) {
        $_SESSION["user_edit_error"] = "All required fields must be filled.";
    } else {

        $sql = "UPDATE users 
                SET first_name = ?, last_name = ?, country = ?, city = ?, address = ?
                WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $first_name, $last_name, $country, $city, $address, $_SESSION["user"]["user_id"]);
        $stmt->execute();

        $_SESSION["user"]["first_name"] = $first_name;
        $_SESSION["user"]["last_name"] = $last_name;
        $_SESSION["user"]["country"] = $country;
        $_SESSION["user"]["city"] = $city;
        $_SESSION["user"]["address"] = $address;

        unset($_SESSION["user_edit_error"]);
    }
}

// to get creation date
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["user"]["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" action="" method="POST">
                    <div class="form-floating mb-3">
                        <input type="email" value="<?php echo $user["email"] ?>" class="form-control" id="email"
                            name="email" disabled>
                        <label for="email" class="form-label">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" value="xxxxxxxx" class="form-control" id="password" name="password"
                            disabled>
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="<?php echo $user["first_name"] ?>" class="form-control"
                            id="first_name" name="first_name" required>
                        <label for="first_name" class="form-label">First Name*</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="<?php echo $user["last_name"] ?>" class="form-control" id="last_name"
                            name="last_name" required>
                        <label for="last_name" class="form-label">Last Name*</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="country" id="country" class="form-select" onload="updateCities(this)"
                            onchange="updateCities(this)">
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
                                if ($user["country"] == $country) {
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
                            <option value="<?php echo $user["city"] ?>" id="defaultCity" selected>
                                <?php echo $user["city"] ?>
                            </option>
                        </select>
                        <label for="city">City</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="<?php echo $user["address"] ?>" class="form-control" id="address"
                            name="address">
                        <label for="address" class="form-label">Address</label>
                    </div>
                    <div class="form-text">*Required fields</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" form="editUserForm">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<main>
    <div class="container w-35-max p-5 my-5">
        <h1 class="text-center mb-4">Your Account</h1>

        <?php
        if (isset($_SESSION["user_edit_error"])) {
            echo '<div class="alert alert-danger rounded alert-dismissible fade show" role="alert">'
                . $_SESSION["user_edit_error"] .
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>
        <div class="list-group list-group-flush">
            <div class="list-group-item">
                <h6 class="list-group-item-heading">Email:</h6>
                <p class="list-group-item-text text-wrap text-break mb-1"><?php echo $user["email"] ?></p>
            </div>
            <div class="list-group-item">
                <h6 class="list-group-item-heading">Password:</h6>
                <p class="list-group-item-text mb-1">••••••••</p>
            </div>
            <div class="list-group-item">
                <h6 class="list-group-item-heading">First Name:</h6>
                <p class="list-group-item-text text-wrap text-break mb-1"><?php echo $user["first_name"] ?></p>
            </div>
            <div class="list-group-item">
                <h6 class="list-group-item-heading">Last Name:</h6>
                <p class="list-group-item-text text-wrap text-break mb-1"><?php echo $user["last_name"] ?></p>
            </div>
            <div class="list-group-item">
                <h6 class="list-group-item-heading">Country:</h6>
                <p class="list-group-item-text text-wrap text-break mb-1"><?php echo $user["country"] ?></p>
            </div>
            <div class="list-group-item">
                <h6 class="list-group-item-heading">City:</h6>
                <p class="list-group-item-text text-wrap text-break mb-1"><?php echo $user["city"] ?></p>
            </div>
            <div class="list-group-item">
                <h6 class="list-group-item-heading">Address:</h6>
                <p class="list-group-item-text text-wrap text-break mb-1"><?php echo $user["address"] ?></p>
            </div>
            <div class="list-group-item">
                <h6 class="list-group-item-heading">Account Creation Date:</h6>
                <p class="list-group-item-text text-wrap text-break mb-1"><?php echo $user["created_at"] ?></p>
            </div>
        </div>
        <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#editModal">
            Edit Details <i class="fa-solid fa-pen-to-square"></i>
        </button>
</main>

<?php
include ROOT_DIR . "/website/partials/footer.php";
?>