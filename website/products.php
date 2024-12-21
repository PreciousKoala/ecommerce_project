<?php
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/dbConn.php";

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
    $category = "";
} elseif ($_GET["category"] == "other") {
    $category = "p.category = 'Other'";
} elseif ($_GET["category"] == "paper") {
    $category = "p.category = 'Paper'";
} elseif ($_GET["category"] == "book") {
    $category = "p.category = 'Book'";
}



$sql = "SELECT * FROM products AS p " .
    $sortBy .
    " LIMIT " . $productsPerPage .
    " OFFSET " . strval(($page - 1) * $productsPerPage);
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);


$sql = "SELECT COUNT(*) AS total FROM products";
$result = $conn->query($sql);
$totalProducts = $result->fetch_assoc()["total"];
$totalPages = ceil($totalProducts / $productsPerPage);


$title = "Products";
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/header.php";
?>

<main>
    <div class="container my-5">
        <h1 class="text-center mb-4">Products</h1>
        
        <?php
        include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/filterDropdown.php";;
        ?>

        <div class="row">
            <?php foreach ($products as $product) {
                $sql = "SELECT image_name FROM images WHERE placement = 1 AND product_id = " . $product["product_id"];
                $result = $conn->query($sql);
                $image = $result->fetch_assoc()["image_name"];

                $outOfStock = "";
                $gray = "";
                if ($product["stock"] == 0) {
                    $outOfStock = "<p class='text-danger'>OUT OF STOCK</p>";
                    $gray = "img-gray";
                }

                echo
                '<div class="container-fluid col-md-3 col-sm-6 col-6 mb-4">
                    <div class="card card-zoom h-100 border-0">
                        <div class="card-body">
                            <img onmouseover="zoomImg(this)" src="/ecommerce_project/website/img/products/' . $image . '" 
                                class="card-img-top mb-3 rounded ' . $gray . '" alt="image">
                            <h6 class="card-title text-start">' . $product["name"] . '</h6>
                            <h5 class="card-text">' . $product["price"] . '&euro;</h5>'
                            . $outOfStock .
                            '<a href="/ecommerce_project/website/productInfo.php?id=' . $product["id"] . '"class="stretched-link"></a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
    <?php
    include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/pagination.php";
    ?>
</main>


<?php
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/footer.php";
?>