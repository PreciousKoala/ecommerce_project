<?php
require "../config.php";
$title = "Product Details";
require ROOT_DIR . "/website/partials/header.php";

$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET["product_id"]);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($result->num_rows == 0) {
    $product = array(
        "product_id" => 0,
        "name" => "ITEM NOT FOUND",
        "price" => 0.00
    );
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $rating = intval($_POST["heart"]);
    $body = htmlspecialchars(trim($_POST["reviewBody"]));
    $sql = "INSERT INTO reviews (product_id, user_id, rating, body) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $_GET["product_id"], $_SESSION["user"]["user_id"], $rating, $body);
    $stmt->execute();
}

if (isset($_GET["favorite"]) && isset($_SESSION["user"])) {
    $favOpt = $_GET["favorite"];
    if ($favOpt == "1") {
        $sql = "SELECT * FROM favorites WHERE product_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $_GET["product_id"], $_SESSION["user"]["user_id"]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO favorites (product_id, user_id) 
                VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $_GET["product_id"], $_SESSION["user"]["user_id"]);
            $stmt->execute();
        }
    } else if ($favOpt == "0") {
        $sql = "DELETE FROM favorites WHERE product_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $_GET["product_id"], $_SESSION["user"]["user_id"]);
        $stmt->execute();
    }
}

$sql = "SELECT * FROM images WHERE product_id = ? ORDER BY placement ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET["product_id"]);
$stmt->execute();
$result = $stmt->get_result();
$images = $result->fetch_all(MYSQLI_ASSOC);

if (count($images) == 0) {
    $images = array(array("image_name" => "no-image.png"));
}

$sql = "SELECT r.rating, r.body, r.created_at, u.email FROM reviews AS r JOIN users AS u ON r.user_id = u.user_id
    WHERE r.product_id = ? ORDER BY r.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET["product_id"]);
$stmt->execute();
$result = $stmt->get_result();
$reviews = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT AVG(rating) AS rating, COUNT(*) AS totalreviews FROM reviews WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET["product_id"]);
$stmt->execute();
$result = $stmt->get_result();
$rating = $result->fetch_assoc();
$totalReviews = $rating["totalreviews"];
$rating = $rating["rating"];

