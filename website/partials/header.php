<!DOCTYPE html>

<html>

<head>
    <title><?php echo $title; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">
    <link href="/ecommerce_project/website/css/bootstrap.min.css" rel="stylesheet">
    <link href="/ecommerce_project/website/css/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-black">
        <div class="container-fluid">
            <img class="navbar-brand mr-2" src="img/shopLogo.svg" alt="logo" />
            <div class="text-light p-0 mr-4 navbar-brand"><b>KAMIFOLD</b></div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars text-light"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto d-flex flex-row mt-3 mt-lg-0">
                    <li class="nav-item text-center mx-1 mx-lg-1">
                        <a class="nav-link pt-2 pb-2" href="#!">
                            <div>
                                <i class="fas fa-home fa-lg"></i>
                                Home
                            </div>
                        </a>
                    </li>
                    <li class="nav-item text-center mx-2 mx-lg-1">
                        <a class="nav-link pt-2 pb-2" href="#!">
                            <div>
                                <i class="fa-solid fa-shop"></i>
                                All
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown text-center mx-2 mx-lg-1">
                        <a class="nav-link dropdown-toggle pt-2 pb-2" href="#" id="navbarDropdown1" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div>
                                <i class="fas fa-scroll fs-lg"></i>
                                Papers
                            </div>
                        </a>
                        <ul class="dropdown-menu rounded border-1 border-black" aria-labelledby="navbarDropdown1">
                            <li><a class="dropdown-item" href="#">All Papers</a></li>
                            <div class="dropdown-divider"></div>
                            <li><a class="dropdown-item" href="#">Best Sellers</a></li>
                            <li><a class="dropdown-item" href="#">New Arrivals</a></li>
                            <li><a class="dropdown-item" href="#">One-Sided Papers</a></li>
                            <li><a class="dropdown-item" href="#">Double-Sided Papers</a></li>
                            <li><a class="dropdown-item" href="#">Untreated Papers</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown text-center mx-2 mx-lg-1">
                        <a class="nav-link dropdown-toggle pt-2 pb-2" href="#" id="navbarDropdown2" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div>
                                <i class="fas fa-book fs-lg"></i>
                                Books
                            </div>
                        </a>
                        <ul class="dropdown-menu rounded border-1 border-black" aria-labelledby="navbarDropdown2">
                            <li><a class="dropdown-item" href="#">All Books</a></li>
                            <div class="dropdown-divider"></div>
                            <li><a class="dropdown-item" href="#">Best Sellers</a></li>
                            <li><a class="dropdown-item" href="#">New Arrivals</a></li>
                            <li><a class="dropdown-item" href="#">JOAS Books</a></li>
                            <li><a class="dropdown-item" href="#">KOA Books</a></li>
                        </ul>
                    </li>
                    <li class="nav-item text-center mx-2 mx-lg-1">
                        <a class="nav-link pt-2 pb-2" href="#!">
                            <div>
                                <i class="fa-solid fa-scissors"></i>
                                Other
                            </div>
                        </a>
                    </li>
                    <li class="nav-item text-center mx-2 mx-lg-1">
                        <a class="nav-link pt-2 pb-2" href="#!">
                            <div>
                                <i class="fa-solid fa-circle-info"></i>
                                About Us
                            </div>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto d-flex flex-row mt-3 mt-lg-0">

                    <?php include $_SERVER["DOCUMENT_ROOT"] . "/ecommerce_project/website/partials/login.php" ?>
                    <li class="nav-item text-center mx-2 mx-lg-1">
                        <a class="nav-link pt-2 pb-2" href="#!">
                            <div>
                                <i class="fas fa-cart-shopping"></i>
                                Cart
                                <span class="badge rounded-pill badge-notification bg-primary" id="cartItems">0</span>
                                
                            </div>
                        </a>
                    </li>
                </ul>
                <form class="d-flex input-group w-auto ms-lg-3 my-3 my-lg-0">
                    <input type="search" class="form-control" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-primary" id="searchButton" type="button">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>