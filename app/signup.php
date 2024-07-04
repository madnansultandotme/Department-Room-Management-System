<?php
session_start();
$conn = new mysqli("localhost", "root", "");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS dept_res_system";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db("dept_res_system");

// Create users table if it does not exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

// Create reservations table if it does not exist
$sql = "CREATE TABLE IF NOT EXISTS reserve (
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

// Handle signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_id'] = $conn->insert_id;
        header("Location: reserve.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
