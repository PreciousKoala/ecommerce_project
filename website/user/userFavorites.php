<?php
include "../../config.php";
include ROOT_DIR . "/website/partials/kickNonUsers.php";
$title = "Favorite Products";
include ROOT_DIR . "/website/partials/header.php";

$page = 1;
$productsPerPage = 16;

if (isset($_GET["page"])) {
    $page = intval($_GET["page"]);
}
echo $page;

$sql = "SELECT * FROM favorites AS f 
        JOIN products AS p ON p.product_id = f.product_id 
        WHERE f.user_id = ? ORDER BY f.added_at DESC
        LIMIT " . $productsPerPage . " OFFSET " . strval(($page - 1) * $productsPerPage);
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["user"]["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$favorites = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(*) AS total FROM favorites WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["user"]["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$totalProducts = $result->fetch_assoc()["total"];
$totalPages = ceil($totalProducts / $productsPerPage);
?>

<main>
    <div class="container my-5 row mx-auto">
        <h1 class="text-center mb-4">Favorites</h1>

        <?php
        if ($totalProducts == 0) {
            echo "<div class='mt-5 pt-5 display-5 text-center'>Nothing found :(</div>";
        }

        foreach ($favorites as $favorite) {
            $sql = "SELECT image_name FROM images WHERE placement = 1 AND product_id = " . $favorite["product_id"];
            $result = $conn->query($sql);
            $image = $result->fetch_assoc()["image_name"];
            if (!isset($image)) {
                $image = "no-image.png";
            }

            $sql = "SELECT AVG(rating) AS rating FROM reviews WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $favorite["product_id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $rating = $result->fetch_assoc()["rating"];

            if (!isset($rating)) {
                $rating = "<h6>No Rating</h6>";
            } else {
                $rating = "<h6>" . $rating * 100 . "% Rating</h6>";
            }

            $outOfStock = "";
            $gray = "";
            if ($favorite["stock"] == 0) {
                $outOfStock = "<h6><span class='badge bg-secondary'>OUT OF STOCK</span></h6>";
                $gray = "img-gray";
            }

            $discount = "";
            $lineThrough = "";
            if ($favorite["discount"] > 0 && $favorite["stock"] != 0) {
                $discount = '<h6 class="text-danger">' .
                    number_format($favorite["price"] * (1 - $favorite["discount"]), 2, ".", "") . '&euro;    
                    <span class="badge bg-danger">' . $favorite["discount"] * 100 . '% OFF</span></h6>';
                $lineThrough = "text-decoration-line-through";
            }

            echo
                '<div class="container-fluid col-md-3 col-sm-6 col-6 mb-4">
                    <div class="card card-zoom h-100 border-0">
                        <div class="card-body">
                            <img onmouseover="zoomImg(this)" src="' . HTML_ROOT_DIR . '/website/img/products/' . $image . '" 
                                class="card-img-top mb-3 rounded ' . $gray . '" alt="image">
                            <h6 class="card-title text-start">' . $favorite["name"] . '</h6>
                            <h5 class="card-text ' . $lineThrough . '">' . $favorite["price"] . '&euro;</h5>'
                . $discount . $outOfStock .
                '<a href="' . HTML_ROOT_DIR . '/website/productInfo.php?product_id=' . $favorite["product_id"] . '" class="stretched-link"></a>
                        </div>
                    </div>
                </div>';
        }
        ?>
    </div>
    <?php
    if ($totalProducts > 0) {
        include ROOT_DIR . "/website/partials/pagination.php";
    }
    ?>
</main>

<?php
include ROOT_DIR . "/website/partials/footer.php";
?>