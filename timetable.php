<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Timetable - ERP Solutions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="index.html">Index</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="features.html">Features</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="add_student.html">Add Student</a></li>
                <li><a href="timetable.php">View Timetable</a></li>
                <li><a href="mark_attendance.html">Mark Attendance</a></li>
            </ul>
        </nav>
        <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background: #333;
            color: white;
            padding: 10px 0;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
        section {
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        footer {
            text-align: center;
            padding: 10px;
            background: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
    </header>
    <section>
        <h1>View Timetable</h1>
        <div id="timetable">
            <?php
            // Include database connection
            
$host = '127.0.0.1';  // or 'localhost'
$db = 'erp_db';       // your database name
$user = 'root';       // your database username
$pass = '';           // your database password
$charset = 'utf8mb4'; // character set to use

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
<?php

            $sql = "
                SELECT 
                    days, 
                    `10:00-12:30`, 
                    `2:00-4:30`
                FROM time_table
                ORDER BY FIELD(days, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')
            ";

            try {
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $timetable = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($timetable) {
                    echo '<table border="1">';
                    echo '<tr><th>Day</th><th>10:00-12:30</th><th>2:00-4:30</th></tr>';
                    foreach ($timetable as $row) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['days']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['10:00-12:30']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['2:00-4:30']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else {
                    echo '<p>No timetable data available.</p>';
                }
            } catch(PDOException $e) {
                echo '<p>Server error: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            ?>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 ERP Solutions. All rights reserved.</p>
    </footer>
</body>
</html>
