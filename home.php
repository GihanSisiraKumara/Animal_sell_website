<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "petdatabase";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT pet_name, gender, phone, message, image FROM petdata";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet List</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            overflow: hidden;
        }
        .pet-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .pet-card {
            background: white;
            width: 30%;
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .pet-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .pet-card h3 {
            color: #333;
            margin: 10px 0;
        }
        .pet-card p {
            color: #666;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Our Lovely Pets</h1>
    <div class="pet-list">

        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<div class='pet-card'>";
                echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Pet Image'>";
                echo "<h3>" . htmlspecialchars($row['pet_name']) . "</h3>";
                echo "<p>Gender: " . htmlspecialchars($row['gender']) . "</p>";
                echo "<p>Phone: " . htmlspecialchars($row['phone']) . "</p>";
                echo "<p>Message: " . htmlspecialchars($row['message']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No pets added yet!</p>";
        }
        ?>

    </div>
</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
