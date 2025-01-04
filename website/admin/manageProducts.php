<?php
include "../../config.php";
include ROOT_DIR . "/website/partials/kickNonAdmins.php";
$title = "Manage Products";
include ROOT_DIR . "/website/partials/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deleteImage"])) {
        $image_id = intval($_POST["deleteImage"]);

        $sql = "SELECT placement, product_id FROM images WHERE image_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $image_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $image = $result->fetch_assoc();
        $placement = $image["placement"];
        $product_id = $image["product_id"];

        $sql = "DELETE FROM images WHERE image_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $image_id);
        $stmt->execute();

        $sql = "UPDATE images SET placement = placement - 1 WHERE product_id = ? AND placement > ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $product_id, $placement);
        $stmt->execute();
    }

    if (isset($_POST["addImage"])) {
        $product_id = intval($_POST["addImage"]);

        $sql = "SELECT MAX(placement) AS maxPlacement FROM images WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $maxPlacement = $result->fetch_assoc()["maxPlacement"] + 1;
        echo $maxPlacement;

        $sql = "SELECT MAX(image_id) AS maxImageId FROM images";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $maxImageId = $result->fetch_assoc()["maxImageId"] + 1;

        foreach ($_FILES["images"]["name"] as $key => $value) {
            $fileName = "image-" . $maxImageId;
            $fullFileName = $fileName . "." . pathinfo($_FILES["images"]["name"][$key])["extension"];
            $fullPath = ROOT_DIR . "/website/img/products/" . $fullFileName;
            move_uploaded_file($_FILES["images"]["tmp_name"][$key], $fullPath);

            $sql = "INSERT INTO images (image_id, product_id, image_name, placement) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisi", $maxImageId, $product_id, $fullFileName, $maxPlacement);
            $stmt->execute();

            $maxPlacement++;
            $maxImageId++;
        }

    }

    if (isset($_POST["deleteTag"])) {
        $tag_id = intval($_POST["deleteTag"]);
        $product_id = intval($_POST["deleteTagProductId"]);

        $sql = "DELETE FROM productTags WHERE product_id = ? AND tag_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $product_id, $tag_id);
        $stmt->execute();
    }

    if (isset($_POST["addTag"])) {
        $product_id = intval($_POST["addTag"]);
        $tags = $_POST["tags"];

        foreach ($tags as $tag) {
            $tag_id = intval($tag);

            $sql = "INSERT INTO productTags (tag_id, product_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $tag_id, $product_id);
            $stmt->execute();
        }

    }

    if (isset($_POST["deleteButton"])) {
        $delete_id = intval($_POST["delete_product_id"]);

        $sql = "DELETE FROM products WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
    }

    if (isset($_POST["editButton"])) {
        $edit_id = intval($_POST["edit_product_id"]);

        $name = htmlspecialchars(trim($_POST["editName"]));
        $description = htmlspecialchars(trim($_POST["editDescription"]));
        $price = floatval($_POST["editPrice"]);
        $stock = intval($_POST["editStock"]);
        $discount = floatval($_POST["editDiscount"]) / 100;
        $category = $_POST["editCategory"];

        $sql = "UPDATE products 
                SET name = ?, description = ?, price = ?, stock = ?, discount = ?, category = ?
                WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdidsi", $name, $description, $price, $stock, $discount, $category, $edit_id);
        $stmt->execute();
    }

    if (isset($_POST["createButton"])) {
        $name = htmlspecialchars(trim($_POST["createName"]));
        $description = htmlspecialchars(trim($_POST["createDescription"]));
        $price = floatval($_POST["createPrice"]);
        $stock = intval($_POST["createStock"]);
        $discount = floatval($_POST["createDiscount"]) / 100;
        $category = $_POST["createCategory"];

        $sql = "INSERT INTO products (name, description, price, stock, discount, category) VALUES (?, ?, ?, ?, ?, ?) ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdids", $name, $description, $price, $stock, $discount, $category);
        $stmt->execute();
    }
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(*) AS totalProducts FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$totalProducts = $result->fetch_assoc()["totalProducts"];
?>

