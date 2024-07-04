<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "dept_res_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create reservations table if it does not exist
$sql = "CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    room VARCHAR(50) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reservation'])) {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'];
    $today = date("Y-m-d");

    // Check if the selected date is in the past
    if ($date < $today) {
        die("You cannot select a past date for reservation.");
    }

    $reservations = $_POST['reservation'];

    foreach ($reservations as $reservation) {
        list($room, $time) = explode(',', $reservation);
        $sql = "INSERT INTO reservations (user_id, room, date, time) VALUES ('$user_id', '$room', '$date', '$time')";
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    echo "Room reserved successfully!";
    header("Location: reserve.html");
    exit();
}

// Handle AJAX request for fetching reservations
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['date'])) {
    $date = $_GET['date'];
    $sql = "SELECT reservations.room, reservations.time, users.name FROM reservations JOIN users ON reservations.user_id = users.id WHERE date='$date'";
    $result = $conn->query($sql);

    $bookedSlots = [];
    while ($row = $result->fetch_assoc()) {
        $bookedSlots[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($bookedSlots);
    exit();
}

$conn->close();
?>