if (isset($_SESSION["user"])) {
    $sql = "SELECT * FROM favorites WHERE product_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $_GET["product_id"], $_SESSION["user"]["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $favorite = $result->fetch_assoc();

    $sql = "SELECT * FROM orderProducts AS op 
            JOIN orders AS o ON op.order_id = o.order_id 
            WHERE op.product_id = ? AND o.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $_GET["product_id"], $_SESSION["user"]["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();

    $ordered = false;
    if ($result->num_rows > 0) {
        $ordered = true;
    }

    $sql = "SELECT * FROM reviews WHERE product_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $_GET["product_id"], $_SESSION["user"]["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();

    $alreadyReviewed = false;
    if ($result->num_rows >= 1) {
        $alreadyReviewed = true;
    }
}

?>

<main class="m-3">

    <div class="container my-5 row mx-auto">
        <div class="container-fluid col-md-6 col-sm-12 col-12 mb-4">
            <div id="productCarousel" class="carousel slide" data-bs-theme="dark" data-bs-ride="carousel">
                <?php
                $outOfStock = "";
                $gray = "";
                $disabled = "";
                if ($product["stock"] == 0) {
                    $outOfStock = "<h4><span class='badge bg-secondary'>OUT OF STOCK</span></h4>";
                    $gray = "img-gray";
                    $disabled = "disabled";
                }

                if (count($images) > 1) {
                    echo '<div class="carousel-indicators">
                <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true"></button>';

                    for ($i = 1; $i < count($images); $i++) {
                        echo '<button type="button" data-bs-target="#productCarousel" data-bs-slide-to="' . $i . '"></button>';
                    }

                    echo '</div>';
                }
                ?>
                <div class="carousel-inner container">
                    <div class="carousel-item active" data-bs-interval="5000">
                        <img src="<?php echo HTML_ROOT_DIR . "/website/img/products/" . $images[0]["image_name"] ?>"
                            class="d-block w-100 rounded img-contain <?php echo $gray ?>" alt="image">
                    </div>
                    <?php
                    for ($i = 1; $i < count($images); $i++) {
                        echo '<div class="carousel-item" data-bs-interval="5000">
                <img src="' . HTML_ROOT_DIR . '/website/img/products/' . $images[$i]["image_name"] . '" 
                    class="d-block w-100 rounded img-contain' . $gray . '" alt="image">
            </div>';
                    }
                    ?>
                </div>
                <?php
                if (count($images) > 1) {
                    echo '<button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>';
                }
                ?>
            </div>
        </div>
        <div class="container-fluid col-md-6 col-sm-12 col-12 mb-4">
            <div class="display-5 my-2 text-center text-wrap text-break"><?php echo $product["name"] ?></div>

            <?php
            $discount = "";
            $lineThrough = "";
            if ($product["discount"] > 0 && $product["stock"] != 0) {
                $discount = '<h4 class="card-text text-danger">' .
                    number_format($product["price"] * (1 - $product["discount"]), 2, ".", "") . '&euro;    
        <span class="badge bg-danger">' . $product["discount"] * 100 . '% OFF</span></h4>';
                $lineThrough = "text-decoration-line-through";
            }
            ?>

            <div class="row justify-content-between">
                <?php
                echo '<h4 class="col ' . $lineThrough . '">' . $product["price"] . '&euro;</h4>';

                if (isset($_SESSION["user"])) {
                    if (!isset($favorite)) {
                        echo '<h6 class="col text-end"><a class="text-decoration-none" 
                href=?product_id=' . $_GET["product_id"] . '&favorite=1>Favorite <i class="fa-regular fa-star text-warning"></i></a></h6>';
                    } else {
                        echo '<h6 class="col text-end"><a class="text-decoration-none" 
                href=?product_id=' . $_GET["product_id"] . '&favorite=0>Unfavorite <i class="fa-solid fa-star text-warning"></i></a></h6>';
                    }
                }
                ?>
            </div>

            <?php
            echo $outOfStock;
            echo $discount;
            ?>

            <div class="row mb-5 justify-content-between my-4">
                <div class="container col input-group text-center">
                    <button class="btn border-1 border-end-0 border-secondary rounded-start" type="button"
                        id="button-decrease" onclick="decreaseQuantity(<?php echo $product['stock'] ?>)">−</button>
                    <div class="form-floating">
                        <input type="text" inputmode="numeric"
                            class="form-control border-1 border-end-0 border-start-0 border-secondary text-center"
                            id="product_quantity" name="product_quantity" required value="1" min="1"
                            max="<?php echo $product["stock"] ?>">
                        <label for="product_quantity" class="form-label mx-auto">Quantity</label>
                    </div>
                    <button class="btn border-1 border-start-0 border-secondary rounded-end" type="button"
                        id="button-increase" onclick="increaseQuantity(<?php echo $product['stock'] ?>)">+</button>
                </div>
                <button class="container col btn btn-primary text-center" type="button"
                    onclick="addToCart(<?php echo $product['product_id'] . ', ' . $product['stock'] ?>)" <?php echo $disabled ?>>
                    Add to Cart
                </button>
            </div>

            <p class="text-wrap text-break"><?php echo nl2br($product["description"]) ?></p>

        </div>
        <div class="mx-auto">
            <?php
            if ($ordered && !$alreadyReviewed) {
                echo '
                <form id="reviewForm" class="border border-1 border-secondary rounded my-3 p-3" method="post">
                    <h5>Write Review</h5>
                    <div class="mb-3">
                        <input type="hidden" value="0" id="heart" name="heart">
                        <h5>
                            <label for="heart" id="unfilledHeart" onclick="fillHeart()">
                                <i class="fa-regular fa-heart"></i>
                            </label>
                            <label for="heart" id="filledHeart" class="d-none" onclick="unfillHeart()">
                                <i class="fa-solid fa-heart text-danger"></i>
                            </label>
                        </h5>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea rows="7" class="form-control h-100" name="reviewBody" id="reviewBody" required></textarea>
                        <label for="reviewBody" class="form-label">Body</label>
                        <div class="text-muted">Required</div>
                    </div>
                    <button type="submit" class="btn btn-primary p-2">Publish Review</button>
                </form>';
            }

            if (!isset($rating)) {
                echo "<h5>No Rating</h5>";
            } else {
                echo "<h5>" . $rating * 100 . "% of buyers liked this item</h5>";
            }

            echo '<div class="border border-1 border-secondary rounded my-3 p-3">
                <h4 class="mb-4">Reviews(' . $totalReviews . ')</h4>';

            if ($totalReviews == 0) {
                echo "<h5>This item has no reviews yet</h5>";
            } else {
                foreach ($reviews as $review) {
                    $like = "";
                    if ($review["rating"] == 1) {
                        $like = '<i class="fa-solid fa-heart text-danger"></i> ';
                    }
                    echo '<div class="mb-4">
                                <h6 class="text-wrap text-break">' . $review["email"] . '</h6>
                                <h6>' . $like . '
                                <small class="text-muted">
                                    Posted at ' . date("F j Y, g:i A", strtotime($review["created_at"])) .
                        '</small><h6>
                                <p class="text-wrap text-break">' . nl2br($review["body"]) . '<p>
                            </div>';
                }
            }
            ?>
        </div>
    </div>
    </div>

</main>

<?php
require ROOT_DIR . "/website/partials/footer.php";
?>