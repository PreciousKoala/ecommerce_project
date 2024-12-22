<nav class="col dropdown text-center mx-2 mb-4 mx-lg-1 rounded d-flex flex-row-reverse">
    <a class="nav-link dropdown-toggle" href="#" id="filterDropdown" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        <div>
            <i class="fa-solid fa-filter"></i>
            Sort By
        </div>
    </a>
    <?php
    $categoryGet = "";
    if (isset($_GET["category"])) {
        $categoryGet = "&category=" . $_GET["category"];
    }

    $tagGet = "";
    if (isset($_GET["tag"])) {
        foreach ($_GET["tag"] as $tag) {
            $tagGet .= "&tag[" . $tag . "]=" . $tag;
        }
    }

    $getParams = $categoryGet . $tagGet . $sortByGet;
    ?>
    <ul class="dropdown-menu rounded border-1 border-secondary" aria-labelledby="filterDropdown">
        <li><a class="dropdown-item" href="?sortBy=popular<?php echo $getParams; ?>">
                <i class="fa-solid fa-fire"></i>
                Best Selling
            </a></li>
        <li><a class="dropdown-item" href="?sortBy=new<?php echo $getParams; ?>">
                <i class="fa-solid fa-certificate"></i>
                Newest
            </a></li>
        <li><a class="dropdown-item" href="?sortBy=nameasc<?php echo $getParams; ?>">
                <i class="fa-solid fa-arrow-down-a-z"></i>
                Alphabetically, A-Z
            </a></li>
        <li><a class="dropdown-item" href="?sortBy=namedesc<?php echo $getParams; ?>">
                <i class="fa-solid fa-arrow-down-z-a"></i>
                Alphabetically, Z-A
            </a></li>
        <li><a class="dropdown-item" href="?sortBy=priceasc<?php echo $getParams; ?>">
                <i class="fa-solid fa-euro-sign"></i>
                <i class="fa-solid fa-arrow-down-short-wide"></i>
                Price, Low to High
            </a></li>
        <li><a class="dropdown-item" href="?sortBy=pricedesc<?php echo $getParams; ?>">
                <i class="fa-solid fa-euro-sign"></i>
                <i class="fa-solid fa-arrow-down-wide-short"></i>
                Price, High to Low
            </a></li>
    </ul>
</nav>