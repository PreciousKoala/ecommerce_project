<?php
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/dbConn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

}

$page = 1;
$productsPerPage = 16;

if (isset($_GET["page"])) {
    $page = intval($_GET["page"]);
}

if (!isset($_GET["orderBy"])) {
    $orderBy = "ORDER BY p.sales DESC";
} elseif ($_GET["orderBy"] == "priceasc") {
    $orderBy = "ORDER BY p.price ASC";
} elseif ($_GET["orderBy"] == "pricedesc") {
    $orderBy = "ORDER BY p.price DESC";
} elseif ($_GET["orderBy"] == "nameasc") {
    $orderBy = "ORDER BY p.name ASC";
} elseif ($_GET["orderBy"] == "namedesc") {
    $orderBy = "ORDER BY p.name DESC";
} else {
    $orderBy = "ORDER BY p.sales DESC";
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
    $orderBy .
    " LIMIT " . $productsPerPage .
    " OFFSET " . strval(($page - 1) * $productsPerPage);
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);


$sql = "SELECT COUNT(*) AS total FROM products";
$result = $conn->query($sql);
$totalProducts = $result->fetch_assoc()["total"];
$totalPages = ceil($totalProducts / $productsPerPage);


$title = "Products";
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/header.php"; ?>

<main>
    <div class="container my-5">
        <h1 class="text-center mb-4">Products</h1>
        <div class="row">
            <?php foreach ($products as $product) {
                $sql = "SELECT image_name FROM images WHERE placement = 1 AND product_id = " . $product["product_id"];
                $result = $conn->query($sql);
                $image = $result->fetch_assoc()["image_name"];

                echo '<div class="container-fluid col-md-3 col-sm-6 col-6 m-auto mb-4">
                <div class="card h-100 border-0">
                    <img onmouseover="zoomImg(this)" src="/ecommerce_project/website/img/products/' . $image . '" class="card-img-top rounded data-mdb-attribute" alt="image">
                    <div class="card-body">
                        <h5 class="card-title">' . $product["name"] . '</h5>
                        <p class="card-text">' . $product["price"] . '&euro;</p>
                        <a href="/ecommerce_project/website/productInfo.php?id=' . $product["id"] . '"class="stretched-link"></a>
                    </div>
                </div>
                

            </div>';
            }
            include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/pagination.php";
            ?>
        </div>
    </div>
</main>


<?php
include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/footer.php";
?>