<?php
$page_title = "Our Instructors";
include 'includes/header.php';

$host = 'localhost';
$db_name = 'skillpro_dp';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch instructors
    $stmt = $db->query("
        SELECT 
            instructor_id,
            CONCAT(first_name, ' ', last_name) AS name,
            specialization AS expertise,
            email AS contact,
            phone,
            mobile,
            bio
        FROM instructor
        ORDER BY first_name ASC
    ");
    $instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!-- Page Hero -->

<section class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Meet Our Expert Instructors</h1>
        <p class="lead mb-0">Learn from experienced professionals who will guide you to success.</p>
    </div>
</section>

<!-- Instructors List -->
<section class="container my-5">
    <?php if (!empty($instructors)): ?>
        <div class="row g-4">
            <?php foreach ($instructors as $inst): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 border-0 p-3">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success"><?= htmlspecialchars($inst['name']); ?></h5>
                            <?php if (!empty($inst['expertise'])): ?>
                                <p class="card-text"><strong>Expertise:</strong> <?= htmlspecialchars($inst['expertise']); ?></p>
                            <?php endif; ?>
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#instructorModal<?= $inst['instructor_id']; ?>">
                                View Profile
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="instructorModal<?= $inst['instructor_id']; ?>" tabindex="-1" aria-labelledby="instructorModalLabel<?= $inst['instructor_id']; ?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="instructorModalLabel<?= $inst['instructor_id']; ?>"><?= htmlspecialchars($inst['name']); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <?php if (!empty($inst['expertise'])): ?>
                            <p><strong>Expertise:</strong> <?= htmlspecialchars($inst['expertise']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($inst['bio'])): ?>
                            <p><strong>Bio:</strong> <?= nl2br(htmlspecialchars($inst['bio'])); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($inst['contact'])): ?>
                            <p><strong>Email:</strong> <?= htmlspecialchars($inst['contact']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($inst['phone'])): ?>
                            <p><strong>Phone:</strong> <?= htmlspecialchars($inst['phone']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($inst['mobile'])): ?>
                            <p><strong>Mobile:</strong> <?= htmlspecialchars($inst['mobile']); ?></p>
                        <?php endif; ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No instructors available at the moment.</div>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>

<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
</style>
