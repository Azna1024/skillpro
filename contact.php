<?php
$page_title = "Contact Us";
include 'includes/header.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Capture session messages
$success_msg = $_SESSION['success'] ?? '';
$error_msg = $_SESSION['error'] ?? '';

// Clear messages so they don't persist
unset($_SESSION['success'], $_SESSION['error']);
?>

<!-- Hero Section -->
<section class="bg-primary text-white text-center py-5">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">Contact SkillPro Institute</h1>
        <p class="lead mb-0">We would love to hear from you! Reach out for inquiries or assistance.</p>
    </div>
</section>

<!-- Contact Section -->
<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-lg border-0 rounded-4 p-5 text-center">
                <h2 class="fw-bold text-primary mb-4">Get in Touch with SkillPro Institute</h2>
                <p class="text-muted mb-4">
                    Have questions, ideas, or feedback? We'd love to hear from you.
                </p>

                <!-- Display success/error messages -->
                <?php if ($success_msg): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success_msg) ?></div>
                <?php endif; ?>
                <?php if ($error_msg): ?>
                    <div class="alert alert-danger"><?= $error_msg ?></div>
                <?php endif; ?>

                <!-- Contact Form -->
                <h5 class="fw-semibold mb-3">Send Us a Message</h5>
                <form method="POST" action="contact_submit.php" class="text-start">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your Name</label>
                        <input type="text" name="name" class="form-control shadow-sm rounded-3" placeholder="Enter your name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control shadow-sm rounded-3" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Message</label>
                        <textarea name="message" class="form-control shadow-sm rounded-3" rows="5" placeholder="Write your message here..." required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                            <i class="bi bi-send-fill me-2"></i> Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
/* Extra polish */
.card {
    background: #ffffff;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
</style>

<!-- Call-to-Action Footer Section -->
<section class="bg-light py-5 text-center">
    <div class="container">
        <h4 class="fw-bold mb-3">Have Questions?</h4>
        <p class="mb-3">Reach out today and our team will get back to you as soon as possible.</p>
        <a href="contact.php" class="btn btn-outline-primary btn-lg shadow-sm">Contact Us Now</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
