<?php
header("Content-Type: application/json");
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg_number = $_POST['reg_number'];
    
    $attendance_date = $_POST['attendance_date'];

    if (empty($reg_number) || empty($attendance_date)) {
        http_response_code(400);
        echo json_encode(['msg' => 'Please enter all fields']);
        exit();
    }

    $sql = "SELECT id FROM students WHERE reg_number = :reg_number";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute(['reg_number' => $reg_number]);
        $student = $stmt->fetch();
        if ($student) {
            $student_id = $student['id'];
            $sql = "INSERT INTO attendance (student_id, attendance_date, status) VALUES (:student_id, :attendance_date, 'Present')";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'student_id' => $student_id,
                
                'attendance_date' => $attendance_date
            ]);
            http_response_code(201);
            echo json_encode(['msg' => 'Attendance marked successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['msg' => 'Student not found']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['msg' => 'Server error: ' . $e->getMessage()]);
    }
}
?>
