<?php
$page_title = "Courses";
include __DIR__ . '/includes/header.php';


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


try {
    $stmt = $db->query("SELECT * FROM courses ORDER BY title ASC");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching courses: " . $e->getMessage());
}
?>

<section class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Our Courses</h1>
        <p class="lead mb-0">Explore all courses offered at SkillPro Institute and learn more!</p>
    </div>
</section>

<section class="container my-5">
    <?php if (!empty($courses)): ?>
        <div class="row g-4">
            <?php foreach ($courses as $course): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary"><?= htmlspecialchars($course['title']); ?></h5>
                            <p class="card-text mb-2"><?= nl2br(htmlspecialchars($course['description'])); ?></p>

                            <ul class="list-unstyled text-muted mb-3">
                                <li><strong>Duration:</strong> <?= htmlspecialchars($course['duration_weeks']); ?> week(s)</li>
                                <?php if (!empty($course['mode'])): ?>
                                    <li><strong>Mode:</strong> <?= htmlspecialchars($course['mode']); ?></li>
                                <?php endif; ?>
                                <?php if (!empty($course['fee'])): ?>
                                    <li><strong>Fee:</strong> $<?= htmlspecialchars($course['fee']); ?></li>
                                <?php endif; ?>
                            </ul>

                            <a href="course_details.php?course_id=<?= $course['id']; ?>" class="btn btn-success mt-auto w-100">
                            View Details</a>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No courses available at the moment.</div>
    <?php endif; ?>
</section>

<style>
.card-title {
    font-size: 1.25rem;
}
.card-text {
    font-size: 0.95rem;
}
.card ul li {
    font-size: 0.9rem;
}
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
