<?php
require 'db1.php';

// Check if form data is set
if (isset($_POST['uname1']) && isset($_POST['email']) && isset($_POST['upswd1']) && isset($_POST['upswd2'])) {
    $uname1 = $_POST['uname1'];
    $email = $_POST['email'];
    $upswd1 = $_POST['upswd1'];
    $upswd2 = $_POST['upswd2'];

    // Check if any field is empty
    if (!empty($uname1) && !empty($email) && !empty($upswd1) && !empty($upswd2)) {
        $SELECT = "SELECT email FROM register WHERE email = ? LIMIT 1";
        $INSERT = "INSERT INTO register (uname1, email, upswd1, upswd2) VALUES (?, ?, ?, ?)";

        // Prepare statement for SELECT
        if ($stmt = $conn->prepare($SELECT)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $rnum = $stmt->num_rows;

            // Checking if email already exists
            if ($rnum == 0) {
                $stmt->close();
                
                // Prepare statement for INSERT
                if ($stmt = $conn->prepare($INSERT)) {
                    $stmt->bind_param("ssss", $uname1, $email, $upswd1, $upswd2);
                    $stmt->execute();
                    echo "New record inserted successfully";
                } else {
                    die('Insert Prepare failed: ' . $conn->error);
                }
            } else {
                echo "Someone already registered using this email";
            }
            $stmt->close();
        } else {
            die('Select Prepare failed: ' . $conn->error);
        }
    } else {
        echo "All fields are required";
    }
} else {
    echo "Form data is missing";
}

$conn->close();
?>
