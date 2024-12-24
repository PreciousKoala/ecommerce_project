<?php
include "../../config.php";
include ROOT_DIR . "/website/partials/kickNonAdmins.php";
$title = "Manage Users";
include ROOT_DIR . "/website/partials/header.php";

$sql = "SELECT * FROM users ORDER BY user_id ASC";
$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

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
                                <?php echo $user["city"] ?></option>
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

<main class="m-3">
    <div class="table-responsive table-scrollable">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">user ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Country</th>
                    <th scope="col">City</th>
                    <th scope="col">Adress</th>
                    <th scope="col">Creation Date</th>
                    <th scope="col">Role</th>
                    <th scope="col">Edit User</th>
                    <th scope="col">Delete User</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user) {
                    echo '<tr>
                        <th scope="row">' . $user["user_id"] . '</th>
                        <td>' . $user["email"] . '</td>
                        <td class="text-wrap text-break w-15-ch-min">' . $user["first_name"] . '</td>
                        <td class="text-wrap text-break w-15-ch-min">' . $user["last_name"] . '</td>
                        <td class="text-wrap text-break w-20-ch-min">' . $user["country"] . '</td>
                        <td class="text-wrap text-break w-20-ch-min">' . $user["city"] . '</td>
                        <td class="text-wrap text-break w-20-ch-min">' . $user["address"] . '</td>
                        <td class="text-wrap text-break w-20-ch-min">' . $user["created_at"] . '</td>
                        <td>' . $user["role"] . '</td>
                        <td>
                            <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php
include ROOT_DIR . "/website/partials/footer.php";
?>