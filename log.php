<?php
session_start(); // Start the session

require 'db1.php';

if(isset($_POST['uname']) && isset($_POST['upswd'])) // Check if both username and password are set in POST data
{
    $username = $_POST['uname'];
    $password = $_POST['upswd'];

    // Sanitize user input to prevent SQL injection (consider using prepared statements)
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM register WHERE uname1='$username' AND upswd1='$password'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

    if($count > 0)
    {
        // Start a session and store username in session variable
        $_SESSION['username'] = $username;

        // Redirect to home page
        header("Location: home1.html");
        exit; // Ensure that script stops execution after redirection
    }
    else
    {
        echo "Login failed..!";
    }
}
else
{
    echo "No values submitted";
}
?>
