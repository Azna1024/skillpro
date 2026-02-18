<?php
$page_title = "Branches";
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

// ------------------------
// Fetch branches
// ------------------------
try {
    $stmt = $db->query("SELECT * FROM branches ORDER BY name ASC");
    $branches = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching branches: " . $e->getMessage());
}
?>

<section class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Our Branches</h1>
        <p class="lead mb-0">Find a SkillPro Institute branch near you!</p>
    </div>
</section>

<section class="container my-5">
    <?php if (!empty($branches)): ?>
        <div class="row g-4">
            <?php foreach ($branches as $branch): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary"><?= htmlspecialchars($branch['name']); ?></h5>
                            <p class="card-text mb-2"><?= nl2br(htmlspecialchars($branch['location'])); ?></p>

                            <ul class="list-unstyled text-muted mb-3">
                                <?php if (!empty($branch['contact_number'])): ?>
                                    <li><strong>Contact:</strong> <?= htmlspecialchars($branch['contact_number']); ?></li>
                                <?php endif; ?>
                                <?php if (!empty($branch['email'])): ?>
                                    <li><strong>Email:</strong> <?= htmlspecialchars($branch['email']); ?></li>
                                <?php endif; ?>
                            </ul>

                            <a href="branch_details.php?branch_id=<?= $branch['id']; ?>" class="btn btn-success mt-auto w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No branches available at the moment.</div>
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
