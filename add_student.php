<?php
header("Content-Type: application/json");
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $reg_number = $_POST['reg_number'];  // New field for registration number

    if (empty($name) || empty($email) || empty($reg_number)) {
        http_response_code(400);
        echo json_encode(['msg' => 'Please enter all fields']);
        exit();
    }

    $sql = "INSERT INTO students (name, email, reg_number) VALUES (:name, :email, :reg_number)";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute(['name' => $name, 'email' => $email, 'reg_number' => $reg_number]);
        http_response_code(201);
        echo json_encode(['msg' => 'Student added successfully']);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['msg' => 'Server error: ' . $e->getMessage()]);
    }
}
?>
