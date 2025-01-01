<?php
include "../../config.php";
include ROOT_DIR . "/website/partials/kickNonUsers.php";
$title = "Order History";
include ROOT_DIR . "/website/partials/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["cancelButton"])) {
        $cancel_id = intval($_POST["cancel_order_id"]);

        $sql = "UPDATE orders SET cancelled_at = CURRENT_TIMESTAMP() WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cancel_id);
        $stmt->execute();
    }
}

$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["user"]["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Order Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="orderInfoList" class="list-group list-group-flush">
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">Email:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">First Name:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">Last Name:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">Country:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">City:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">Address:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="productsModal" tabindex="-1" aria-labelledby="productsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productsModalLabel">Order Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to cancel order #<span id="cancelModalOrderId"></span>?
            </div>
            <form method="post" class="modal-footer">
                <input id="cancelOrderId" type="hidden" name="cancel_order_id">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
                <button name="cancelButton" type="submit" class="btn btn-danger">Cancel Order</button>
            </form>
        </div>
    </div>
</div>

<main class="m-3">
    <h1 class="text-center mb-3">Order History</h1>
    <div class="container table-responsive table-scrollable mx-auto">
        <table class="table table-hover mx-auto table-fit">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Total Price</th>
                    <th scope="col">Creation Date</th>
                    <th scope="col">Cancellation Date</th>
                    <th scope="col">Info</th>
                    <th scope="col">Items</th>
                    <th scope="col">Cancel</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($orders as $order) {
                    $sql = "SELECT SUM(price * quantity) AS totalPrice FROM orderProducts WHERE order_id = ?; ";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $order["order_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $totalPrice = number_format($result->fetch_assoc()["totalPrice"], 2, ".", "");

                    $sql = "SELECT op.price, op.quantity, op.returned, p.name, p.product_id 
                            FROM orderProducts AS op 
                            JOIN products AS p ON p.product_id = op.product_id 
                            WHERE op.order_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $order["order_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $products = $result->fetch_all(MYSQLI_ASSOC);

                    $disabled = "";
                    if (time() - strtotime($order["created_at"]) > 24 * 60 * 60 || $order["cancelled_at"] != NULL) {
                        $disabled = "disabled";
                    }

                    echo '<tr>
                        <th scope="row">' . $order["order_id"] . '</th>
                        <td>' . $order["user_id"] . '</td>
                        <td>' . $totalPrice . '&euro;</td>
                        <td>' . $order["created_at"] . '</td>
                        <td>' . $order["cancelled_at"] . '</td>
                        <td>
                            <button id="infoButtonModal' . $order["order_id"] . '" class="btn btn-secondary" type="button"
                             data-bs-toggle="modal" data-bs-target="#infoModal" onclick="showInfo(this)">
                                <i class="fa-solid fa-truck"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-primary accordion-toggle"  data-bs-toggle="collapse" 
                            data-bs-target="#orderDropdown' . $order["order_id"] . '">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </button>
                        </td>
                        <td>
                            <button id="cancelButtonModal' . $order["order_id"] . '" class="btn btn-danger ' . $disabled . '" type="button"
                             data-bs-toggle="modal" data-bs-target="#cancelModal" onclick="showOrderId(this)">
                                <i class="fa-solid fa-ban"></i>
                            </button>
                        </td>
                        <td class="d-none">
                            <div>
                                ' . $order["order_email"] . '
                            </div>
                            <div>
                                ' . $order["order_first_name"] . '
                            </div>
                            <div>
                                ' . $order["order_last_name"] . '
                            </div>
                            <div>
                                ' . $order["order_country"] . '
                            </div>
                            <div>
                                ' . $order["order_city"] . '
                            </div>
                            <div>
                                ' . $order["order_address"] . '
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" class="p-0">
                            <div id="orderDropdown' . $order["order_id"] . '" class="accordion-body collapse">';

                    foreach ($products as $product) {
                        $sql = "SELECT image_name FROM images WHERE product_id = ? AND placement = 1";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $product["product_id"]);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows == 0) {
                            $image = "no-image.png";
                        } else {
                            $image = $result->fetch_assoc()["image_name"];
                        }

                        $product["image_name"] = $image;

                        echo '
                                <div class="container p-3 m-0 row border-bottom">
                                    <div class="col-2 mb-4">
                                        <img class="rounded ratio ratio-1x1" 
                                        style="max-height: 5em; max-width: 5em" 
                                        src="' . HTML_ROOT_DIR . '/website/img/products/' . $product["image_name"] . '" 
                                        alt="image"/>
                                    </div>
                                    <div class="col-7 mb-4 p-3">
                                        <h5 class="text-wrap text-break">' . $product["quantity"] . ' &times; ' . $product["name"] . '</h5>
                                        <div class="text-muted">' . number_format($product["price"], 2, ".", "") . '&euro;</div>
                                    </div>
                                    <div class="col-3 mb-4 p-3">
                                        <h5>'
                            . number_format($product["price"] * $product["quantity"], 2, ".", "") . '&euro;
                                        </h5>
                                    </div>
                                </div>';
                    }

                    echo '  </div>
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