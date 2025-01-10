<?php
include "../config.php";

$title = "Home Page";
include ROOT_DIR . "/website/partials/header.php";

?>

<main class="container mb-5">

    <div class="display-1 text-center my-5">Welcome!</div>

    <?php
    if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {

        echo '
    <div class="row">
        <div class="container-fluid col-lg-4 col-md-6 col-12 mb-4">
            <div class="card category-card card-zoom h-100 border-0">
                <img src="' . HTML_ROOT_DIR . '/website/img/papers.png"
                    class="card-img ratio ratio-16x9 rounded category-img" alt="image">
                <a href="' . HTML_ROOT_DIR . '/website/products.php?category=paper" class="stretched-link"></a>
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="display-2 card-title mx-auto text-white">Papers</div>
                </div>
            </div>
        </div>

        <div class="container-fluid col-lg-4 col-md-6 col-12 mb-4">
            <div class="card category-card card-zoom h-100 border-0">
                <img src="' . HTML_ROOT_DIR . '/website/img/books.png"
                    class="card-img ratio ratio-16x9 rounded category-img" alt="image">
                <a href="' . HTML_ROOT_DIR . '/website/products.php?category=book" class="stretched-link"></a>
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="display-2 card-title mx-auto text-white">Books</div>
                </div>
            </div>
        </div>

        <div class="container-fluid col-lg-4 col-md-6 col-12 mb-4">
            <div class="card category-card card-zoom h-100 border-0">
                <img src="' . HTML_ROOT_DIR . '/website/img/other.png"
                    class="card-img ratio ratio-16x9 rounded category-img" alt="image">
                <a href="' . HTML_ROOT_DIR . '/website/products.php?category=other" class="stretched-link"></a>
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="display-2 card-title mx-auto text-white">Other</div>
                </div>
            </div>
        </div>

        <div class="container-fluid col-lg-4 col-md-6 col-12 mb-4">
            <div class="card category-card card-zoom h-100 border-0">
                <img src="' . HTML_ROOT_DIR . '/website/img/all.png"
                    class="card-img ratio ratio-16x9 rounded category-img" alt="image">
                <a href="' . HTML_ROOT_DIR . '/website/products.php" class="stretched-link"></a>
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="display-3 card-title mx-auto text-white">All Items</div>
                </div>
            </div>
        </div>

        <div class="container-fluid col-lg-4 col-md-6 col-12 mb-4">
            <div class="card category-card card-zoom h-100 border-0">
                <img src="' . HTML_ROOT_DIR . '/website/img/new.png"
                    class="card-img ratio ratio-16x9 rounded category-img" alt="image">
                <a href="' . HTML_ROOT_DIR . '/website/products.php?sortby=New" class="stretched-link"></a>
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="display-4 card-title mx-auto text-white">New Arrivals</div>
                </div>
            </div>
        </div>

        <div class="container-fluid col-lg-4 col-md-6 col-12 mb-4">
            <div class="card category-card card-zoom h-100 border-0">
                <img src="' . HTML_ROOT_DIR . '/website/img/top.png"
                    class="card-img ratio ratio-16x9 rounded category-img" alt="image">
                <a href="' . HTML_ROOT_DIR . '/website/products.php" class="stretched-link"></a>
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="display-3 card-title mx-auto text-white">Best Sellers</div>
                </div>
            </div>
        </div>
    </div>';
    } elseif ($_SESSION["user"]["role"] == "admin") {

        echo '
    <div class="row">
        <div class="container-fluid col-md-6 col-sm-12 col-12 mb-4">
            <div class="card category-card card-zoom h-100 border-0">
                <img src="' . HTML_ROOT_DIR . '/website/img/users.png"
                    class="card-img ratio ratio-16x9 rounded category-img" alt="image">
                <a href="' . HTML_ROOT_DIR . '/website/admin/manageUsers.php" class="stretched-link"></a>
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="display-2 card-title mx-auto text-white">Users</div>
                </div>
            </div>
        </div>

        <div class="container-fluid col-md-6 col-sm-12 col-12 mb-4">
            <div class="card category-card card-zoom h-100 border-0">
                <img src="' . HTML_ROOT_DIR . '/website/img/products.png"
                    class="card-img ratio ratio-16x9 rounded category-img" alt="image">
                <a href="' . HTML_ROOT_DIR . '/website/admin/manageProducts.php" class="stretched-link"></a>
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="display-2 card-title mx-auto text-white">Products</div>
                </div>
            </div>
        </div>

        <div class="container-fluid col-md-6 col-sm-12 col-12 mb-4">
            <div class="card category-card card-zoom h-100 border-0">
                <img src="' . HTML_ROOT_DIR . '/website/img/orders.png"
                    class="card-img ratio ratio-16x9 rounded category-img" alt="image">
                <a href="' . HTML_ROOT_DIR . '/website/admin/manageOrders.php" class="stretched-link"></a>
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="display-2 card-title mx-auto text-white">Orders</div>
                </div>
            </div>
        </div>

        <div class="container-fluid col-md-6 col-sm-12 col-12 mb-4">
            <div class="card category-card card-zoom h-100 border-0">
                <img src="' . HTML_ROOT_DIR . '/website/img/feedback.png"
                    class="card-img ratio ratio-16x9 rounded category-img" alt="image">
                <a href="' . HTML_ROOT_DIR . '/website/admin/viewFeedback.php" class="stretched-link"></a>
                <div class="card-img-overlay d-flex align-items-center">
                    <div class="display-2 card-title mx-auto text-white">Feedback</div>
                </div>
            </div>
        </div>';
    }
    ?>
    </div>
</main>

<?php
include ROOT_DIR . "/website/partials/footer.php";
?>