<?php
if (!isset($page_title)) {
    $page_title = "SkillPro Institute";
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($page_title) ?> | SkillPro</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
body { font-family: "Segoe UI", sans-serif; margin:0; }

/* Navbar links */
.navbar-nav .nav-link { margin-right: 10px; font-weight: 500; }
.navbar-nav .nav-link.active { color: #1479fdff !important; font-weight: 600; }

/* Login/Register buttons */
.btn-login { 
    margin-left: 10px; 
    background-color: #28a745;  /* green */
    color: white; 
    font-weight: 500; 
    border-radius: 0.35rem;
}
.btn-login:hover { 
    background-color: #218838; 
    color: white; 
}

.btn-register { 
    margin-left: 10px; 
    background-color: #1479fdff; /* orange */
    color: white; 
    font-weight: 500; 
    border-radius: 0.35rem;
}
.btn-register:hover { 
    background-color: #e8590c; 
    color: white; 
}
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/skillpro/index.php">SkillPro</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
<div class="collapse navbar-collapse" id="navbarNav">
   <!-- Left Menu -->
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
  <li class="nav-item"><a class="nav-link <?= ($_SERVER['PHP_SELF'] === '/skillpro/index.php') ? 'active' : '' ?>" href="/skillpro/index.php">Home</a></li>
  <li class="nav-item"><a class="nav-link <?= ($_SERVER['PHP_SELF'] === '/skillpro/about.php') ? 'active' : '' ?>" href="/skillpro/about.php">About Us</a></li>
  <li class="nav-item"><a class="nav-link <?= ($_SERVER['PHP_SELF'] === '/skillpro/courses.php') ? 'active' : '' ?>" href="/skillpro/courses.php">Courses</a></li>
  <li class="nav-item"><a class="nav-link <?= ($_SERVER['PHP_SELF'] === '/skillpro/branches.php') ? 'active' : '' ?>" href="/skillpro/branches.php">Branches</a></li>
  <li class="nav-item"><a class="nav-link <?= ($_SERVER['PHP_SELF'] === '/skillpro/instructor.php') ? 'active' : '' ?>" href="/skillpro/instructor.php">Instructors</a></li>
  <li class="nav-item"><a class="nav-link <?= ($_SERVER['PHP_SELF'] === '/skillpro/events.php') ? 'active' : '' ?>" href="/skillpro/events.php">Events & Calendar</a></li>
  <li class="nav-item"><a class="nav-link <?= ($_SERVER['PHP_SELF'] === '/skillpro/contact.php') ? 'active' : '' ?>" href="/skillpro/contact.php">Contact Us</a></li>
        
      </ul>

      <!-- Right Menu -->
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['user_id'])): ?>
            
            <li class="nav-item"><a class="nav-link text-danger" href="/skillpro/logout.php"><i class="bi bi-box-arrow-right me-1"></i> Logout</a></li>
        <?php else: ?>
            <li class="nav-item"><a class="nav-link btn btn-login btn-sm" href="/skillpro/login.php"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a></li>
            <li class="nav-item"><a class="nav-link btn btn-register btn-sm" href="/skillpro/register.php"><i class="bi bi-pencil-square me-1"></i> Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
