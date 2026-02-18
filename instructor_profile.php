<?php
// instructor_profile.php - Admin: Create and view instructor profiles
require_once 'includes/functions.php';
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $expertise = $_POST['expertise'] ?? '';
    $contact = $_POST['contact'] ?? '';
    if ($name) {
        $file = __DIR__.'/data/instructors.json';
        $ins = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        $ins[] = ['id'=>uniqid('inst_'),'name'=>$name,'expertise'=>$expertise,'contact'=>$contact];
        file_put_contents($file, json_encode($ins, JSON_PRETTY_PRINT));
        $msg = "✅ Instructor saved successfully!";
    } else {
        $err = "⚠️ Name is required.";
    }
}

$instructors = [];
if (file_exists(__DIR__.'/data/instructors.json')) {
    $instructors = json_decode(file_get_contents(__DIR__.'/data/instructors.json'), true) ?: [];
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>SkillPro Institute - Instructors</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="text-center mb-4">
    <h1 class="fw-bold text-primary">👨‍🏫 Instructor Profiles</h1>
    <p class="text-muted">Meet our expert instructors</p>
  </div>

  <?php if (!empty($msg)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>
  <?php if (!empty($err)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
  <?php endif; ?>

  <!-- Add Instructor Form -->
  <div class="card shadow-sm mb-4 border-0">
    <div class="card-body">
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Name *</label>
          <input type="text" name="name" class="form-control" required placeholder="Instructor Name">
        </div>
        <div class="mb-3">
          <label class="form-label">Expertise</label>
          <input type="text" name="expertise" class="form-control" placeholder="Subject/Skills">
        </div>
        <div class="mb-3">
          <label class="form-label">Contact (Email/Phone)</label>
          <input type="text" name="contact" class="form-control" placeholder="Email or Phone">
        </div>
        <button type="submit" class="btn btn-success w-100">💾 Save Instructor</button>
      </form>
    </div>
  </div>

  <!-- Display Instructors -->
  <div class="row">
    <?php if (empty($instructors)): ?>
      <p class="text-center text-muted">No instructors added yet.</p>
    <?php else: ?>
      <?php foreach ($instructors as $i): ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
              <h5 class="card-title text-primary"><?= htmlspecialchars($i['name']) ?></h5>
              <?php if(!empty($i['expertise'])): ?>
                <p class="card-text"><strong>Expertise:</strong> <?= htmlspecialchars($i['expertise']) ?></p>
              <?php endif; ?>
              <?php if(!empty($i['contact'])): ?>
                <p class="card-text"><strong>Contact:</strong> <?= htmlspecialchars($i['contact']) ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
