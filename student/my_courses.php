<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - SkillPro Institute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* ===== Root & Colors ===== */
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --background-color: #f5f7fa;
            --accent-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --card-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--background-color);
            margin: 0;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            height: 100vh;
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            flex-direction: column;
            transition: width 0.3s;
            z-index: 1000;
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

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 1rem 1.2rem;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background: var(--secondary-color);
            transform: translateX(5px);
        }

        .sidebar ul li a i {
            margin-right: 10px;
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
        }

        /* ===== Main Content ===== */
        .main-content {
            margin-left: 220px;
            padding: 2rem;
            transition: margin-left 0.3s;
            min-height: 100vh;
        }

        /* ===== Page Header ===== */
        .page-header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 2rem;
            font-weight: bold;
            color: var(--text-dark);
            margin: 0;
        }

        .page-subtitle {
            color: var(--text-light);
            margin: 5px 0 0 0;
        }

        .logout-btn {
            background: var(--danger-color);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .logout-btn:hover {
            background: #c82333;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        /* ===== Filter Section ===== */
        .filter-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: var(--card-shadow);
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: var(--background-color);
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            color: var(--text-dark);
            transition: all 0.3s;
            cursor: pointer;
        }

        .filter-btn.active {
            background: var(--primary-color);
            color: white;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* ===== Course Cards ===== */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
        }

        .course-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.3s;
            border: 1px solid #e9ecef;
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .course-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px;
            position: relative;
        }

        .course-category {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 10px;
        }

        .course-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin: 0;
            line-height: 1.4;
        }

        .course-body {
            padding: 20px;
        }

        .course-description {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .course-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .meta-item i {
            color: var(--primary-color);
        }

        .course-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .course-actions {
            display: flex;
            gap: 10px;
        }

        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
            flex: 1;
        }

        .btn-primary-custom:hover {
            background: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }

        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
        }

        /* ===== Progress Bar ===== */
        .progress-section {
            margin-bottom: 15px;
        }

        .progress {
            height: 6px;
            border-radius: 10px;
            background: #e9ecef;
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
        }

        /* ===== Empty State ===== */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--text-light);
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .empty-description {
            color: var(--text-light);
            margin-bottom: 25px;
        }

        /* ===== Alert Messages ===== */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
        }

        /* ===== Responsive Design ===== */
        @media(max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .courses-grid {
                grid-template-columns: 1fr;
            }
            
            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .course-actions {
                flex-direction: column;
            }
            
            .course-meta {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }

        /* ===== Animations ===== */
        .course-card {
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">SkillPro</div>
        <ul>
            <li><a href="profile.php"><i class="bi bi-person-circle"></i><span>Profile</span></a></li>
            <li><a href="my_courses.php" class="active"><i class="bi bi-book"></i><span>My Courses</span></a></li>
            <li><a href="assignments.php"><i class="bi bi-journal-text"></i><span>Assignments</span></a></li>
            <li><a href="exams.php"><i class="bi bi-pencil-square"></i><span>Exams</span></a></li>
            <li><a href="results.php"><i class="bi bi-bar-chart-line"></i><span>Results</span></a></li>
            <li><a href="../logout.php"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title"><i class="bi bi-book me-2"></i>My Courses</h1>
                <p class="page-subtitle">Manage your enrolled courses and track your progress</p>
            </div>
            <a href="../logout.php" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer">
            <!-- PHP Alert Messages would go here -->
            <!-- Example: <?php if (!empty($message)) echo $message; ?> -->
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-buttons">
                <button class="filter-btn active" onclick="filterCourses('all')">
                    <i class="bi bi-grid-3x3-gap me-1"></i> All Courses
                </button>
                <button class="filter-btn" onclick="filterCourses('approved')">
                    <i class="bi bi-check-circle me-1"></i> Approved
                </button>
                <button class="filter-btn" onclick="filterCourses('pending')">
                    <i class="bi bi-clock me-1"></i> Pending
                </button>
                <button class="filter-btn" onclick="filterCourses('Information Technology')">
                    <i class="bi bi-laptop me-1"></i> IT Courses
                </button>
                <button class="filter-btn" onclick="filterCourses('Engineering')">
                    <i class="bi bi-gear me-1"></i> Engineering
                </button>
            </div>
        </div>

        <!-- Courses Grid -->
        <div class="courses-grid" id="coursesGrid">
            <!-- Course 1 - Web Development with PHP -->
            <div class="course-card" data-status="approved" data-category="Information Technology">
                <div class="course-header">
                    <span class="course-category">Information Technology</span>
                    <h3 class="course-title">Web Development with PHP</h3>
                </div>
                <div class="course-body">
                    <p class="course-description">
                        Learn to build dynamic websites using HTML, CSS, JavaScript, and PHP. Covers database integration, user authentication, and responsive design principles.
                    </p>
                    
                    <div class="progress-section">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Progress</small>
                            <small class="text-muted">75%</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 75%"></div>
                        </div>
                    </div>
                    
                    <div class="course-meta">
                        <div class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>Kandy Branch</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-currency-rupee"></i>
                            <span>LKR 25,000.00</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar"></i>
                            <span>6 months</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-people"></i>
                            <span>25 students</span>
                        </div>
                    </div>
                    
                    <span class="course-status status-approved">Approved</span>
                    
                    <div class="course-actions">
                        <a href="../courses.php?id=1" class="btn-primary-custom">
                            <i class="bi bi-play-circle me-1"></i> Continue Learning
                        </a>
                        <a href="assignments.php?course=1" class="btn-outline-custom">
                            <i class="bi bi-clipboard-check"></i> Assignments
                        </a>
                    </div>
                </div>
            </div>

            <!-- Course 2 - ICT Fundamentals -->
            <div class="course-card" data-status="approved" data-category="Information Technology">
                <div class="course-header">
                    <span class="course-category">Information Technology</span>
                    <h3 class="course-title">ICT Fundamentals</h3>
                </div>
                <div class="course-body">
                    <p class="course-description">
                        Covers basic computer skills, MS Office, and internet usage. Perfect foundation course for beginners in information technology.
                    </p>
                    
                    <div class="progress-section">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Progress</small>
                            <small class="text-muted">90%</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 90%"></div>
                        </div>
                    </div>
                    
                    <div class="course-meta">
                        <div class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>Colombo Branch</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-currency-rupee"></i>
                            <span>LKR 15,000.00</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar"></i>
                            <span>4 months</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-people"></i>
                            <span>30 students</span>
                        </div>
                    </div>
                    
                    <span class="course-status status-approved">Approved</span>
                    
                    <div class="course-actions">
                        <a href="../courses.php?id=2" class="btn-primary-custom">
                            <i class="bi bi-play-circle me-1"></i> Continue Learning
                        </a>
                        <a href="exams.php?course=2" class="btn-outline-custom">
                            <i class="bi bi-file-text"></i> Take Exam
                        </a>
                    </div>
                </div>
            </div>

            <!-- Course 3 - Hotel Management Basics -->
            <div class="course-card" data-status="pending" data-category="Tourism & Hospitality">
                <div class="course-header">
                    <span class="course-category">Tourism & Hospitality</span>
                    <h3 class="course-title">Hotel Management Basics</h3>
                </div>
                <div class="course-body">
                    <p class="course-description">
                        Introduction to hospitality, customer service, and hotel operations. Learn the fundamentals of running a successful hotel business.
                    </p>
                    
                    <div class="progress-section">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Pending Approval</small>
                            <small class="text-muted">0%</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    
                    <div class="course-meta">
                        <div class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>Kandy Branch</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-currency-rupee"></i>
                            <span>LKR 25,000.00</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar"></i>
                            <span>5 months</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-clock"></i>
                            <span>Awaiting approval</span>
                        </div>
                    </div>
                    
                    <span class="course-status status-pending">Pending</span>
                    
                    <div class="course-actions">
                        <a href="../courses.php?id=3" class="btn-outline-custom">
                            <i class="bi bi-eye me-1"></i> View Details
                        </a>
                        <a href="contact.php" class="btn-outline-custom">
                            <i class="bi bi-telephone"></i> Contact Support
                        </a>
                    </div>
                </div>
            </div>

            <!-- Course 4 - Plumbing Basics -->
            <div class="course-card" data-status="approved" data-category="Engineering">
                <div class="course-header">
                    <span class="course-category">Engineering</span>
                    <h3 class="course-title">Plumbing Basics</h3>
                </div>
                <div class="course-body">
                    <p class="course-description">
                        Introduction to plumbing systems, tools, and safety practices. Hands-on training with real-world applications and industry standards.
                    </p>
                    
                    <div class="progress-section">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Progress</small>
                            <small class="text-muted">45%</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 45%"></div>
                        </div>
                    </div>
                    
                    <div class="course-meta">
                        <div class="meta-item">
                            <i class="bi bi-geo-alt"></i>
                            <span>Colombo Branch</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-currency-rupee"></i>
                            <span>LKR 18,000.00</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-calendar"></i>
                            <span>3 months</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-people"></i>
                            <span>15 students</span>
                        </div>
                    </div>
                    
                    <span class="course-status status-approved">Approved</span>
                    
                    <div class="course-actions">
                        <a href="../courses.php?id=4" class="btn-primary-custom">
                            <i class="bi bi-play-circle me-1"></i> Continue Learning
                        </a>
                        <a href="assignments.php?course=4" class="btn-outline-custom">
                            <i class="bi bi-tools"></i> Practical Tasks
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State (Hidden by default) -->
        <div class="empty-state" id="emptyState" style="display: none;">
            <div class="empty-icon">
                <i class="bi bi-book-half"></i>
            </div>
            <h3 class="empty-title">No Courses Found</h3>
            <p class="empty-description">
                You haven't enrolled in any courses matching this filter yet.
            </p>
            <a href="../courses.php" class="btn-primary-custom" style="display: inline-block; width: auto;">
                <i class="bi bi-search me-1"></i> Browse Available Courses
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show alert message
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alertId = 'alert-' + Date.now();
            
            const alertHTML = `
                <div id="${alertId}" class="alert alert-${type} alert-dismissible fade show" role="alert">
                    <strong>${type.charAt(0).toUpperCase() + type.slice(1)}!</strong> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            alertContainer.innerHTML = alertHTML;
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                const alert = document.getElementById(alertId);
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 5000);
        }

        // Filter courses by status or category
        function filterCourses(filter) {
            const cards = document.querySelectorAll('.course-card');
            const filterButtons = document.querySelectorAll('.filter-btn');
            const coursesGrid = document.getElementById('coursesGrid');
            const emptyState = document.getElementById('emptyState');
            
            // Update active filter button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            let visibleCount = 0;
            
            cards.forEach(card => {
                const status = card.dataset.status;
                const category = card.dataset.category;
                
                if (filter === 'all' || status === filter || category === filter) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show empty state if no courses match
            if (visibleCount === 0) {
                coursesGrid.style.display = 'none';
                emptyState.style.display = 'block';
            } else {
                coursesGrid.style.display = 'grid';
                emptyState.style.display = 'none';
            }
        }

        // Add animation to cards on load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.course-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Simulate success message (remove in production)
            setTimeout(() => {
                showAlert('Welcome to your course dashboard! Your progress has been updated.', 'success');
            }, 1000);
        });
    </script>
</body>
</html>