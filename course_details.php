<?php
session_start();
$page_title = "Course Details";
include __DIR__ . '/includes/header.php';

// ------------------------
// Database connection
// ------------------------
$host = 'localhost';
$db_name = 'skillpro_dp';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get course ID from query
if (!isset($_GET['course_id']) || empty($_GET['course_id'])) {
    die("Course ID is missing.");
}
$course_id = (int)$_GET['course_id'];

// Fetch course details
try {
    $stmt = $db->prepare("SELECT * FROM courses WHERE id = :id");
    $stmt->execute(['id' => $course_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        die("Course not found.");
    }
} catch (PDOException $e) {
    die("Error fetching course: " . $e->getMessage());
}
?>

<!-- Display flash message -->
<?php if (isset($_SESSION['message'])): ?>
    <div id="flash-message" class="alert alert-success alert-dismissible fade show text-center position-fixed top-0 start-50 translate-middle-x mt-3 shadow" role="alert" style="z-index: 1050; min-width: 300px;">
        <?= htmlspecialchars($_SESSION['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<section class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h1 class="fw-bold mb-3"><?= htmlspecialchars($course['title']); ?></h1>
        <p class="lead mb-0">Detailed information about this course at SkillPro Institute.</p>
    </div>
</section>

<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 p-5">
                <h3 class="text-primary mb-3"><?= htmlspecialchars($course['title']); ?></h3>
                <p class="mb-4"><?= nl2br(htmlspecialchars($course['description'])); ?></p>

                <ul class="list-unstyled text-muted mb-4">
                    <li><strong>Duration:</strong> <?= htmlspecialchars($course['duration_weeks']); ?> week(s)</li>
                    <?php if (!empty($course['mode'])): ?>
                        <li><strong>Mode:</strong> <?= htmlspecialchars($course['mode']); ?></li>
                    <?php endif; ?>
                    <?php if (!empty($course['fee'])): ?>
                        <li><strong>Fee:</strong> $<?= htmlspecialchars($course['fee']); ?></li>
                    <?php endif; ?>
                </ul>

                <div class="d-flex justify-content-between">
                    <a href="courses.php" class="btn btn-secondary shadow-sm">
                        <i class="bi bi-arrow-left me-2"></i> Back to Courses
                    </a>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="enroll.php?course_id=<?= $course['id']; ?>" class="btn btn-success shadow-sm">
                            Enroll Now <i class="bi bi-check2-circle ms-2"></i>
                        </a>
                    <?php else: ?>
                        <a href="login.php?redirect=enroll.php?course_id=<?= $course['id']; ?>" class="btn btn-success shadow-sm">
                            Login to Enroll <i class="bi bi-box-arrow-in-right ms-2"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.card {
    background: #ffffff;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
</style>

<!-- Auto-hide flash message -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const flash = document.getElementById('flash-message');
    if (flash) {
        setTimeout(() => {
            const alert = new bootstrap.Alert(flash);
            alert.close();
        }, 3000); // 3 seconds
    }
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>