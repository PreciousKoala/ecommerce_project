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
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

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

<main class="m-3">
    <h1 class="text-center mb-3">Manage products</h1>
    <div class="mx-auto d-flex justify-content-center align-items-center mb-3">
        <button id="createButton" class="btn btn-primary p-2" type="button">
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
                             data-bs-toggle="modal" data-bs-target="#editModal" onclick="showproductId(this)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                        <td>
                            <button id="deleteButtonModal' . $product["product_id"] . '" class="btn btn-danger" type="button"
                             data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="showproductId(this)">
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
                            <div id="tagDropdown' . $product["product_id"] . '" class="accordion-body collapse">';
                    echo '
                                test
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