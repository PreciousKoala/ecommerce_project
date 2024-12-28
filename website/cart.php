<?php
include "../config.php";

$title = "Your Cart";
include ROOT_DIR . "/website/partials/header.php";

$cart = json_decode($_COOKIE["cart"], true);
$products = array();
//var_dump($cart);
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

?>
<main id="cartMain">
    <?php
    if (!isset($cart) || empty($products)) {
        echo '<h1 class="text-center my-4">Your Cart is Empty</h1>';
    } else {
        echo '<h1 class="text-center my-4">Your Cart</h1>';
    }
    foreach ($products as $product) {
        $discount = "";
        $lineThrough = "";
        if ($product["discount"] > 0 && $product["stock"] != 0) {
            $discount = '<h5 class="text-danger">
                <span id="discountTotalPrice' . $product["product_id"] . '" >' .
                number_format($product["price"] * $product["quantity"] * (1 - $product["discount"]), 2, ".", "") . '&euro;
                </span>    
                <span class="badge bg-danger">'
                . $product["discount"] * 100 . '% OFF
                </span>
            </h5>';
            $lineThrough = "text-decoration-line-through";
        }

        echo '
        <div id="productRow' . $product["product_id"] . '" class="container p-3 my-5 row mx-auto border-bottom">
            <div class="container-fluid col-md-1 col-sm-12 col-12 mb-4">
                <img class="rounded ratio ratio-1x1" src="' . HTML_ROOT_DIR . '/website/img/products/' . $product["image_name"] . '" alt="image"/>
            </div>
            <div class="container-fluid col-md-8 col-sm-12 col-12 mb-4">
                <h5 class="text-wrap text-break">
                    <a class="text-decoration-none text-black" 
                    href="' . HTML_ROOT_DIR . '/website/productInfo.php?product_id=' . $product["product_id"] . '">' . $product["name"] . '</a></h5>
                <div class="text-muted">' . number_format($product["price"], 2, ".", "") . '&euro;</div>
            </div>
            <div class="container-fluid col-md-2 col-sm-12 col-12 mb-4">
                <div class="input-group my-auto text-center">
                    <button class="btn border-1 border-end-0 border-secondary rounded-start" type="button"
                        id="button-decrease" onclick="decreaseCartQuantity(' . $product["product_id"] . ', ' . $product["stock"] . ')">
                        −
                    </button>
                    <div class="form-floating">
                        <input id="quantity' . $product["product_id"] . '" type="text" inputmode="numeric" 
                            onchange="updateCart(' . $product["product_id"] . ', ' . $product["stock"] . ')"
                            class="form-control border-1 border-end-0 border-start-0 border-secondary text-center"
                            required value="' . $product["quantity"] . '" min="0">
                        <label for="quantity' . $product["product_id"] . '" class="form-label mx-auto">Quantity</label>
                    </div>
                    <button class="btn border-1 border-start-0 border-secondary rounded-end" type="button"
                        id="button-increase" onclick="increaseCartQuantity(' . $product["product_id"] . ', ' . $product["stock"] . ')">
                        +
                    </button>
                    <button class="btn btn-link" type="button shadow-none" onclick="removeFromCart(' . $product["product_id"] . ', ' . $product["stock"] . ')" ' . $disabled . '>
                        <i class="fa-solid fa-trash-can text-danger"></i>
                    </button>
                </div>
            </div>
            <div class="container-fluid col-md-1 col-sm-12 col-12 mb-4">
                <h5 id="totalPrice' . $product["product_id"] . '" class="' . $lineThrough . '">'
            . number_format($product["price"] * $product["quantity"], 2, ".", "") . '&euro;
                </h5>'
            . $discount .
            '</div>
            <div id="cleanPrice' . $product["product_id"] . '" class="d-none">' . $product["price"] . '</div>
            <div id="cleanDiscount' . $product["product_id"] . '" class="d-none">' . $product["discount"] . '</div>
        </div>';
    }
    ?>

    <div class="container p-3 my-5 row mx-auto">
        <div class="col-auto ms-auto">
            <h4 id="finalPrice">
                <?php
                $finalPrice = 0;
                foreach ($products as $product) {
                    $finalPrice += $product["price"] * $product["quantity"] * (1 - $product["discount"]);
                }
                echo "Total: " . number_format($finalPrice, 2, ".", "") . "&euro;";
                ?>
            </h4>
            <a class="btn btn-primary p-3" href="<?php echo HTML_ROOT_DIR ?>/website/checkout.php">
                Checkout
            </a>
        </div>
    </div>

</main>

<?php
include ROOT_DIR . "/website/partials/footer.php";
?>