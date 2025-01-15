<?php
include "../../config.php";
include ROOT_DIR . "/website/partials/kickNonAdmins.php";
$title = "Feedback";
include ROOT_DIR . "/website/partials/header.php";

$sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$feedbackList = $result->fetch_all(MYSQLI_ASSOC);
?>

<main>
    <h1 class="text-center my-3">User Feedback</h1>

    <div class="container border border-1 border-secondary rounded my-3 p-3">

        <?php
        foreach ($feedbackList as $feedback) {
            echo '<div class="mb-4">
                    <h5 class="text-wrap text-break">' . $feedback["feedback_email"] . '</h5>
                    <h6>
                        <small class="text-muted">
                            Posted at ' . date("F j Y, g:i A", strtotime($feedback["created_at"])) . '
                        </small>
                    <h6>
                    <p class="text-wrap text-break">' . nl2br($feedback["feedback_body"]) . '<p>
                </div>';
        }
        ?>
    </div>
</main>


<?php
include ROOT_DIR . "/website/partials/footer.php";
?>