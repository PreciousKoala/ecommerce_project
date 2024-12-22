<nav>
    <ul class="pagination justify-content-center">
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

        $sortByGet = "";
        if (isset($_GET["sortBy"])) {
            $sortByGet = "&sortBy=". $_GET["sortBy"];
        }

        $getParams = $categoryGet . $tagGet . $sortByGet;

        if ($page >= 1) {
            $active = "";
            if ($page == 1) {
                $active = "active";
            }
            echo '<li class="page-item">
                    <a class="page-link ' . $active . '" href="?page=1' . $getParams . '">1</a>
                </li>';
        }
        if ($page > 3) {
            echo '<li class="page-item">
                    <a class="page-link disabled">...</a>
                </li>';
        }
        for ($i = max(2, $page - 1); $i <= min($totalPages - 1, $page + 1); $i++) {
            $active = "";
            if ($page == $i) {
                $active = "active";
            }
            echo '<li class="page-item ' . $active . '">
                    <a class="page-link" href="?page=' . $i . $getParams . '">' . $i . '</a>
                </li>';
        }
        if ($page < $totalPages - 2) {
            echo '<li class="page-item">
                    <a class="page-link  disabled">...</a>
                </li>';
        }
        if ($page <= $totalPages && $totalPages != 1) {
            $active = "";
            if ($page == $totalPages) {
                $active = "active";
            }
            echo '<li class="page-item">
                    <a class="page-link ' . $active . '" href="?page=' . $totalPages . $getParams . '">' . $totalPages . '</a>
                </li>';
        }
        ?>
    </ul>
</nav>