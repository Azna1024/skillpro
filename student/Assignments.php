<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments - SkillPro Institute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* ===== Root & Colors ===== */
        :root {
            --primary-color: #1976d2;
            --secondary-color: #f5f7fa;
            --accent-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --card-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: var(--secondary-color);
            margin: 0;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: var(--primary-color);
            color: white;
            position: fixed;
            padding-top: 20px;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            padding: 0 15px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 5px 10px;
            transition: all 0.3s;
        }

        .sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.2);
            color: #fff;
            transform: translateX(5px);
        }

        /* ===== Main Content ===== */
        .main-content {
            margin-left: 250px;
            padding: 25px;
            min-height: 100vh;
        }

        /* ===== Header ===== */
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

        /* ===== Filter Tabs ===== */
        .filter-tabs {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: var(--card-shadow);
        }

        .tab-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tab-btn {
            background: var(--secondary-color);
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            color: var(--text-dark);
            transition: all 0.3s;
            cursor: pointer;
        }

        .tab-btn.active {
            background: var(--primary-color);
            color: white;
        }

        .tab-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* ===== Assignment Cards ===== */
        .assignments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
        }

        .assignment-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s;
            border-left: 5px solid var(--primary-color);
            position: relative;
        }

        .assignment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        /* Assignment Status Colors */
        .assignment-card.pending {
            border-left-color: var(--warning-color);
        }

        .assignment-card.submitted {
            border-left-color: var(--accent-color);
        }

        .assignment-card.overdue {
            border-left-color: var(--danger-color);
        }

        /* Card Header */
        .assignment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .assignment-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--text-dark);
            margin: 0;
            flex: 1;
        }

        .assignment-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-submitted {
            background: #d4edda;
            color: #155724;
        }

        .status-overdue {
            background: #f8d7da;
            color: #721c24;
        }

        .status-not-started {
            background: #e2e3e5;
            color: #6c757d;
        }

        /* Card Content */
        .assignment-course {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .assignment-description {
            color: var(--text-light);
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .assignment-meta {
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

        /* Due Date Warning */
        .due-soon {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
            color: #856404;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Card Actions */
        .assignment-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
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
            background: #1565c0;
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
            
            .assignments-grid {
                grid-template-columns: 1fr;
            }
            
            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .assignment-actions {
                flex-direction: column;
            }
            
            .assignment-meta {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }

        /* ===== Animations ===== */
        .assignment-card {
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
    <div class="sidebar">
        <h4><i class="bi bi-mortarboard"></i> SkillPro</h4>
        <a href="profile.php"><i class="bi bi-person"></i> Profile</a>
        <a href="courses.php"><i class="bi bi-book"></i> My Courses</a>
        <a href="assignments.php" class="active"><i class="bi bi-clipboard-check"></i> Assignments</a>
        <a href="exams.php"><i class="bi bi-file-text"></i> Exams</a>
        <a href="results.php"><i class="bi bi-graph-up"></i> Results</a>
        <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title"><i class="bi bi-clipboard-check me-2"></i>My Assignments</h1>
                <p class="page-subtitle">Manage and submit your course assignments</p>
            </div>
            <a href="logout.php" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

        <!-- Alert Messages -->
        <div id="alertContainer"></div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <div class="tab-buttons">
                <button class="tab-btn active" onclick="filterAssignments('all')">
                    <i class="bi bi-grid-3x3-gap me-1"></i> All Assignments
                </button>
                <button class="tab-btn" onclick="filterAssignments('pending')">
                    <i class="bi bi-clock me-1"></i> Pending
                </button>
                <button class="tab-btn" onclick="filterAssignments('submitted')">
                    <i class="bi bi-check-circle me-1"></i> Submitted
                </button>
                <button class="tab-btn" onclick="filterAssignments('overdue')">
                    <i class="bi bi-exclamation-triangle me-1"></i> Overdue
                </button>
            </div>
        </div>

        <!-- Assignments Grid -->
        <div class="assignments-grid" id="assignmentsGrid">
            <!-- Assignment 1 - Pending -->
            <div class="assignment-card pending" data-status="pending">
                <div class="assignment-header">
                    <h3 class="assignment-title">Web Development Project</h3>
                    <span class="assignment-status status-pending">Pending</span>
                </div>
                
                <div class="assignment-course">
                    <i class="bi bi-book me-1"></i> Web Development with PHP
                </div>
                
                <p class="assignment-description">
                    Create a dynamic website using HTML, CSS, JavaScript, and PHP. The project should include user authentication, database integration, and responsive design.
                </p>

                <div class="due-soon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Due in 3 days - Don't forget to submit!
                </div>
                
                <div class="assignment-meta">
                    <div class="meta-item">
                        <i class="bi bi-calendar"></i>
                        <span>Due: Dec 15, 2024</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-file-earmark"></i>
                        <span>Max Size: 50MB</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-star"></i>
                        <span>Max Marks: 100</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-person"></i>
                        <span>Instructor: John Smith</span>
                    </div>
                </div>
                
                <div class="assignment-actions">
                    <a href="submit_assignment.php?id=1" class="btn-primary-custom">
                        <i class="bi bi-upload me-1"></i> Submit Assignment
                    </a>
                    <a href="assignment_details.php?id=1" class="btn-outline-custom">
                        <i class="bi bi-eye"></i> View Details
                    </a>
                </div>
            </div>

            <!-- Assignment 2 - Submitted -->
            <div class="assignment-card submitted" data-status="submitted">
                <div class="assignment-header">
                    <h3 class="assignment-title">Database Design Report</h3>
                    <span class="assignment-status status-submitted">Submitted</span>
                </div>
                
                <div class="assignment-course">
                    <i class="bi bi-book me-1"></i> ICT Fundamentals
                </div>
                
                <p class="assignment-description">
                    Design a normalized database schema for a library management system. Include ER diagrams, table structures, and sample queries.
                </p>
                
                <div class="assignment-meta">
                    <div class="meta-item">
                        <i class="bi bi-calendar"></i>
                        <span>Submitted: Dec 1, 2024</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-check-circle"></i>
                        <span>Status: Under Review</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-star"></i>
                        <span>Max Marks: 50</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-person"></i>
                        <span>Instructor: Sarah Johnson</span>
                    </div>
                </div>
                
                <div class="assignment-actions">
                    <a href="view_submission.php?id=2" class="btn-primary-custom">
                        <i class="bi bi-file-text me-1"></i> View Submission
                    </a>
                    <a href="assignment_feedback.php?id=2" class="btn-outline-custom">
                        <i class="bi bi-chat-dots"></i> Feedback
                    </a>
                </div>
            </div>

            <!-- Assignment 3 - Overdue -->
            <div class="assignment-card overdue" data-status="overdue">
                <div class="assignment-header">
                    <h3 class="assignment-title">Hotel Management Case Study</h3>
                    <span class="assignment-status status-overdue">Overdue</span>
                </div>
                
                <div class="assignment-course">
                    <i class="bi bi-book me-1"></i> Hotel Management Basics
                </div>
                
                <p class="assignment-description">
                    Analyze a real hotel management scenario and propose solutions for customer service improvements and operational efficiency.
                </p>
                
                <div class="assignment-meta">
                    <div class="meta-item">
                        <i class="bi bi-calendar-x"></i>
                        <span>Was Due: Nov 30, 2024</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>7 days overdue</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-star"></i>
                        <span>Max Marks: 75</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-person"></i>
                        <span>Instructor: Mike Wilson</span>
                    </div>
                </div>
                
                <div class="assignment-actions">
                    <a href="submit_assignment.php?id=3" class="btn-primary-custom">
                        <i class="bi bi-upload me-1"></i> Submit Now
                    </a>
                    <a href="contact_instructor.php?id=3" class="btn-outline-custom">
                        <i class="bi bi-envelope"></i> Contact Instructor
                    </a>
                </div>
            </div>

            <!-- Assignment 4 - Not Started -->
            <div class="assignment-card" data-status="pending">
                <div class="assignment-header">
                    <h3 class="assignment-title">Plumbing Safety Guidelines</h3>
                    <span class="assignment-status status-not-started">Not Started</span>
                </div>
                
                <div class="assignment-course">
                    <i class="bi bi-book me-1"></i> Plumbing Basics
                </div>
                
                <p class="assignment-description">
                    Create a comprehensive guide on plumbing safety procedures, including tool usage, hazard identification, and emergency protocols.
                </p>
                
                <div class="assignment-meta">
                    <div class="meta-item">
                        <i class="bi bi-calendar"></i>
                        <span>Due: Dec 25, 2024</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-clock"></i>
                        <span>13 days remaining</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-star"></i>
                        <span>Max Marks: 60</span>
                    </div>
                    <div class="meta-item">
                        <i class="bi bi-person"></i>
                        <span>Instructor: Tom Davis</span>
                    </div>
                </div>
                
                <div class="assignment-actions">
                    <a href="submit_assignment.php?id=4" class="btn-primary-custom">
                        <i class="bi bi-play me-1"></i> Start Assignment
                    </a>
                    <a href="assignment_details.php?id=4" class="btn-outline-custom">
                        <i class="bi bi-info-circle"></i> Instructions
                    </a>
                </div>
            </div>
        </div>

        <!-- Empty State (Hidden by default) -->
        <div class="empty-state" id="emptyState" style="display: none;">
            <div class="empty-icon">
                <i class="bi bi-clipboard-x"></i>
            </div>
            <h3 class="empty-title">No Assignments Found</h3>
            <p class="empty-description">
                No assignments match your current filter. Try selecting a different category or check back later for new assignments.
            </p>
            <a href="courses.php" class="btn-primary-custom" style="display: inline-block; width: auto;">
                <i class="bi bi-book me-1"></i> Browse My Courses
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

        // Filter assignments by status
        function filterAssignments(status) {
            const cards = document.querySelectorAll('.assignment-card');
            const tabButtons = document.querySelectorAll('.tab-btn');
            const assignmentsGrid = document.getElementById('assignmentsGrid');
            const emptyState = document.getElementById('emptyState');
            
            // Update active tab
            tabButtons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            
            let visibleCount = 0;
            
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show empty state if no assignments match
            if (visibleCount === 0) {
                assignmentsGrid.style.display = 'none';
                emptyState.style.display = 'block';
            } else {
                assignmentsGrid.style.display = 'grid';
                emptyState.style.display = 'none';
            }
        }

        // Add animation to cards on load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.assignment-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Show welcome message
            setTimeout(() => {
                const pendingCount = document.querySelectorAll('[data-status="pending"]').length;
                const overdueCount = document.querySelectorAll('[data-status="overdue"]').length;
                
                if (overdueCount > 0) {
                    showAlert(`You have ${overdueCount} overdue assignment${overdueCount > 1 ? 's' : ''}. Please submit them as soon as possible.`, 'warning');
                } else if (pendingCount > 0) {
                    showAlert(`You have ${pendingCount} pending assignment${pendingCount > 1 ? 's' : ''}. Good luck with your submissions!`, 'success');
                }
            }, 1000);
        });
    </script>
</body>
</html>