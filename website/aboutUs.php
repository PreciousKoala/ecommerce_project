<?php
require "../config.php";

$title = "About Us";
require ROOT_DIR . "/website/partials/header.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedbackEmail = $_POST["feedbackEmail"];
    $feedbackBody = htmlspecialchars(trim($_POST["feedbackBody"]));
    $sql = "INSERT INTO feedback (feedback_email, feedback_body) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $feedbackEmail, $feedbackBody);
    $stmt->execute();
}
?>

<main>
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="my-4 text-center">About Us</h1>
                <p class="lead">
                    Kamifold specializes in providing high-quality origami paper and books for enthusiasts of all skill
                    levels. Our carefully curated selection includes a wide variety of colors, patterns, and textures,
                    designed to meet the diverse needs of origami artists. By combining premium materials with expert
                    resources, Kamifold aims to inspire creativity and elevate the art of paper folding.
                </p>
            </div>
        </div>
    </div>

    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h3 class="mb-4 text-center">Contact Details</h3>
                <div class="mt-4">
                    <p>
                        <i class="fa-solid fa-envelope"></i> <strong>Email:</strong>
                        <a target="_blank" href="mailto:unipikamifold@gmail.com" class="text-decoration-none">
                            unipikamifold@gmail.com
                        </a>
                    </p>
                    <p>
                        <i class="fa-solid fa-phone"></i> <strong>Phone:</strong>
                        <a target="_blank" href="tel:2104142000" class="text-decoration-none">
                            +30 210 4142000
                        </a>
                    </p>
                    <p><i class="fa-solid fa-location-dot"></i> <strong>Address:</strong>
                        <a target="_blank" href="https://maps.app.goo.gl/cHW9XZy6fsTDd9ND9"
                            class="text-decoration-none">
                            80 M. Karaoli & A. Dimitriou, 18534 Piraeus
                        </a>
                    </p>
                    <div class="ratio ratio-16x9">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6293.043564733716!2d23.652979!3d37.941601!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1bbe5bb8515a1%3A0x3e0dce8e58812705!2sUniversity%20of%20Piraeus!5e0!3m2!1sen!2sus!4v1717754349849!5m2!1sen!2sus"
                            style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" class="rounded">
                        </iframe>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-lg-6">
                    <form id="reviewForm" class="border border-1 border-secondary rounded my-3 p-3" method="post">
                        <h3 class="mb-4 text-center">Send Us Feedback</h3>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="feedbackEmail" name="feedbackEmail" required
                                value="<?php echo $_SESSION["user"]["email"]; ?>">
                            <label for="feedbackEmail" class="form-label">Email</label>
                        </div>
                        <div class="form-floating">
                            <textarea rows="7" class="form-control h-100" name="feedbackBody" id="feedbackBody"
                                required></textarea>
                            <label for="feedbackBody" class="form-label">Body</label>
                        </div>
                        <div class="text-muted mb-3">All Fields Required</div>
                        <button type="submit" class="btn btn-primary p-2">Send Feedback</button>
                    </form>
                </div>
            </div>
        </div>
</main>

<?php
require ROOT_DIR . "/website/partials/footer.php";
?>