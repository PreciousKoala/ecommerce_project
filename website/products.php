<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

}

$page = 1;
$productsPerPage = 16;

if (isset($_GET["page"]) && intval($_GET["page"]) > 0) {
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

$where = [];
$paramTypes = "";
$params = [];

if (!isset($_GET["category"])) {
    $categoryWhere = "";
} elseif ($_GET["category"] == "other") {
    $categoryWhere = "p.category = 'Other'";
    $where[] = $categoryWhere;
} elseif ($_GET["category"] == "paper") {
    $categoryWhere = "p.category = 'Paper'";
    $where[] = $categoryWhere;
} elseif ($_GET["category"] == "book") {
    $categoryWhere = "p.category = 'Book'";
    $where[] = $categoryWhere;
}

$tagsWhere = "";
$tagsJoin = "";
if (isset($_GET["tag"])) {
    $tagsJoin = "JOIN productTags AS pt ON p.product_id = pt.product_id JOIN tags AS t ON pt.tag_id = t.tag_id";
    $tagsWhere = "(";
    foreach ($_GET["tag"] as $tag) {
        $tagsWhere .= "t.tag_id = ? OR ";
        $params[] = intval($tag);
        $paramTypes .= "i";
    }
    $tagsWhere = substr($tagsWhere, 0, -3);
    $tagsWhere .= ")";

    $where[] = $tagsWhere;
}

$searchWhere = "";
if (isset($_GET["search"])) {
    $searchWhere = "(p.name LIKE ? OR p.description LIKE ?)";
    $params[] = "%" . $_GET["search"] . "%";
    $params[] = "%" . $_GET["search"] . "%";
    $paramTypes .= "ss";

    $where[] = $searchWhere;
}

if (empty($where)){
    $where = "";
} else {
    $where = "WHERE " . implode(" AND ", $where);
}

$params[] = $productsPerPage;
$params[] = ($page - 1) * $productsPerPage;
$paramTypes .= "ii";

$sql = "SELECT * FROM products AS p " .
    $tagsJoin . " " . $where . " " . $sortBy .
    " LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param($paramTypes, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);

$params = array_slice($params, 0, -2);
$sql = "SELECT COUNT(*) AS total FROM products AS p " . $tagsJoin . " " . $where;

if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(substr($paramTypes, 0, -2), ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$totalProducts = $result->fetch_assoc()["total"];
$totalPages = ceil($totalProducts / $productsPerPage);

$title = "Products";
include ROOT_DIR . "/website/partials/header.php";
?>

<main>
    <div class="container my-5">
        

        <?php
        if (isset($_GET["search"]) && $_GET["search"] != ""){
            echo '<h2 class="text-center mb-4">Results for &quot;'.$_GET["search"].'&quot;:</h2>';
        } else {
            echo '<h1 class="text-center mb-4">Products</h1>';
        }
        ?>

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
                $sql = "SELECT image_name FROM images WHERE placement = 1 AND product_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $product["product_id"]);
                $stmt->execute();
                $result = $stmt->get_result();
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
                            <img src="' . HTML_ROOT_DIR . '/website/img/products/' . $image . '" 
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