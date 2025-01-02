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

        $subject = "Your order has been cancelled.";
        $body = "
        <html>
            <body>
                <p>Order #" . $cancel_id . " has been cancelled, but we're still taking your money :).</p>
            </body>
        </html>";

        $sql = "SELECT order_email FROM orders WHERE order_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cancel_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $email = $result->fetch_assoc()["order_email"];

        include ROOT_DIR . "/website/partials/mailer.php";
    }

    if (isset($_POST["returnButton"])) {
        $return_order_id = intval($_POST["return_order_id"]);
        $return_product_id = intval($_POST["return_product_id"]);
        $return_quantity = intval($_POST["product_quantity"]);

        echo $return_order_id;
        echo " ";
        echo $return_product_id;
        echo " ";
        echo $return_quantity;

        $sql = "SELECT returned, quantity FROM orderProducts WHERE order_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $return_order_id, $return_product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $orderProduct = $result->fetch_assoc();
        
        if ($orderProduct["returned"] + $return_quantity > $orderProduct["quantity"]) {
            $return_quantity = $orderProduct["quantity"];
        } else {
            $return_quantity += $orderProduct["returned"];
        }
        echo " ";
        echo $return_quantity;

        $sql = "UPDATE orderProducts SET returned = ? WHERE order_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $return_quantity, $return_order_id, $return_product_id);
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

<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnModalLabel">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Enter the number of items you want to return.
                <form id="returnForm" method="post" class="w-35 my-2 mx-auto input-group text-center">
                    <input id="returnOrderId" type="hidden" name="return_order_id">
                    <input id="returnProductId" type="hidden" name="return_product_id">
                    <button class="btn border-1 border-end-0 border-secondary rounded-start" type="button"
                        id="button-decrease" onclick="decreaseQuantity(10000000)">−</button>
                    <div class="form-floating">
                        <input type="text" inputmode="numeric"
                            class="form-control border-1 border-end-0 border-start-0 border-secondary text-center"
                            id="product_quantity" name="product_quantity" required value="1" min="1">
                        <label for="product_quantity" class="form-label mx-auto">Quantity</label>
                    </div>
                    <button class="btn border-1 border-start-0 border-secondary rounded-end" type="button"
                        id="button-increase" onclick="increaseQuantity(10000000)">+</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button name="returnButton" form="returnForm" type="submit" class="btn btn-danger">Return Items</button>
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
    <div class="text-center mb-3 text-muted">You can cancel an order within 24 hours.</div>

    <div class="container table-responsive table-scrollable mx-auto">
        <table class="table table-hover mx-auto table-fit">
            <thead>
                <tr>
                    <th scope="col"></th>
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

                    $disabledCancel = "";
                    if (time() - strtotime($order["created_at"]) > 24 * 60 * 60 || $order["cancelled_at"] != NULL) {
                        $disabledCancel = "disabled";
                    }

                    $cancelled = "";
                    if ($order["cancelled_at"] != NULL) {
                        $cancelled = '<i class="fa-solid fa-circle-exclamation text-danger"></i>';
                    }

                    echo '<tr>
                        <td>' . $cancelled . '</td>
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
                            <button id="cancelButtonModal' . $order["order_id"] . '" class="btn btn-danger ' . $disabledCancel . '" type="button"
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

                        $disabledReturn = "";
                        if ($product["returned"] >= $product["quantity"] || !empty($cancelled)) {
                            $disabledReturn = "disabled";
                        }

                        $returned = "";
                        if ($product["returned"] > 0) {
                            $returned = '<div class="text-muted">Returned &times; ' . $product["returned"] . '</div>';
                        }

                        echo '
                                <div class="container p-3 m-0 row border-bottom">
                                    <div class="d-none">' . $order["order_id"] . '</div>
                                    <div class="d-none">' . $product["product_id"] . '</div>
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
                                        <button id="returnButtonModal' . $order["order_id"] . '" class="btn btn-danger ' . $disabledReturn . '" 
                                        type="button" data-bs-toggle="modal" data-bs-target="#returnModal" onclick="showOrderProductId(this)">
                                            Return <i class="fa-solid fa-arrow-rotate-left"></i>
                                        </button>
                                        ' . $returned . '
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