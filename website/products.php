<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

}

$page = 1;
$productsPerPage = 16;

if (isset($_GET["page"])) {
    $page = intval($_GET["page"]);
}

if (!isset($_GET["sortBy"])) {
    $sortBy = "ORDER BY p.sales DESC";
} elseif ($_GET["sortBy"] == "new") {
    $sortBy = "ORDER BY p.created_at DESC";
} elseif ($_GET["sortBy"] == "priceasc") {
    $sortBy = "ORDER BY p.price ASC";
} elseif ($_GET["sortBy"] == "pricedesc") {
    $sortBy = "ORDER BY p.price DESC";
} elseif ($_GET["sortBy"] == "nameasc") {
    $sortBy = "ORDER BY p.name ASC";
} elseif ($_GET["sortBy"] == "namedesc") {
    $sortBy = "ORDER BY p.name DESC";
} else {
    $sortBy = "ORDER BY p.sales DESC";
}

if (!isset($_GET["category"])) {
    $categoryWhere = "";
} elseif ($_GET["category"] == "other") {
    $categoryWhere = "p.category = 'Other'";
} elseif ($_GET["category"] == "paper") {
    $categoryWhere = "p.category = 'Paper'";
} elseif ($_GET["category"] == "book") {
    $categoryWhere = "p.category = 'Book'";
}

$tagsWhere = "";
$tagsJoin = "";
if (isset($_GET["tag"])) {
    $tagsJoin = "JOIN productTags AS pt ON p.product_id = pt.product_id JOIN tags AS t ON pt.tag_id = t.tag_id";
    $tagsWhere = "(";
    foreach ($_GET["tag"] as $tag) {
        $tagsWhere .= "t.tag_id = " . $tag . " OR ";
    }
    $tagsWhere = substr($tagsWhere, 0, -3);
    $tagsWhere .= ")";
}

if ($tagsWhere != "" && $categoryWhere != "") {
    $where = "WHERE " . $tagsWhere . " AND " . $categoryWhere;
} else if ($tagsWhere != "") {
    $where = "WHERE " . $tagsWhere;
} else if ($categoryWhere != "") {
    $where = "WHERE " . $categoryWhere;
} else {
    $where = "";
}

$sql = "SELECT * FROM products AS p " .
    $tagsJoin . " " . $where . " " . $sortBy .
    " LIMIT " . $productsPerPage .
    " OFFSET " . strval(($page - 1) * $productsPerPage);
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(*) AS total FROM products AS p " . $tagsJoin . " " . $where;
$result = $conn->query($sql);
$totalProducts = $result->fetch_assoc()["total"];
$totalPages = ceil($totalProducts / $productsPerPage);


$title = "Products";
include ROOT_DIR . "/website/partials/header.php";
?>

<main>
    <div class="container my-5">
        <h1 class="text-center mb-4">Products</h1>

        <div class="row mb-5 justify-content-between">
            <?php
            include ROOT_DIR . "/website/partials/tagDropdown.php";
            include ROOT_DIR . "/website/partials/filterDropdown.php";
            ?>
        </div>

        <div class="row">
            <?php
            if ($totalProducts == 0) {
                echo "<div class='mt-5 pt-5 display-5 text-center'>Nothing found :(</div>";
            }

            foreach ($products as $product) {
                $sql = "SELECT image_name FROM images WHERE placement = 1 AND product_id = " . $product["product_id"];
                $result = $conn->query($sql);
                $image = $result->fetch_assoc()["image_name"];

                if (!isset($image)) {
                    $image = "no-image.png";
                }

                $outOfStock = "";
                $gray = "";
                if ($product["stock"] == 0) {
                    $outOfStock = "<h5><span class='badge bg-secondary'>OUT OF STOCK</span></h5>";
                    $gray = "img-gray";
                }

                $discount = "";
                $lineThrough = "";
                if ($product["discount"] > 0 && $product["stock"] != 0) {
                    $discount = '<h5 class="card-text text-danger">' .
                        number_format($product["price"] * (1 - $product["discount"]), 2, ".", "") . '&euro;    
                    <span class="badge bg-danger">' . $product["discount"] * 100 . '% OFF</span></h5>';
                    $lineThrough = "text-decoration-line-through";
                }

                echo
                    '<div class="container-fluid col-md-3 col-sm-6 col-6 mb-4">
                    <div class="card card-zoom h-100 border-0">
                        <div class="card-body">
                            <img onmouseover="zoomImg(this)" src="' . HTML_ROOT_DIR . '/website/img/products/' . $image . '" 
                                class="card-img-top mb-3 rounded ' . $gray . '" alt="image">
                            <h6 class="card-title text-start">' . $product["name"] . '</h6>
                            <h5 class="card-text ' . $lineThrough . '">' . $product["price"] . '&euro;</h5>'
                    . $discount . $outOfStock .
                    '<a href="' . HTML_ROOT_DIR . '/website/productInfo.php?product_id=' . $product["product_id"] . '"class="stretched-link"></a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
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