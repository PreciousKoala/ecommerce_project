<!DOCTYPE html>

<html>

<head>
    <title><?php echo $title; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo HTML_ROOT_DIR ?>/website/img/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">
    <link href="<?php echo HTML_ROOT_DIR ?>/website/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo HTML_ROOT_DIR ?>/website/css/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container-fluid">
            <div class="text-light p-0 mr-4 navbar-brand">
                <img class="navbar-brand mr-2" src="<?php echo HTML_ROOT_DIR ?>/website/img/favicon.ico" alt="logo" />
                <b>KAMIFOLD</b>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars text-light"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto d-flex flex-lg-row mt-3 mt-lg-0">
                    <li class="nav-item text-center mx-1 mx-lg-1">
                        <a class="nav-link pt-2 pb-2" href="<?php echo HTML_ROOT_DIR ?>/website/index.php">
                            <div>
                                <i class="fas fa-home fa-lg"></i>
                                Home
                            </div>
                        </a>
                    </li>
                    <li class="nav-item text-center mx-2 mx-lg-1">
                        <a class="nav-link pt-2 pb-2" href="<?php echo HTML_ROOT_DIR ?>/website/products.php">
                            <div>
                                <i class="fa-solid fa-shop"></i>
                                All
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown text-center mx-2 mx-lg-1">
                        <a class="nav-link dropdown-toggle pt-2 pb-2" id="navbarDropdown1" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div>
                                <i class="fas fa-scroll fs-lg"></i>
                                Papers
                            </div>
                        </a>
                        <ul class="dropdown-menu rounded border-1 border-secondary" aria-labelledby="navbarDropdown1">
                            <li><a class="dropdown-item"
                                    href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=paper">All
                                    Papers</a>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li><a class="dropdown-item"
                                    href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=paper&sortBy=popular">
                                    Best Sellers
                                </a></li>
                            <li><a class="dropdown-item"
                                    href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=paper&sortBy=new">
                                    New Arrivals
                                </a></li>
                            <li><a class="dropdown-item"
                                    href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=paper&tag[2]=2">
                                    One Sided Papers
                                </a></li>
                            <li><a class="dropdown-item"
                                    href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=paper&tag[2]=1">
                                    Double Sided Papers
                                </a></li>
                            <li><a class="dropdown-item"
                                    href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=paper&tag[10]=10">
                                    Untreated Papers</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown text-center mx-2 mx-lg-1">
                        <a class="nav-link dropdown-toggle pt-2 pb-2" id="navbarDropdown2" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div>
                                <i class="fas fa-book fs-lg"></i>
                                Books
                            </div>
                        </a>
                        <ul class="dropdown-menu rounded border-1 border-secondary" aria-labelledby="navbarDropdown2">
                            <li><a class="dropdown-item"
                                    href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=book">All Books</a>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li><a class="dropdown-item"
                                    href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=book?sortBy=popular">Best
                                    Sellers</a></li>
                            <li><a class="dropdown-item"
                                    href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=book?sortBy=new">New
                                    Arrivals</a></li>
                            <li><a class="dropdown-item"
                                    href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=book&tag[3]=3">JOAS
                                    Books</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=book&tag[4]=4">KOA
                                    Books</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item text-center mx-2 mx-lg-1">
                        <a class="nav-link pt-2 pb-2"
                            href="<?php echo HTML_ROOT_DIR ?>/website/products.php?category=other">
                            <div>
                                <i class="fa-solid fa-scissors"></i>
                                Other
                            </div>
                        </a>
                    </li>
                    <li class="nav-item text-center mx-2 mx-lg-1">
                        <a class="nav-link pt-2 pb-2" href="<?php echo HTML_ROOT_DIR ?>/website/aboutUs.php">
                            <div>
                                <i class="fa-solid fa-circle-info"></i>
                                About Us
                            </div>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto d-flex flex-lg-row mt-3 mt-lg-0">

                    <?php
                    if (!isset($_SESSION["user"])) {
                        require ROOT_DIR . "/website/partials/loginDropdown.php";
                    } elseif ($_SESSION["user"]["role"] == "user") {
                        require ROOT_DIR . "/website/partials/userDropdown.php";
                    } elseif ($_SESSION["user"]["role"] == "admin") {
                        require ROOT_DIR . "/website/partials/adminDropdown.php";
                    }
                    ?>
                    <li class="nav-item text-center mx-2 mx-lg-1">
                        <a class="nav-link pt-2 pb-2" href="<?php echo HTML_ROOT_DIR ?>/website/cart.php">
                            <span id="cartSpan" class="me-3">
                                <i class="fas fa-cart-shopping"></i>
                                <span class="badge rounded-pill badge-notification bg-primary" id="cartItems">
                                    <?php
                                    $cartNum = 0;
                                    foreach (json_decode($_COOKIE["cart"], true) as $cartItem) {
                                        $cartNum += $cartItem["quantity"];
                                    }
                                    echo $cartNum;
                                    ?>
                                </span>
                            </span>
                            Cart
                        </a>
                    </li>
                </ul>
                <?php
                require ROOT_DIR . "/website/partials/search.php";
                ?>
            </div>
        </div>
    </nav>