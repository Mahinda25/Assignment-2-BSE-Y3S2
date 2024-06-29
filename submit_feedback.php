<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campaign_feedback";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$feedback = $_POST['feedback'];
$rating = $_POST['rating'];
$submission_date = date('Y-m-d H:i:s');

$sql = "INSERT INTO feedback (name, email, feedback, rating, submission_date) 
        VALUES ('$name', '$email', '$feedback', '$rating', '$submission_date')";

if ($conn->query($sql) === TRUE) {
    echo "Feedback submitted successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

