<?php
$page_title = "SkillPro Institute - Home";
include 'includes/header.php';


$events = [
    ['title'=>'Web Development Workshop', 'date'=>'2025-10-15', 'description'=>'Hands-on PHP & MySQL workshop', 'link'=>'events.php'],
    ['title'=>'Annual Tech Seminar', 'date'=>'2025-11-20', 'description'=>'Latest trends in technology', 'link'=>'events.php']
];

$instructors = [
    ['name'=>'John Doe','expertise'=>'Web Development','bio'=>'10+ years in IT training','contact'=>'john@skillpro.com'],
    ['name'=>'Jane Smith','expertise'=>'Data Science','bio'=>'Expert in AI & Machine Learning','contact'=>'jane@skillpro.com'],
    ['name'=>'Mike Johnson','expertise'=>'Networking','bio'=>'Certified Network Engineer','contact'=>'mike@skillpro.com']
];

$schedules = [
    ['course'=>'PHP Fundamentals','time'=>'Mon & Wed 10:00 - 12:00','link'=>'courses.php'],
    ['course'=>'Data Science Bootcamp','time'=>'Tue & Thu 14:00 - 16:00','link'=>'courses.php']
];
?>

<!-- Hero Section -->
<section class="hero bg-light py-5 text-center">
  <div class="container">
    <h1 class="fw-bold mb-3">Welcome to SkillPro Institute</h1>
    <img src="https://media.istockphoto.com/id/1047699430/photo/overhead-view-on-business-people-around-desk.jpg?s=612x612&w=0&k=20&c=mw7GAXTEOAQ36taGxzo8DPE3CLOpG7Zu466FCxeQJL0="
         alt="SkillPro Institute" class="img-fluid rounded shadow mb-3" width="1000" height="500">
    <p class="lead mb-4">Upgrade your skills with our professional IT training courses.</p>
    <a href="courses.php" class="btn btn-primary btn-lg">Browse Courses</a>
  </div>
</section>

<!-- Why Choose Us -->
<section class="container mt-5">
  <h2 class="text-center mb-4">Why Choose Us?</h2>
  <div class="row text-center g-4">
    <div class="col-md-4">
      <div class="card shadow-sm h-100 border-0 p-3">
        <div class="card-body">
          <h4 class="card-title text-primary">Expert Instructors</h4>
          <p class="card-text">Learn from highly qualified and experienced trainers.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100 border-0 p-3">
        <div class="card-body">
          <h4 class="card-title text-success">Flexible Learning</h4>
          <p class="card-text">Study at your own pace with our online/offline programs.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100 border-0 p-3">
        <div class="card-body">
          <h4 class="card-title text-warning">Certified Programs</h4>
          <p class="card-text">Earn recognized certificates to boost your career opportunities.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Optional CSS -->
<style>
.card { transition: transform 0.2s, box-shadow 0.2s; }
.card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
</style>
<?php include 'includes/footer.php'; ?>
