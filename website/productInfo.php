<?php
include "../config.php";
include ROOT_DIR . "/website/partials/dbConn.php";
$title = "Product Details";
include ROOT_DIR . "/website/partials/header.php";

$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_GET["product_id"]);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

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

$sql = "SELECT * FROM reviews WHERE product_id = ? ORDER BY created_at DESC";
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
}

?>

<main id="productPage" class="my-5">
    <div class="display-5 my-2 text-center text-wrap text-break"><?php echo $product["name"] ?></div>

    <div id="productCarousel" class="carousel slide my-5" data-bs-theme="dark" data-bs-ride="carousel">
        <?php
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
                    class="d-block w-100 rounded" alt="image">
            </div>
            <?php
            for ($i = 1; $i < count($images); $i++) {
                echo '<div class="carousel-item" data-bs-interval="5000">
                <img src="' . HTML_ROOT_DIR . '/website/img/products/' . $images[$i]["image_name"] . '" class="d-block w-100 rounded" alt="image">
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

    <div class="row justify-content-between">
        <h4 class="col"><?php echo $product["price"] ?>&euro;</h4>

        <?php
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

    <p class="text-wrap text-break"><?php echo $product["description"] ?></p>

    <form class="row mb-5 justify-content-between">
        <div class="w-35 input-group text-center">
            <button class="btn border-1 border-end-0 border-secondary rounded-start" type="button"
                id="button-decrease">−</button>
            <div class="form-floating">
                <input type="text" inputmode="numeric"
                    class="form-control border-1 border-end-0 border-start-0 border-secondary text-center"
                    id="product_quantity" name="product_quantity" required value="1" min="1"
                    max="<?php echo $product["stock"] ?>">
                <label for="product_quantity" class="form-label mx-auto">Quantity</label>
            </div>
            <button class="btn border-1 border-start-0 border-secondary rounded-end" type="button"
                id="button-increase">+</button>
        </div>
        <button class="btn btn-primary w-35 text-center" type="button">Add to Cart</button>
    </form>

    <?php
    if (!isset($rating)) {
        echo "<h5>No Rating</h5>";
    } else {
        echo "<h5>" . $rating * 100 . "% of buyers liked this item</h5>";
    }
    ?>

    <div class="border border-1 border-secondary rounded my-3 p-3">
        <h5 class="mb-4">Reviews(<?php echo $totalReviews; ?>)</h5>
        <?php
        if ($totalReviews == 0) {
            echo "<h6>This item has no reviews yet</h6>";
        } else {
            foreach ($reviews as $review) {
                $like = "";
                if ($review["rating"] == 1) {
                    $like = '<i class="fa-solid fa-heart text-danger"></i> ';
                }
                echo '<div class="mb-4">
                <h6>' . $like . 'Posted at ' . date("F j Y, g:i A", strtotime($review["created_at"])) . '</h6>
                <p class="text-wrap text-break">' . $review["body"] . '<p>
            </div>';
            }
        }
        ?>
    </div>

</main>

<?php
include ROOT_DIR . "/website/partials/footer.php";
?>