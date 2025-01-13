<form id="searchForm" class="d-flex input-group w-auto ms-lg-3 my-3 my-lg-0"
    action="<?php echo HTML_ROOT_DIR; ?>/website/products.php" method="get" enctype="multipart/form-data">
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


    <input id="search" name="search" type="search" class="form-control border-end-0" placeholder="Search"
        aria-label="Search" />

    <input id="photo" name="photo" type="file" form="photoForm" accept="image/*" class="d-none"
        onchange="photoSearch()" />
    <button class="btn btn-light bg-white border-start-0 border-end-0" type="button">
        <label for="photo">
            <i class="fa-solid fa-camera"></i>
        </label>
    </button>

    <button type="button" class="btn btn-light bg-white border-start-0" id="voiceInputButton"
        onclick="voiceSearch('<?php echo DEEPGRAM_API_KEY; ?>')">
        <i class="fa-solid fa-microphone"></i>
    </button>

    <button class="btn btn-primary" id="searchButton" type="submit">
        <i class="fa-solid fa-magnifying-glass"></i>
    </button>
</form>
<form id="photoForm" class="d-none" method="post" enctype="multipart/form-data"></form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["photo"])) {
    $filePath = ROOT_DIR . "/website/img/products/";

    $inputImage = $_FILES["photo"]["tmp_name"];
    $md5Input = md5(file_get_contents($inputImage));

    $sql = "SELECT * FROM images";
    $result = $conn->query($sql);
    $searchImages = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($searchImages as $searchImage) {
        $md5Image = md5(file_get_contents($filePath . $searchImage["image_name"]));
        if ($md5Input == $md5Image) {
            header("Location: " . HTML_ROOT_DIR . "/website/productInfo.php?product_id=" . $searchImage["product_id"]);
            exit();
        }
    }
}
?>