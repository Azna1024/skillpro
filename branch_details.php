<?php
$page_title = "Branch Details";
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
// Get branch ID from query
// ------------------------
if (!isset($_GET['branch_id']) || empty($_GET['branch_id'])) {
    die("Branch ID is missing.");
}
$branch_id = (int)$_GET['branch_id'];

// ------------------------
// Fetch branch details
// ------------------------
try {
    $stmt = $db->prepare("SELECT * FROM branches WHERE id = :id");
    $stmt->execute(['id' => $branch_id]);
    $branch = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$branch) {
        die("Branch not found.");
    }
} catch (PDOException $e) {
    die("Error fetching branch: " . $e->getMessage());
}
?>

<section class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h1 class="fw-bold mb-3"><?= htmlspecialchars($branch['name']); ?></h1>
        <p class="lead mb-0">Full details of this SkillPro Institute branch.</p>
    </div>
</section>

<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 p-5">
                <h3 class="text-primary mb-3"><?= htmlspecialchars($branch['name']); ?></h3>
                <p class="mb-4"><strong>Location:</strong> <?= nl2br(htmlspecialchars($branch['location'])); ?></p>

                <ul class="list-unstyled text-muted mb-4">
                    <?php if (!empty($branch['contact_number'])): ?>
                        <li><strong>Contact:</strong> <?= htmlspecialchars($branch['contact_number']); ?></li>
                    <?php endif; ?>
                    <?php if (!empty($branch['email'])): ?>
                        <li><strong>Email:</strong> <?= htmlspecialchars($branch['email']); ?></li>
                    <?php endif; ?>
                </ul>

                <div class="d-flex justify-content-start">
                    <a href="branches.php" class="btn btn-secondary shadow-sm">
                        <i class="bi bi-arrow-left me-2"></i> Back to Branches
                    </a>
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

<?php include __DIR__ . '/includes/footer.php'; ?>
