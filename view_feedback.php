<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "campaign_feedback";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$limit = 10; 
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$start_from = ($page - 1) * $limit;

$sql = "SELECT * FROM feedback ORDER BY submission_date DESC LIMIT $start_from, $limit";
$result= $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$sql_total = "SELECT COUNT(id) AS total FROM feedback";
$total_result = $conn->query($sql_total);

if (!$total_result) {
    die("Query failed: " . $conn->error);
}

$total_rows = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <header>
        <h1>GEN-Z in Kenya</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="feedback_form.html">Give Feedback</a></li>
                <li><a href="view_feedback.php">View Feedback</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="table-container">
            <h2>Feedback Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Feedback</th>
                        <th>Rating</th>
                        <th>Submission Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $name = isset($row["name"]) ? htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8') : '';
                            $email = isset($row["email"]) ? htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8') : '';
                            $feedback = isset($row["feedback"]) ? htmlspecialchars($row["feedback"], ENT_QUOTES, 'UTF-8') : '';
                            $rating = isset($row["rating"]) ? htmlspecialchars($row["rating"], ENT_QUOTES, 'UTF-8') : '';
                            $submission_date = isset($row["submission_date"]) ? htmlspecialchars($row["submission_date"], ENT_QUOTES, 'UTF-8') : '';
                            
                            echo "<tr>
                                    <td>$name</td>
                                    <td>$email</td>
                                    <td>$feedback</td>
                                    <td>$rating</td>
                                    <td>$submission_date</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php
                for ($i=1; $i<=$total_pages; $i++) {
                    echo "<a href='view_feedback.php?page=".$i."'";
                    if ($i==$page)  echo " class='active'";
                    echo ">".$i."</a> ";
                }
                ?>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 GEN-Z Kenya. All rights reserved.</p>
    </footer>
</body>
</html>
