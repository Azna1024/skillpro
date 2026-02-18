<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results - SkillPro Institute</title>
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

        /* ===== Summary Cards ===== */
        .summary-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: all 0.3s;
            border-top: 4px solid var(--primary-color);
        }

        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .summary-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .summary-number {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .summary-label {
            color: var(--text-light);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .summary-card.excellent {
            border-top-color: var(--accent-color);
        }

        .summary-card.excellent .summary-icon {
            color: var(--accent-color);
        }

        .summary-card.good {
            border-top-color: #17a2b8;
        }

        .summary-card.good .summary-icon {
            color: #17a2b8;
        }

        .summary-card.average {
            border-top-color: var(--warning-color);
        }

        .summary-card.average .summary-icon {
            color: var(--warning-color);
        }

        /* ===== Results Table Container ===== */
        .results-container {
            background: white;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .results-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px 25px;
        }

        .results-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0;
        }

        /* ===== Results Table ===== */
        .results-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .results-table th {
            background: var(--background-color);
            padding: 18px 20px;
            font-weight: 700;
            color: var(--text-dark);
            border: none;
            text-align: left;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .results-table td {
            padding: 18px 20px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        .results-table tbody tr:hover {
            background: #f8f9fa;
        }

        .results-table tbody tr:last-child td {
            border-bottom: none;
        }

        .course-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .course-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 1rem;
        }

        .exam-name {
            color: var(--text-light);
            font-size: 0.85rem;
        }

        .marks-cell {
            text-align: center;
            font-weight: 600;
        }

        .marks-obtained {
            font-size: 1.1rem;
            color: var(--text-dark);
        }

        .marks-total {
            font-size: 0.85rem;
            color: var(--text-light);
        }

        .percentage-cell {
            text-align: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .grade-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 700;
            text-align: center;
            min-width: 70px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .grade-a {
            background: #d4edda;
            color: #155724;
        }

        .grade-b {
            background: #cce7ff;
            color: #0056b3;
        }

        .grade-c {
            background: #fff3cd;
            color: #856404;
        }

        .grade-d {
            background: #f8d7da;
            color: #721c24;
        }

        .grade-f {
            background: #f8d7da;
            color: #721c24;
        }

        .date-cell {
            color: var(--text-light);
            font-size: 0.9rem;
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

        .alert-info {
            background: #cce7ff;
            color: #0056b3;
        }

        /* ===== GPA Section ===== */
        .gpa-section {
            background: white;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            padding: 25px;
            text-align: center;
        }

        .gpa-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        .gpa-value {
            font-size: 3rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .gpa-label {
            color: var(--text-light);
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .gpa-status {
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            display: inline-block;
        }

        .gpa-excellent {
            background: #d4edda;
            color: #155724;
        }

        .gpa-good {
            background: #cce7ff;
            color: #0056b3;
        }

        .gpa-average {
            background: #fff3cd;
            color: #856404;
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
            
            .summary-row {
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }
            
            .page-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .results-table {
                font-size: 0.9rem;
            }
            
            .results-table th,
            .results-table td {
                padding: 12px 8px;
            }
            
            .course-name {
                font-size: 0.9rem;
            }
            
            .exam-name {
                font-size: 0.8rem;
            }
        }

        @media(max-width: 480px) {
            .summary-row {
                grid-template-columns: 1fr;
            }
            
            .results-table th:nth-child(4),
            .results-table td:nth-child(4) {
                display: none;
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
            <li><a href="exams.php"><i class="bi bi-pencil-square"></i><span>Exams</span></a></li>
            <li><a href="results.php" class="active"><i class="bi bi-bar-chart-line"></i><span>Results</span></a></li>
            <li><a href="../logout.php"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title"><i class="bi bi-bar-chart-line me-2"></i>My Results</h1>
                <p class="page-subtitle">View your exam results and academic performance</p>
            </div>
            <a href="../logout.php" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>

        <!-- Alert Messages -->
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>Good News!</strong> Your recent exam results have been published. Check them below.
        </div>

        <!-- Summary Cards -->
        <div class="summary-row">
            <div class="summary-card excellent">
                <div class="summary-icon">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div class="summary-number">5</div>
                <div class="summary-label">Exams Completed</div>
            </div>
            
            <div class="summary-card good">
                <div class="summary-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div class="summary-number">4</div>
                <div class="summary-label">Exams Passed</div>
            </div>
            
            <div class="summary-card average">
                <div class="summary-icon">
                    <i class="bi bi-percent"></i>
                </div>
                <div class="summary-number">78.5%</div>
                <div class="summary-label">Average Score</div>
            </div>
            
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="bi bi-award-fill"></i>
                </div>
                <div class="summary-number">3.2</div>
                <div class="summary-label">Current GPA</div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="results-container">
            <div class="results-header">
                <h3 class="results-title"><i class="bi bi-table me-2"></i>Detailed Results</h3>
            </div>
            
            <table class="results-table">
                <thead>
                    <tr>
                        <th>Course & Exam</th>
                        <th>Marks</th>
                        <th>Percentage</th>
                        <th>Grade</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="course-info">
                                <span class="course-name">Web Development with PHP</span>
                                <span class="exam-name">Final Examination</span>
                            </div>
                        </td>
                        <td class="marks-cell">
                            <span class="marks-obtained">85</span>
                            <span class="marks-total">/ 100</span>
                        </td>
                        <td class="percentage-cell">85%</td>
                        <td>
                            <span class="grade-badge grade-a">A</span>
                        </td>
                        <td class="date-cell">Dec 15, 2024</td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div class="course-info">
                                <span class="course-name">ICT Fundamentals</span>
                                <span class="exam-name">Mid-term Assessment</span>
                            </div>
                        </td>
                        <td class="marks-cell">
                            <span class="marks-obtained">68</span>
                            <span class="marks-total">/ 75</span>
                        </td>
                        <td class="percentage-cell">91%</td>
                        <td>
                            <span class="grade-badge grade-a">A</span>
                        </td>
                        <td class="date-cell">Dec 10, 2024</td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div class="course-info">
                                <span class="course-name">Hotel Management Basics</span>
                                <span class="exam-name">Online Quiz</span>
                            </div>
                        </td>
                        <td class="marks-cell">
                            <span class="marks-obtained">42</span>
                            <span class="marks-total">/ 50</span>
                        </td>
                        <td class="percentage-cell">84%</td>
                        <td>
                            <span class="grade-badge grade-b">B</span>
                        </td>
                        <td class="date-cell">Dec 5, 2024</td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div class="course-info">
                                <span class="course-name">Plumbing Basics</span>
                                <span class="exam-name">Practical Assessment</span>
                            </div>
                        </td>
                        <td class="marks-cell">
                            <span class="marks-obtained">45</span>
                            <span class="marks-total">/ 60</span>
                        </td>
                        <td class="percentage-cell">75%</td>
                        <td>
                            <span class="grade-badge grade-b">B</span>
                        </td>
                        <td class="date-cell">Nov 28, 2024</td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div class="course-info">
                                <span class="course-name">Web Development with PHP</span>
                                <span class="exam-name">Module 1 Quiz</span>
                            </div>
                        </td>
                        <td class="marks-cell">
                            <span class="marks-obtained">18</span>
                            <span class="marks-total">/ 25</span>
                        </td>
                        <td class="percentage-cell">72%</td>
                        <td>
                            <span class="grade-badge grade-b">B</span>
                        </td>
                        <td class="date-cell">Nov 20, 2024</td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div class="course-info">
                                <span class="course-name">ICT Fundamentals</span>
                                <span class="exam-name">Unit Test 1</span>
                            </div>
                        </td>
                        <td class="marks-cell">
                            <span class="marks-obtained">22</span>
                            <span class="marks-total">/ 30</span>
                        </td>
                        <td class="percentage-cell">73%</td>
                        <td>
                            <span class="grade-badge grade-b">B</span>
                        </td>
                        <td class="date-cell">Nov 15, 2024</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- GPA Section -->
        <div class="gpa-section">
            <h3 class="gpa-title">Overall Academic Performance</h3>
            <div class="gpa-value">3.2</div>
            <div class="gpa-label">Current GPA</div>
            <div class="gpa-status gpa-good">
                <i class="bi bi-graph-up-arrow me-1"></i>
                Good Standing
            </div>
        </div>
    </div>
</body>
</html>