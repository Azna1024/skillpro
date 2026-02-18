<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exams - SkillPro Institute</title>
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
        }

        /* ===== Exam Cards ===== */
        .exams-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
        }

        .exam-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s;
            border-left: 5px solid var(--primary-color);
        }

        .exam-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .exam-card.upcoming {
            border-left-color: var(--warning-color);
        }

        .exam-card.completed {
            border-left-color: var(--accent-color);
        }

        .exam-card.missed {
            border-left-color: var(--danger-color);
        }

        /* Exam Header */
        .exam-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .exam-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--text-dark);
            margin: 0;
            flex: 1;
        }

        .exam-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-upcoming {
            background: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-missed {
            background: #f8d7da;
            color: #721c24;
        }

        .status-in-progress {
            background: #cce7ff;
            color: #0056b3;
        }

        /* Exam Content */
        .exam-course {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .exam-description {
            color: var(--text-light);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .exam-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background: var(--background-color);
            border-radius: 10px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .detail-item i {
            color: var(--primary-color);
        }

        .detail-item strong {
            color: var(--text-dark);
        }

        /* Alert Boxes */
        .exam-alert {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
            color: #856404;
            font-size: 0.9rem;
        }

        .exam-alert.danger {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .exam-alert.success {
            background: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        /* Exam Actions */
        .exam-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 12px 24px;
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
        }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 10px 20px;
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

        .btn-success {
            background: var(--accent-color);
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            color: white;
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
            
            .exams-grid {
                grid-template-columns: 1fr;
            }
            
            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .exam-actions {
                flex-direction: column;
            }
            
            .exam-details {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">SkillPro</div>
        <ul>
            <li><a href="profile.php"><i class="bi bi-person-circle"></i><span>Profile</span></a></li>
            <li><a href="my_courses.php"><i class="bi bi-book"></i><span>My Courses</span></a></li>
            <li><a href="assignments.php"><i class="bi bi-journal-text"></i><span>Assignments</span></a></li>
            <li><a href="exams.php" class="active"><i class="bi bi-pencil-square"></i><span>Exams</span></a></li>
            <li><a href="results.php"><i class="bi bi-bar-chart-line"></i><span>Results</span></a></li>
            <li><a href="../logout.php"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title"><i class="bi bi-pencil-square me-2"></i>My Exams</h1>
                <p class="page-subtitle">View and manage your upcoming and completed exams</p>
            </div>
            <a href="../logout.php" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

        <!-- Alert Messages -->
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Reminder:</strong> You have 2 upcoming exams this week. Make sure to prepare well!
        </div>

        <!-- Exams Grid -->
        <div class="exams-grid">
            <!-- Upcoming Exam 1 -->
            <div class="exam-card upcoming">
                <div class="exam-header">
                    <h3 class="exam-title">Web Development Final Exam</h3>
                    <span class="exam-status status-upcoming">Upcoming</span>
                </div>
                
                <div class="exam-course">
                    <i class="bi bi-book me-1"></i> Web Development with PHP
                </div>
                
                <p class="exam-description">
                    Comprehensive final examination covering HTML, CSS, JavaScript, PHP, and database integration. 
                    Focus on practical web development skills and problem-solving.
                </p>

                <div class="exam-alert">
                    <i class="bi bi-clock-fill me-1"></i>
                    <strong>Exam starts in 2 days</strong> - Make sure you're prepared!
                </div>
                
                <div class="exam-details">
                    <div class="detail-item">
                        <i class="bi bi-calendar"></i>
                        <span><strong>Date:</strong> Dec 20, 2024</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-clock"></i>
                        <span><strong>Time:</strong> 10:00 AM</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-hourglass"></i>
                        <span><strong>Duration:</strong> 3 hours</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-geo-alt"></i>
                        <span><strong>Venue:</strong> Lab 2, Kandy Branch</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-star"></i>
                        <span><strong>Total Marks:</strong> 100</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-percent"></i>
                        <span><strong>Pass Mark:</strong> 50%</span>
                    </div>
                </div>
                
                <div class="exam-actions">
                    <a href="exam_guidelines.php?id=1" class="btn-primary-custom">
                        <i class="bi bi-info-circle me-1"></i> View Guidelines
                    </a>
                    <a href="study_materials.php?course=1" class="btn-outline-custom">
                        <i class="bi bi-book"></i> Study Materials
                    </a>
                </div>
            </div>

            <!-- Upcoming Exam 2 -->
            <div class="exam-card upcoming">
                <div class="exam-header">
                    <h3 class="exam-title">ICT Fundamentals Assessment</h3>
                    <span class="exam-status status-upcoming">Upcoming</span>
                </div>
                
                <div class="exam-course">
                    <i class="bi bi-book me-1"></i> ICT Fundamentals
                </div>
                
                <p class="exam-description">
                    Mid-term assessment covering basic computer operations, MS Office applications, and internet usage. 
                    Theory and practical components included.
                </p>

                <div class="exam-alert">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    <strong>Exam tomorrow</strong> - Final preparation time!
                </div>
                
                <div class="exam-details">
                    <div class="detail-item">
                        <i class="bi bi-calendar"></i>
                        <span><strong>Date:</strong> Dec 19, 2024</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-clock"></i>
                        <span><strong>Time:</strong> 2:00 PM</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-hourglass"></i>
                        <span><strong>Duration:</strong> 2 hours</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-geo-alt"></i>
                        <span><strong>Venue:</strong> Room 101, Colombo Branch</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-star"></i>
                        <span><strong>Total Marks:</strong> 75</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-percent"></i>
                        <span><strong>Pass Mark:</strong> 40%</span>
                    </div>
                </div>
                
                <div class="exam-actions">
                    <a href="exam_guidelines.php?id=2" class="btn-primary-custom">
                        <i class="bi bi-info-circle me-1"></i> View Guidelines
                    </a>
                    <a href="practice_tests.php?course=2" class="btn-outline-custom">
                        <i class="bi bi-play-circle"></i> Practice Test
                    </a>
                </div>
            </div>

            <!-- Completed Exam -->
            <div class="exam-card completed">
                <div class="exam-header">
                    <h3 class="exam-title">Hotel Management Quiz</h3>
                    <span class="exam-status status-completed">Completed</span>
                </div>
                
                <div class="exam-course">
                    <i class="bi bi-book me-1"></i> Hotel Management Basics
                </div>
                
                <p class="exam-description">
                    Online quiz covering hospitality principles, customer service standards, and basic hotel operations management.
                </p>

                <div class="exam-alert success">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    <strong>Exam completed successfully!</strong> Results are being processed.
                </div>
                
                <div class="exam-details">
                    <div class="detail-item">
                        <i class="bi bi-calendar-check"></i>
                        <span><strong>Completed:</strong> Dec 15, 2024</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-clock-history"></i>
                        <span><strong>Time Taken:</strong> 45 minutes</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-hourglass"></i>
                        <span><strong>Duration:</strong> 1 hour</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-laptop"></i>
                        <span><strong>Type:</strong> Online Quiz</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-star"></i>
                        <span><strong>Total Marks:</strong> 50</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-hourglass-split"></i>
                        <span><strong>Status:</strong> Under Review</span>
                    </div>
                </div>
                
                <div class="exam-actions">
                    <a href="exam_review.php?id=3" class="btn-success">
                        <i class="bi bi-eye me-1"></i> View Submission
                    </a>
                    <a href="results.php" class="btn-outline-custom">
                        <i class="bi bi-graph-up"></i> Check Results
                    </a>
                </div>
            </div>

            <!-- Missed Exam -->
            <div class="exam-card missed">
                <div class="exam-header">
                    <h3 class="exam-title">Plumbing Safety Test</h3>
                    <span class="exam-status status-missed">Missed</span>
                </div>
                
                <div class="exam-course">
                    <i class="bi bi-book me-1"></i> Plumbing Basics
                </div>
                
                <p class="exam-description">
                    Safety assessment covering tool usage, hazard identification, and emergency procedures in plumbing work.
                </p>

                <div class="exam-alert danger">
                    <i class="bi bi-x-circle-fill me-1"></i>
                    <strong>Exam missed!</strong> Contact your instructor to discuss makeup options.
                </div>
                
                <div class="exam-details">
                    <div class="detail-item">
                        <i class="bi bi-calendar-x"></i>
                        <span><strong>Was Due:</strong> Dec 10, 2024</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-clock"></i>
                        <span><strong>Time:</strong> 9:00 AM</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-hourglass"></i>
                        <span><strong>Duration:</strong> 1.5 hours</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-geo-alt"></i>
                        <span><strong>Venue:</strong> Workshop, Colombo Branch</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-star"></i>
                        <span><strong>Total Marks:</strong> 60</span>
                    </div>
                    <div class="detail-item">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span><strong>Status:</strong> Makeup Required</span>
                    </div>
                </div>
                
                <div class="exam-actions">
                    <a href="contact_instructor.php?course=4" class="btn-primary-custom">
                        <i class="bi bi-person me-1"></i> Contact Instructor
                    </a>
                    <a href="makeup_request.php?exam=4" class="btn-outline-custom">
                        <i class="bi bi-calendar-plus"></i> Request Makeup
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>