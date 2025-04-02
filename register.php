<?php
// Database connection details
$host = "sql113.infinityfree.com";
$username = "if0_38632840";
$password = "xIw72eCPFLD";
$database = "if0_38632840_mlearn_db";

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed"]));
}

// Get user input from the form (sent via POST)
$studentNumber = $_POST['studentNumber'] ?? '';
$plainPassword = $_POST['password'] ?? '';

// Validate input
if (empty($studentNumber) || empty($plainPassword)) {
    die(json_encode(["success" => false, "message" => "All fields are required"]));
}

// Check if the student number already exists
$checkQuery = "SELECT * FROM students WHERE student_number = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("s", $studentNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Student number already exists!"]);
    exit;
}

// Hash the password for security
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO students (STUDENT_NUMBER, PASSWORD) VALUES (?, ?)");
$stmt->bind_param("ss", $studentNumber, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Account created successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
