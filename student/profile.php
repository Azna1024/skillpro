<?php
session_start();

// Redirect if not a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit;
}

// Fetch student info from session (or database)
$username = htmlspecialchars($_SESSION['name']);
$dob = isset($_SESSION['dob']) ? $_SESSION['dob'] : '2000-01-01'; // default DOB
$age = floor((time() - strtotime($dob)) / (365.25 * 24 * 60 * 60));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard - SkillPro Institute</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root {
    --primary: #667eea;
    --secondary: #764ba2;
    --accent: #4facfe;
    --light-bg: #f5f7fa;
    --text-dark: #2c3e50;
    --text-light: #7f8c8d;
}

/* Body */
body {
    font-family: 'Segoe UI', sans-serif;
    background: var(--light-bg);
    margin: 0;
}

/* Sidebar */
.sidebar {
    height: 100vh;
    width: 220px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: var(--primary);
    color: white;
    display: flex;
    flex-direction: column;
    transition: width 0.3s;
    z-index: 1000;
}
.sidebar.collapsed {
    width: 70px;
}
.sidebar .logo {
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
    padding: 1.5rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}
.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
    flex: 1;
}
.sidebar ul li {
    width: 100%;
}
.sidebar ul li a {
    display: flex;
    align-items: center;
    padding: 1rem 1.2rem;
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.2s;
}
.sidebar ul li a:hover, .sidebar ul li a.active {
    background: var(--secondary);
}
.sidebar ul li a i {
    margin-right: 10px;
    font-size: 1.2rem;
}
.sidebar.collapsed ul li a span {
    display: none;
}

/* Main content */
.main-content {
    margin-left: 220px;
    padding: 2rem;
    transition: margin-left 0.3s;
}
.sidebar.collapsed ~ .main-content {
    margin-left: 70px;
}

/* Header Card */
.header-card {
    background: white;
    border-radius: 20px 20px 0 0;
    padding: 2.5rem 2rem;
    text-align: center;
    position: relative;
    box-shadow: 0 10px 30px rgba(102,126,234,0.2);
}
.profile-photo {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    border: 5px solid white;
    object-fit: cover;
    box-shadow: 0 5px 20px rgba(102,126,234,0.2);
}
.student-name {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary);
    margin: 0.5rem 0;
}
.student-age {
    font-size: 1rem;
    color: var(--text-light);
}

/* Details Section */
.details-section {
    background: white;
    border-radius: 0 0 20px 20px;
    box-shadow: 0 10px 30px rgba(102,126,234,0.2);
    padding: 2rem;
}
.detail-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 1rem;
    border-bottom: 1px solid #eee;
    padding-bottom: 0.5rem;
}
.detail-label {
    font-weight: 600;
    color: var(--text-dark);
}
.detail-value {
    font-weight: 500;
    color: var(--secondary);
}

/* Edit Form */
.edit-form {
    display: none;
    margin-top: 1.5rem;
    padding: 1rem;
    background: #f9f9f9;
    border-radius: 15px;
}
.age-slider-container {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.age-slider {
    flex: 1;
    height: 8px;
    border-radius: 10px;
    background: linear-gradient(90deg, var(--primary), var(--secondary));
    outline: none;
}
.age-slider::-webkit-slider-thumb {
    appearance: none;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background: var(--primary);
    cursor: pointer;
    box-shadow: 0 3px 6px rgba(102,126,234,0.3);
}
.age-display {
    min-width: 70px;
    text-align: center;
    font-weight: 600;
    color: var(--primary);
}
.btn-edit, .btn-cancel, .btn-save {
    border-radius: 20px;
    font-weight: 600;
}
.btn-edit { background: var(--primary); color: white; border: none; }
.btn-edit:hover { background: var(--secondary); }
.btn-cancel { background: #6c757d; color: white; border: none; }
.btn-save { background: var(--secondary); color: white; border: none; }

/* Responsive */
@media (max-width: 768px){
    .sidebar { width: 70px; }
    .main-content { margin-left: 70px; }
}
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="logo">SkillPro</div>
    <ul>
        <li><a href="#" class="active"><i class="bi bi-person-circle"></i><span>Profile</span></a></li>
        <li><a href="#"><i class="bi bi-book"></i><span>My Courses</span></a></li>
        <li><a href="#"><i class="bi bi-journal-text"></i><span>Assignments</span></a></li>
        <li><a href="#"><i class="bi bi-pencil-square"></i><span>Exams</span></a></li>
        <li><a href="#"><i class="bi bi-bar-chart-line"></i><span>Results</span></a></li>
        <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a></li>
    </ul>
</div>

<!-- Main content -->
<div class="main-content">
    <!-- Header Card -->
    <div class="header-card">
        
        <h2 class="student-name"><?php echo $username; ?></h2>
       
        <button class="btn btn-edit mt-2" onclick="toggleEdit()">Edit Profile</button>
    </div>

    <!-- Details Section -->
    <div class="details-section">
        <div class="detail-row">
            <span class="detail-label">Full Name:</span>
            <span class="detail-value" id="fullName">John Michael Doe</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Email:</span>
            <span class="detail-value" id="email">john.doe@skillpro.edu</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Date of Birth:</span>
            <span class="detail-value" id="dob"><?php echo $dob; ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Gender:</span>
            <span class="detail-value" id="gender">Male</span>
        </div>

        <!-- Edit Form -->
        <div class="edit-form" id="editForm">
            <form id="profileForm">
                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" class="form-control" id="editFullName" value="Fathima" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" id="editEmail" value="fathi@skillpro.edu" required>
                </div>
                <div class="mb-3">
                    <label>Date of Birth</label>
                    <input type="date" class="form-control" id="editDob" value="<?php echo $dob; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Gender</label>
                    <select class="form-control" id="editGender" required>
                        <option value="Male">Male</option>
                        <option value="Female"selected>Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="mb-3 age-slider-container">
                    <input type="range" min="16" max="60" value="<?php echo $age; ?>" class="age-slider" id="ageSlider" oninput="updateAge(this.value)">
                    <div class="age-display" id="ageDisplaySlider"><?php echo $age; ?> years</div>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-cancel" onclick="toggleEdit()">Cancel</button>
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleEdit() {
    const form = document.getElementById('editForm');
    form.style.display = form.style.display === 'block' ? 'none' : 'block';
}

function updateAge(val) {
    document.getElementById('ageDisplaySlider').textContent = val + ' years';
    document.getElementById('displayAge').textContent = val + ' years';
}

// Auto-calculate age from DOB
document.getElementById('editDob').addEventListener('change', function() {
    const dob = new Date(this.value);
    const today = new Date();
    const age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
    if(age >=16 && age <=60){
        document.getElementById('ageSlider').value = age;
        updateAge(age);
    }
});

// Handle form submission
document.getElementById('profileForm').addEventListener('submit', function(e){
    e.preventDefault();
    document.getElementById('fullName').textContent = document.getElementById('editFullName').value;
    document.getElementById('email').textContent = document.getElementById('editEmail').value;
    document.getElementById('dob').textContent = document.getElementById('editDob').value;
    document.getElementById('gender').textContent = document.getElementById('editGender').value;
    updateAge(document.getElementById('ageSlider').value);
    toggleEdit();
    alert('Profile updated successfully!');
});
</script>
</body>
</html>
