<?php
header("Content-Type: application/json");
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $student_id = $_GET['student_id'];

    if (empty($student_id)) {
        http_response_code(400);
        echo json_encode(['msg' => 'Student ID is required']);
        exit();
    }

    $sql = "
        SELECT c.name, c.start_time, c.end_time, c.day_of_week
        FROM classes c
        JOIN timetable t ON c.id = t.class_id
        WHERE t.student_id = :student_id
        ORDER BY FIELD(c.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), c.start_time
    ";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute(['student_id' => $student_id]);
        $timetable = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($timetable);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['msg' => 'Server error: ' . $e->getMessage()]);
    }
}
?>
