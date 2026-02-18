<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = "SkillPro Institute - Register";

class Database {
    private $host = "localhost";
    private $db_name = "skillpro_dp";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            die("Database Connection error: " . $exception->getMessage());
        }
        return $this->conn;
    }
}

$database = new Database();
$db = $database->getConnection();

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}

function showAlert($message, $type = "info") {
    return "<div class='alert alert-{$type} alert-dismissible fade show shadow-sm' role='alert'>
                <i class='bi bi-exclamation-circle-fill me-2'></i>{$message}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $email    = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];
    $role     = "student";

    if ($password !== $confirm) {
        $message = showAlert("Passwords do not match!", "danger");
    } else {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $message = showAlert("Email already registered.", "warning");
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashedPassword, $role])) {
                $message = showAlert("Registration successful! Redirecting to login...", "success");
                header("Refresh:2; url=login.php");
            } else {
                $message = showAlert("Something went wrong. Please try again.", "danger");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <style>
      body {
          font-family: "Segoe UI", Arial, sans-serif;
          background: linear-gradient(to right, #28a745, #66bb6a);
          min-height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
      }
      .register-card {
          background: #fff;
          border-radius: 15px;
          box-shadow: 0 6px 20px rgba(0,0,0,0.2);
          width: 100%;
          max-width: 450px;
          padding: 35px;
      }
      .register-card h2 {
          font-weight: bold;
          color: #28a745;
      }
      .btn-success {
          background: #28a745;
          border: none;
      }
      .btn-success:hover {
          background: #218838;
      }
      .form-control {
          border-radius: 8px;
      }
  </style>
</head>
<body>

<div class="register-card">
    <div class="text-center mb-4">
        <i class="bi bi-person-plus-fill text-success" style="font-size: 2.5rem;"></i>
        <h2 class="mt-2">SkillPro Institute</h2>
        <p class="text-muted">Create your student account</p>
    </div>

    <?php if (!empty($message)) echo $message; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label fw-semibold">Full Name</label>
            <input type="text" id="username" name="username" 
                   class="form-control" placeholder="Enter your full name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" id="email" name="email" 
                   class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password" id="password" name="password" 
                   class="form-control" placeholder="Enter a password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label fw-semibold">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" 
                   class="form-control" placeholder="Re-enter your password" required>
        </div>
        <button type="submit" class="btn btn-success w-100 fw-semibold">Register</button>
    </form>

    <div class="text-center mt-3">
        <span class="text-muted">Already have an account? </span>
        <a href="login.php" class="fw-bold text-success text-decoration-none">Login here</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
