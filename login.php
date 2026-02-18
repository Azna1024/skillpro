<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$page_title = "SkillPro Institute - Login";


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
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = strtolower($user['role']); 

        // Show success message and redirect after 2 seconds
        $message = showAlert(" Login successful!");
        echo "<meta http-equiv='refresh' content='2;url=dashboard.php'>";
    } else {
        $message = showAlert("Invalid login details. Please try again.", "danger");
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
          background: linear-gradient(to right, #1976d2, #42a5f5);
          min-height: 100vh;
      }
      .login-container {
          display: flex;
          align-items: center;
          justify-content: center;
          min-height: 100vh;
      }
      .login-card {
          background: #fff;
          border-radius: 15px;
          box-shadow: 0 6px 20px rgba(0,0,0,0.2);
          width: 100%;
          max-width: 420px;
          padding: 35px;
      }
      .login-card h2 {
          font-weight: bold;
          color: #1976d2;
      }
      .btn-primary {
          background: #1976d2;
          border: none;
      }
      .btn-primary:hover {
          background: #125ca1;
      }
      .form-control {
          border-radius: 8px;
      }
  </style>
</head>
<body>

<div class="login-container">
  <div class="login-card">
      <div class="text-center mb-4">
          <i class="bi bi-mortarboard-fill text-primary" style="font-size: 2.5rem;"></i>
          <h2 class="mt-2">SkillPro Institute</h2>
          <p class="text-muted">Sign in to continue</p>
      </div>

      <?php if (!empty($message)) echo $message; ?>

      <form method="POST">
          <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email</label>
              <input type="email" name="email" id="email" 
                     class="form-control" 
                     value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES) ?>" 
                     placeholder="Enter your email" required>
          </div>
          <div class="mb-3">
              <label for="password" class="form-label fw-semibold">Password</label>
              <input type="password" name="password" id="password" 
                     class="form-control" placeholder="Enter your password" required>
          </div>
          <button type="submit" class="btn btn-primary w-100 fw-semibold">Login</button>
      </form>

      <div class="text-center mt-3">
          <span class="text-muted">Don't have an account? </span>
          <a href="register.php" class="fw-bold text-primary text-decoration-none">Register here</a>
      </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
