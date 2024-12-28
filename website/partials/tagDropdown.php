<nav class="col-auto dropdown text-center mx-2 mx-lg-1 rounded d-flex">
    <a class="nav-link dropdown-toggle" href="#" id="tagDropdown" role="button" data-bs-toggle="dropdown" data-bs-display="static"
        data-bs-auto-close="outside" aria-expanded="false">
        <div>
            <i class="fa-solid fa-tags"></i>
            Select Tags
        </div>
    </a>
    <form method="get" action="">
        <ul class="dropdown-menu rounded border-1 border-secondary p-3" aria-labelledby="tagDropdown">
            <?php
            // tag selection is a form, so we put hidden inputs to keep the selected category and sort method 
            if (isset($_GET["category"])) {
                echo '<input type="hidden" name="category" value="' . $_GET["category"] . '">';
            }

            if (isset($_GET["sortBy"])) {
                echo '<input type="hidden" name="sortBy" value="' . $_GET["sortBy"] . '">';
            }

            $sql = "SELECT * FROM tags ORDER BY tag_category DESC";
            $result = $conn->query($sql);
            $tags = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($tags as $tag) {
                if (
                    (isset($_GET["category"]) && $_GET["category"] == strtolower($tag["tag_category"]))
                    || !isset($_GET["category"])
                ) {
                    $tag_id = $tag["tag_id"];
                    $tag_name = $tag["tag_name"];

                    $tagChecked = "";
                    foreach ($_GET["tag"] as $tag2) {
                        if ($tag2 == $tag_id) {
                            $tagChecked = "checked";
                        }
                    }

                    echo '<li class="form-check dropdown-item">
                    <input name="tag[' . $tag_id . ']" class="form-check-input" type="checkbox" value="' . $tag_id . '" 
                    id="tag' . $tag_id . '" ' . $tagChecked . '>
                    <label class="form-check-label" for="tag' . $tag_id . '">' . $tag_name . '</label>
                </li>';
                }
            }
            ?>
            <div class="dropdown-divider"></div>
            <button type="submit" class="btn btn-primary w-100">Apply Tags</button>
        </ul>
    </form>
</nav>