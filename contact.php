<?php
header("Content-Type: application/json");
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the input data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo json_encode(['msg' => 'Please enter all fields']);
        exit();
    }

    // Insert the data into the database
    $sql = "INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute(['name' => $name, 'email' => $email, 'message' => $message]);
        http_response_code(201);
        echo json_encode(['msg' => 'Message received']);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['msg' => 'Server error: ' . $e->getMessage()]);
    }
}
?>
