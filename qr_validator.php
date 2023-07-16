<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection configuration
$host = 'localhost';
$username = 'pradip';
$password = 'Sprasa@5782';
$database = 'utec';

// Create a new mysqli instance
$mysqli = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($mysqli->connect_error) {
    die('Database Connection Error: ' . $mysqli->connect_error);
}

// Retrieve the QR code data from the POST request
$qr_code = $_POST['qr_code'];

// Prepare the SQL query to retrieve student information based on the QR code
$sql = "SELECT name, class, roll FROM student WHERE qr_code = ?";

// Prepare the statement
$stmt = $mysqli->prepare($sql);

// Bind the QR code value to the statement
$stmt->bind_param('s', $qr_code);

// Execute the query
$stmt->execute();

// Fetch the result
$result = $stmt->get_result();

// Fetch the student information if the result is found
if ($result->num_rows > 0) {
    $name = $result->fetch_assoc();
    $studentName = $studentInfo['name'];
    $class = $studentInfo['class'];
    $roll = $studentInfo['roll'];
    $status = 'Valid QR Code';
} else {
    $name = 'Unknown';
    $class = 'Unknown';
    $roll = '';
    $status = 'Invalid QR Code';
}

// Close the statement and database connection
$stmt->close();
$mysqli->close();

// Prepare the student information as an associative array
$studentInfo = [
    'name' => $name,
    'class' => $class,
    'roll' => $roll,
    'status' => $status
];

// Send the student information back as JSON
echo json_encode($studentInfo);
?>