<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createProductForm" action="" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" value="" class="form-control" id="createName" name="createName" required>
                        <label for="createName" class="form-label">Name</label>
                    </div>
                    <div class="input-group form-floating mb-3">
                        <input type="text" value="" class="form-control" id="createPrice" name="createPrice" required
                            min="0" pattern="[0-9]*[.,]?[0-9]*" inputmode="decimal"
                            aria-describedby="createPriceSymbol">
                        <span class="input-group-text" id="createPriceSymbol">&euro;</span>
                        <label for="createPrice" class="form-label">Price</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="" class="form-control" id="createStock" name="createStock" required
                            min="0" pattern="[0-9]*" inputmode="numeric">
                        <label for="createStock" class="form-label">Stock</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea rows="7" value="" class="form-control h-100" id="createDescription"
                            name="createDescription"></textarea>
                        <label for="createDescription" class="form-label">Description*</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="createCategory" id="createCategory" class="form-select">
                            <option value="paper">Paper</option>
                            <option value="book">Book</option>
                            <option value="other">Other</option>
                        </select>
                        <label for="createCategory">Category</label>
                    </div>
                    <div class="input-group form-floating mb-3">
                        <input type="text" value="" class="form-control" id="createDiscount" name="createDiscount"
                            required min="0" max="100" pattern="[0-9]{1,2}" inputmode="numeric"
                            aria-describedby="createPercentOff">
                        <span class="input-group-text" id="createPercentOff">% OFF</span>
                        <label for="createDiscount">Discount</label>
                    </div>
                    <div class="form-text">*Can be empty</div>
                </form>
            </div>
            <form method="POST" class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button name="createButton" type="submit" class="btn btn-primary" form="createProductForm">Create
                    Product</button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Product Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="productInfoList" class="list-group list-group-flush">
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">Name:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">Description:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">Price:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">Discount:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">Stock:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">Sales:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                    <div class="list-group-item">
                        <h6 class="list-group-item-heading">Category:</h6>
                        <p class="list-group-item-text text-wrap text-break mb-1"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Product #<span id="editModalProductId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" action="" method="POST">
                    <input name="edit_product_id" id="editProductId" type="hidden" value="">
                    <div class="form-floating mb-3">
                        <input type="text" value="" class="form-control" id="editName" name="editName" required>
                        <label for="editName" class="form-label">Name</label>
                    </div>
                    <div class="input-group form-floating mb-3">
                        <input type="text" value="" class="form-control" id="editPrice" name="editPrice" required
                            min="0" pattern="[0-9]*[.,]?[0-9]*" inputmode="decimal" aria-describedby="editPriceSymbol">
                        <span class="input-group-text" id="editPriceSymbol">&euro;</span>
                        <label for="editPrice" class="form-label">Price</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="" class="form-control" id="editStock" name="editStock" required
                            min="0" pattern="[0-9]*" inputmode="numeric">
                        <label for="editStock" class="form-label">Stock</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea rows="7" value="" class="form-control h-100" id="editDescription"
                            name="editDescription"></textarea>
                        <label for="editDescription" class="form-label">Description*</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="editCategory" id="editCategory" class="form-select">
                            <option value="paper">Paper</option>
                            <option value="book">Book</option>
                            <option value="other">Other</option>
                        </select>
                        <label for="editCategory">Category</label>
                    </div>
                    <div class="input-group form-floating mb-3">
                        <input type="text" value="" class="form-control" id="editDiscount" name="editDiscount" required
                            min="0" max="100" pattern="[0-9]{1,2}" inputmode="numeric" aria-describedby="editPercentOff">
                        <span class="input-group-text" id="editPercentOff">% OFF</span>
                        <label for="editDiscount">Discount</label>
                    </div>
                    <div class="form-text">*Can be empty</div>
                </form>
            </div>
            <form method="POST" class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button name="editButton" type="submit" class="btn btn-primary" form="editProductForm">Save
                    Changes</button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete product #<span id="deleteModalProductId"></span>?
            </div>
            <form method="post" class="modal-footer">
                <input id="deleteProductId" type="hidden" name="delete_product_id">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button name="deleteButton" type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

