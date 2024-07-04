<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dept_res_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            // Redirect to reserve.html
            echo "<script>
                sessionStorage.setItem('user_name', '" . addslashes($user['name']) . "');
                window.location.href = 'reserve.html';
              </script>";
        } else {
            echo "Invalid Password";
        }
    } else {
        echo "No user found with this email";
    }
}

$conn->close();
?>
