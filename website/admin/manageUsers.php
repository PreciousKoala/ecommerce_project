<?php
include "../../config.php";
include ROOT_DIR . "/website/partials/kickNonAdmins.php";
$title = "Manage Users";
include ROOT_DIR . "/website/partials/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deleteButton"])) {
        $delete_id = intval($_POST["delete_user_id"]);

        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
    }

    if (isset($_POST["editButton"])) {
        $edit_id = intval($_POST["edit_user_id"]);

        $first_name = trim($_POST["first_name"]);
        $last_name = trim($_POST["last_name"]);
        $country = $_POST["country"];
        $city = $_POST["city"];
        $address = trim($_POST["address"]);
        $role = $_POST["role"];

        $sql = "UPDATE users 
                SET first_name = ?, last_name = ?, country = ?, city = ?, address = ?, role = ?
                WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $first_name, $last_name, $country, $city, $address, $role, $edit_id);
        $stmt->execute();
    }
}

$sql = "SELECT * FROM users ORDER BY user_id ASC";
$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(*) AS totalUsers FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$totalUsers = $result->fetch_assoc()["totalUsers"];
?>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete user #<span id="deleteModalUserId"></span>?
            </div>
            <form method="post" class="modal-footer">
                <input id="deleteUserId" type="hidden" name="delete_user_id">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button name="deleteButton" type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User #<span id="editModalUserId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" action="" method="POST">
                    <input name="edit_user_id" id="editUserId" type="hidden" value="">
                    <div class="form-floating mb-3">
                        <input type="email" value="" class="form-control" id="email" name="email" disabled>
                        <label for="email" class="form-label">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" value="xxxxxxxx" class="form-control" id="password" name="password"
                            disabled>
                        <label for="password" class="form-label">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="" class="form-control" id="first_name" name="first_name" required>
                        <label for="first_name" class="form-label">First Name*</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="" class="form-control" id="last_name" name="last_name" required>
                        <label for="last_name" class="form-label">Last Name*</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="" class="form-control" id="country" name="country">
                        <label for="country" class="form-label">Country</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="" class="form-control" id="city" name="city">
                        <label for="city">City</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="" class="form-control" id="address" name="address">
                        <label for="address" class="form-label">Address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="role" id="role" class="form-select">
                            <option value="user">user</option>
                            <option value="admin">admin</option>
                        </select>
                        <label for="role">Role</label>
                    </div>
                    <div class="form-text">*Required fields</div>
                </form>
            </div>
            <form method="POST" class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button name="editButton" type="submit" class="btn btn-primary" form="editUserForm">Save
                    Changes</button>
            </form>
        </div>
    </div>
</div>

<main class="m-3">
    <h1 class="text-center mb-3">Manage Users</h1>

    <div class="text-center mb-3">Total Users: <?php echo $totalUsers; ?></div>

    <div class="container table-responsive table-scrollable mx-auto">
        <table class="table table-hover mx-auto">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Country</th>
                    <th scope="col">City</th>
                    <th scope="col">Adress</th>
                    <th scope="col">Creation Date</th>
                    <th scope="col">Role</th>
                    <th scope="col">Logs</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($users as $user) {

                    $sql = "SELECT * FROM userLogs WHERE user_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user["user_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $logs = $result->fetch_all(MYSQLI_ASSOC);

                    $disabled = "";
                    if ($_SESSION["user"]["user_id"] == $user["user_id"]) {
                        $disabled = "disabled";
                    }

                    echo '<tr>
                        <th scope="row">' . $user["user_id"] . '</th>
                        <td>' . $user["email"] . '</td>
                        <td class="text-wrap text-break">' . $user["first_name"] . '</td>
                        <td class="text-wrap text-break">' . $user["last_name"] . '</td>
                        <td class="text-wrap text-break">' . $user["country"] . '</td>
                        <td class="text-wrap text-break">' . $user["city"] . '</td>
                        <td class="text-wrap text-break">' . $user["address"] . '</td>
                        <td class="text-wrap text-break">' . $user["created_at"] . '</td>
                        <td>' . $user["role"] . '</td>
                        <td>
                            <button class="btn btn-secondary accordion-toggle" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#logsDropdown' . $user["user_id"] . '">
                                <i class="fa-solid fa-file-lines"></i>
                            </button>
                        </td>
                        <td>
                            <button id="editButtonModal' . $user["user_id"] . '" class="btn btn-secondary" type="button"
                             data-bs-toggle="modal" data-bs-target="#editModal" onclick="showUserDetails(this)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                        <td>
                            <button id="deleteButtonModal' . $user["user_id"] . '" class="btn btn-danger" type="button"
                             data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="showUserId(this)" ' . $disabled . '>
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12" class="p-0">
                            <div id="logsDropdown' . $user["user_id"] . '" class="accordion-body collapse">
                                <div class="table-responsive table-scrollable">
                                    <table class="table table-hover my-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Login</th>
                                                <th scope="col">Logout</th>
                                                <th scope="col">Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                    foreach ($logs as $log) {
                        $login = $log["login_datetime"];
                        $logout = "-";
                        $duration = "-";
                        if ($log["logout_datetime"] != NULL) {
                            $logout = $log["logout_datetime"];
                            $from = date_create($login);
                            $until = date_create($logout);
                            $diff = date_diff($from, $until);

                            $durationNums = array();
                            if ($diff->days > 0) {
                                $durationNums[] = $diff->days . " days";
                            }
                            if ($diff->h > 0) {
                                $durationNums[] = $diff->h . " hours";
                            }
                            if ($diff->i > 0) {
                                $durationNums[] = $diff->i . " minutes";
                            }
                            if ($diff->s > 0) {
                                $durationNums[] = $diff->s . " seconds";
                            }

                            $duration =  implode(", ", $durationNums);
                        }

                        echo '
                                            <tr>
                                                <td>'.$login.'</td>
                                                <td>'.$logout.'</td>
                                                <td>'.$duration.'</td>
                                            </tr>';
                    }
                
                    echo '
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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