<main class="m-3">
    <h1 class="text-center mb-3">Manage products</h1>

    <div class="text-center my-2">Total Products: <?php echo $totalProducts; ?></div>

    <div class="mx-auto d-flex justify-content-center align-items-center mb-3">
        <button id="createButton" class="btn btn-primary p-2" type="button" data-bs-toggle="modal"
            data-bs-target="#createModal">
            <i class="fa-solid fa-plus"></i><span class="ms-2">Create New Product</span>
        </button>
    </div>
    
    <div class="table-responsive table-scrollable mx-auto">
        <table class="table table-hover table-fit mx-auto">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Creation Date</th>
                    <th scope="col">Info</th>
                    <th scope="col">Images</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($products as $product) {
                    $sql = "SELECT * FROM images WHERE product_id = ? ORDER BY placement ASC";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $product["product_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $images = $result->fetch_all(MYSQLI_ASSOC);

                    $sql = "SELECT * FROM tags AS t 
                            JOIN productTags AS pt ON pt.tag_id = t.tag_id 
                            WHERE pt.product_id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $product["product_id"]);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $tags = $result->fetch_all(MYSQLI_ASSOC);

                    $sql = "SELECT * FROM tags";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $allTags = $result->fetch_all(MYSQLI_ASSOC);

                    echo '<tr>
                        <th scope="row">' . $product["product_id"] . '</th>
                        <td>' . $product["name"] . '</td>
                        <td class="text-wrap text-break">' . $product["created_at"] . '</td>
                        <td>
                            <button id="infoButtonModal' . $product["product_id"] . '" class="btn btn-secondary" type="button"
                             data-bs-toggle="modal" data-bs-target="#infoModal" onclick="showProductInfo(this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-secondary accordion-toggle" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#imageDropdown' . $product["product_id"] . '">
                                <i class="fa-solid fa-images"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-secondary accordion-toggle" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#tagDropdown' . $product["product_id"] . '">
                                <i class="fa-solid fa-tags"></i>
                            </button>
                        </td>
                        <td>
                            <button id="editButtonModal' . $product["product_id"] . '" class="btn btn-secondary" type="button"
                             data-bs-toggle="modal" data-bs-target="#editModal" onclick="showProductDetails(this)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                        <td>
                            <button id="deleteButtonModal' . $product["product_id"] . '" class="btn btn-danger" type="button"
                             data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="showProductId(this)">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                        <td class="d-none">
                            <div>
                                ' . $product["description"] . '
                            </div>
                            <div>
                                ' . $product["price"] . '
                            </div>
                            <div>
                                ' . $product["discount"] . '
                            </div>
                            <div>
                                ' . $product["stock"] . '
                            </div>
                            <div>
                                ' . $product["sales"] . '
                            </div>
                            <div>
                                ' . $product["category"] . '
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" class="p-0">
                            <div id="imageDropdown' . $product["product_id"] . '" class="accordion-body collapse">
                                <form method="post" class="px-4 pt-4" enctype="multipart/form-data">
                                    <input class="form-control w-35" type="file" id="formFileMultiple" 
                                    name="images[]" multiple required accept=".png, .jpeg, .jpg">
                                    <div class="text-muted my-2">Ratio should be close to 1:1.</div>
                                    <button id="addImageButton" name="addImage" value="' . $product["product_id"] . '" 
                                    class="btn btn-primary p-2" type="submit">
                                        <i class="fa-solid fa-plus"></i><span class="ms-2">Add New Images</span>
                                    </button>
                                </form>
                                <div class="d-flex flex-wrap overflow-auto px-0 pb-4">';

                    foreach ($images as $image) {
                        echo '      
                                    <div class="d-flex flex-column m-4">
                                        <img src="' . HTML_ROOT_DIR . '/website/img/products/' . $image["image_name"] . '" 
                                        style="width: 10em; height: 10em;" class="ratio ratio-1x1 rounded mb-1" alt="image">
                                        <form method="post">
                                            <button id="deleteImageButton' . $image["image_id"] . '" class="btn btn-danger p-2" 
                                            style="width: 10em;" type="submit" name="deleteImage" value="' . $image["image_id"] . '">
                                                <i class="fa-solid fa-trash-can"></i><span class="ms-2">Delete Image</span>
                                            </button>
                                        </form>
                                    </div>';
                    }
                    echo '
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8" class="p-0">
                            <div id="tagDropdown' . $product["product_id"] . '" class="accordion-body collapse">
                                <nav class="col-auto dropdown text-center m-2 rounded d-flex">
                                    <a class="nav-link dropdown-toggle" href="#" id="tagDropdown" role="button" data-bs-toggle="dropdown" data-bs-display="static"
                                        data-bs-auto-close="outside" aria-expanded="false">
                                        <div>
                                            <i class="fa-solid fa-tags"></i>
                                            Select Tags
                                        </div>
                                    </a>
                                    <form method="post">
                                        <ul class="dropdown-menu rounded border-1 border-secondary py-2" aria-labelledby="tagDropdown">';

                    $tag_ids = array();
                    foreach ($tags as $tag) {
                        $tag_ids[] = $tag["tag_id"];
                    }

                    foreach ($allTags as $tag) {
                        if (!in_array($tag["tag_id"], $tag_ids)) {
                            echo '
                                            <li class="form-check dropdown-item px-5">
                                                <input name="tags[]" class="form-check-input" type="checkbox" value="' . $tag["tag_id"] . '" 
                                                id="tag' . $tag["tag_id"] . '">
                                                <label class="form-check-label" for="tags' . $tag["tag_id "] . '">' . $tag["tag_name"] . '</label>
                                            </li>';
                        }
                    }
                    echo '
                                            <div class="dropdown-divider"></div>
                                            <button id="addTagButton" name="addTag" value="' . $product["product_id"] . '" 
                                            class="btn btn-primary p-2 m-2" type="submit">
                                                <i class="fa-solid fa-plus"></i><span class="ms-2">Add New Tags</span>
                                            </button>
                                        </ul>
                                    </form>
                                </nav>
                                <div class="list-group list-group-flush">';

                    foreach ($tags as $tag) {
                        echo '
                                    <div class="list-group-item">
                                        
                                        <form method="post">
                                            ' . $tag["tag_name"] . '
                                            <input type="hidden" name="deleteTagProductId" value="' . $product["product_id"] . '">
                                            <button id="deleteTagButton' . $tag["tag_id"] . '" class="btn" 
                                            type="submit" name="deleteTag" value="' . $tag["tag_id"] . '">
                                                <i class="fa-solid fa-trash-can text-danger"></i>
                                            </button>
                                        </form>
                                    </div>';
                    }
                    echo '
                                </div>
                            </div>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php
include ROOT_DIR . "/website/partials/footer.php";
?>