<form class="d-flex input-group w-auto ms-lg-3 my-3 my-lg-0"
    action="<?php echo HTML_ROOT_DIR; ?>/website/products.php?test=test" method="get">
    <?php
    // UNCOMMENT TO KEEP CATEGORIES, SORTING AND TAGS ON SEARCH
    // if (isset($_GET["category"])) {
    //     echo '<input type="hidden" name="category" value="' . $_GET["category"] . '">';
    // }

    // if (isset($_GET["sortBy"])) {
    //     echo '<input type="hidden" name="sortBy" value="' . $_GET["sortBy"] . '">';
    // }

    // foreach ($_GET["tag"] as $tag) {
    //     echo '<input type="hidden" name=tag[' . $tag . '] value="' . $tag . '">';
    // }
    ?>
    <input name="search" type="search" class="form-control" placeholder="Search" aria-label="Search" />
    <button class="btn btn-primary" id="searchButton" type="submit">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
</form>