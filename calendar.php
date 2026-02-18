<?php
$page_title = "Institute Calendar";
include 'includes/header.php';

// Example: Load schedules
$schedules_file = __DIR__ . '/data/schedules.json';
$schedules = [];
if (file_exists($schedules_file)) {
    $schedules = json_decode(file_get_contents($schedules_file), true) ?: [];
}
?>

<section class="bg-light py-5 text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">SkillPro Calendar</h1>
        <p class="lead mb-0">Check our upcoming classes, sessions, and events at a glance.</p>
    </div>
</section>

<section class="container my-5">
    <?php if (!empty($schedules)): ?>
        <div class="list-group">
            <?php foreach ($schedules as $sch): ?>
                <div class="list-group-item list-group-item-action flex-column align-items-start mb-2 shadow-sm rounded">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1 text-primary"><?= htmlspecialchars($sch['course']); ?></h5>
                        <small><?= htmlspecialchars($sch['start']); ?><?php if(!empty($sch['end'])) echo " - " . htmlspecialchars($sch['end']); ?></small>
                    </div>
                    <?php if (!empty($sch['days'])): ?>
                        <p class="mb-1"><strong>Days:</strong> <?= htmlspecialchars($sch['days']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No schedules available at the moment.</div>
    <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
