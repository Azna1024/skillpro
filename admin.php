<?php
// admin.php - SkillPro admin dashboard
// Place this file in your /skillpro/ (or admin/) folder as appropriate.

// Basic setup
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

// Only allow access to admins
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    // Not logged in or not admin -> redirect to main login
    header('Location: /skillpro/login.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();
$flash = '';

// Handle actions (delete user) - simple example
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action === 'delete_user' && !empty($_POST['user_id'])) {
        $userId = (int) $_POST['user_id'];
        try {
            $del = $db->prepare("DELETE FROM users WHERE id = :id AND role != 'admin'"); // protect other admins
            $del->bindValue(':id', $userId, PDO::PARAM_INT);
            $del->execute();
            if ($del->rowCount()) {
                $flash = "<div class='alert alert-success'>User #{$userId} deleted.</div>";
            } else {
                $flash = "<div class='alert alert-warning'>No user deleted (maybe admin or not found).</div>";
            }
        } catch (PDOException $e) {
            error_log("Admin delete_user error: " . $e->getMessage());
            $flash = "<div class='alert alert-danger'>Server error while deleting user.</div>";
        }
    }
}

// Fetch dashboard data
try {
    // counts
    $counts = [];
    $counts['users'] = (int) $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    
    try {
        $counts['courses'] = (int) $db->query("SELECT COUNT(*) FROM courses")->fetchColumn();
    } catch (Exception $e) {
        $counts['courses'] = 0;
    }

    // recent users (limit 10)
    $stmt = $db->prepare("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC LIMIT 10");
    $stmt->execute();
    $recentUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Admin dashboard DB error: " . $e->getMessage());
    // show friendly message
    $flash = "<div class='alert alert-danger'>Unable to load dashboard data. Check logs.</div>";
    $counts = ['users' => 0, 'courses' => 0];
    $recentUsers = [];
}

$page_title = "Admin Dashboard - SkillPro";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($page_title); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f5f7fb; }
    .stat-card { border-radius: 12px; box-shadow: 0 3px 12px rgba(0,0,0,0.06); }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/skillpro/index.php">SkillPro</a>
    <div class="ms-auto">
      <span class="text-white me-3">Signed in as: <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>
      <a class="btn btn-outline-light btn-sm" href="/skillpro/logout.php">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 mb-0">Admin Dashboard</h1>
    <small class="text-muted">Manage users, view quick stats</small>
  </div>

  <?php if ($flash) echo $flash; ?>

  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="p-3 stat-card bg-white">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="text-uppercase text-muted small">Users</div>
            <strong class="fs-4"><?php echo number_format($counts['users']); ?></strong>
          </div>
          <div>
            <i class="bi bi-people-fill" style="font-size: 1.8rem;"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="p-3 stat-card bg-white">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div class="text-uppercase text-muted small">Courses</div>
            <strong class="fs-4"><?php echo number_format($counts['courses']); ?></strong>
          </div>
          <div>
            <i class="bi bi-journal-bookmark-fill" style="font-size: 1.8rem;"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="p-3 stat-card bg-white">
        <div class="d-flex justify-content-between">
          <div>
            <div class="text-uppercase text-muted small">Quick Actions</div>
            <div class="mt-2">
              <a href="/skillpro/admin/users.php" class="btn btn-sm btn-primary me-2">Manage Users</a>
              <a href="/skillpro/admin/courses.php" class="btn btn-sm btn-secondary me-2">Manage Courses</a>
              <a href="/skillpro/admin/create_admin.php" class="btn btn-sm btn-outline-primary">Create Admin</a>
            </div>
          </div>
          <div class="text-end text-muted small">
            Last updated: <?php echo date('M d, Y H:i'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent users table -->
  <div class="card mb-4">
    <div class="card-header">
      Recent Users
    </div>
    <div class="card-body p-0">
      <?php if (empty($recentUsers)): ?>
        <div class="p-3">No users found.</div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-sm mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($recentUsers as $u): ?>
                <tr>
                  <td><?php echo (int)$u['id']; ?></td>
                  <td><?php echo htmlspecialchars($u['username'] ?? '-'); ?></td>
                  <td><?php echo htmlspecialchars($u['email']); ?></td>
                  <td><?php echo htmlspecialchars($u['role']); ?></td>
                  <td><?php echo htmlspecialchars($u['created_at'] ?? '-'); ?></td>
                  <td class="text-end">
                    <a href="/skillpro/admin/edit_user.php?id=<?php echo (int)$u['id']; ?>" class="btn btn-sm btn-outline-secondary">Edit</a>

                    <!-- Delete form (simple) -->
                    <form method="post" class="d-inline" onsubmit="return confirm('Delete this user?');">
                      <input type="hidden" name="action" value="delete_user">
                      <input type="hidden" name="user_id" value="<?php echo (int)$u['id']; ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Footer / notes -->
  <div class="text-muted small">
    Note: Deleting users will remove them permanently. Admin accounts are protected from deletion by this interface.
  </div>
</div>

<!-- Bootstrap JS & Icons (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
