<?php
$page_title = "Events Calendar";
include __DIR__ . '/includes/header.php';
include __DIR__ . '/config/database.php';

// ------------------------
// Create DB connection
// ------------------------
$database = new Database();
$db = $database->getConnection();

// ------------------------
// Fetch events from DB
// ------------------------
try {
    $stmt = $db->query("
        SELECT e.id, e.title, e.description, e.location, e.start_dt, e.end_dt,
               e.is_all_day, e.rrule,
               c.name AS calendar_name, c.color AS calendar_color
        FROM events e
        LEFT JOIN calendars c ON e.calendar_id = c.id
        ORDER BY e.start_dt ASC
    ");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching events: " . $e->getMessage());
}

// ------------------------
// Group events by date
// ------------------------
$events_by_date = [];
foreach ($events as $ev) {
    $date = date('Y-m-d', strtotime($ev['start_dt']));
    $events_by_date[$date][] = $ev;
}

// ------------------------
// Determine month to display
// ------------------------
if (isset($_GET['year'], $_GET['month'])) {
    $year = (int)$_GET['year'];
    $month = (int)$_GET['month'];
} elseif (!empty($events)) {
    $first_event_date = new DateTime($events[0]['start_dt']);
    $year = (int)$first_event_date->format('Y');
    $month = (int)$first_event_date->format('m');
} else {
    $year = date('Y');
    $month = date('m');
}

$first_day = new DateTime("$year-$month-01");
$days_in_month = (int)$first_day->format('t');
$start_weekday = (int)$first_day->format('N'); // 1=Mon ... 7=Sun

// ------------------------
// Previous / Next month
// ------------------------
$prev_month = clone $first_day;
$prev_month->modify('-1 month');
$next_month = clone $first_day;
$next_month->modify('+1 month');
?>
<section class="bg-primary text-white py-5 text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Events Calendar</h1>
        <p class="lead mb-0">View all workshops, webinars, and training sessions by month.</p>
        <div class="mt-3">
            <a href="?year=<?= $prev_month->format('Y') ?>&month=<?= $prev_month->format('m') ?>" class="btn btn-outline-primary">&laquo; Previous</a>
            <span class="mx-3 fw-bold"><?= $first_day->format('F Y') ?></span>
            <a href="?year=<?= $next_month->format('Y') ?>&month=<?= $next_month->format('m') ?>" class="btn btn-outline-primary">Next &raquo;</a>
        </div>
    </div>
</section>


<section class="container my-5">
<div class="calendar border rounded overflow-hidden">
    <div class="row bg-dark text-white text-center fw-bold">
        <div class="col py-2">Mon</div>
        <div class="col py-2">Tue</div>
        <div class="col py-2">Wed</div>
        <div class="col py-2">Thu</div>
        <div class="col py-2">Fri</div>
        <div class="col py-2">Sat</div>
        <div class="col py-2">Sun</div>
    </div>

    <div class="row g-0">
<?php
$current_day = 1;
$printed_days = 0;

// Empty cells before first day
for ($i = 1; $i < $start_weekday; $i++) {
    echo '<div class="col border" style="min-height:120px;"></div>';
    $printed_days++;
}

// Print days
while ($current_day <= $days_in_month) {
    $date_str = sprintf("%04d-%02d-%02d", $year, $month, $current_day);
    echo '<div class="col border p-2" style="min-height:120px;">';
    echo '<strong>' . $current_day . '</strong><br>';

    if (!empty($events_by_date[$date_str])) {
        foreach ($events_by_date[$date_str] as $ev) {
            $color = htmlspecialchars($ev['calendar_color'] ?? '#1976D2');
            echo '<span class="badge mb-1 d-block text-truncate" style="background-color:' . $color . '; color:#fff;" title="' . htmlspecialchars($ev['title']) . '">';
            echo htmlspecialchars($ev['title']);
            if ($ev['is_all_day']) echo ' (All Day)';
            echo '</span>';
        }
    }

    echo '</div>';
    $current_day++;
    $printed_days++;
    if ($printed_days % 7 == 0) echo '</div><div class="row g-0">';
}

// Fill remaining cells
while ($printed_days % 7 != 0) {
    echo '<div class="col border" style="min-height:120px;"></div>';
    $printed_days++;
}
?>
    </div>
</div>
</section>

<style>
.calendar .col { position: relative; }
.calendar .badge { font-size: 0.75rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
</style>

<?php include __DIR__ . '/includes/footer.php'; ?>
