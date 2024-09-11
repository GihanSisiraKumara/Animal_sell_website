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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">
    <link rel="stylesheet" href="css/style2.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            padding-top: 80px; /* Adjust this based on your nav height */
        }
        header.header {
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            background-color: white;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .container {
            width: 100%;
            margin: auto;
            overflow: hidden;
            padding-top: 20px; /* Padding to prevent flush content */
        }
        .pet-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .pet-card {
    background: white;
    width: 20%;
    margin: 20px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    height: auto; /* Allow the card to expand based on content */
    overflow: hidden; /* Ensure content stays within the card */
}

.pet-card img {
    max-width: 100%;
    max-height: 200px; /* Restrict the image height to prevent overflow */
    height: auto;
    border-radius: 8px;
    object-fit: cover; /* Ensure the image fits within the set size */
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

<!--==================== HEADER ====================-->
<header class="header" id="header">
         <nav class="nav container">
            <a href="#" class="nav__logo">Logo</a>

            <div class="nav__menu" id="nav-menu">
               <ul class="nav__list">
                  <li class="nav__item">
                     <a href="#" class="nav__link">Home</a>
                  </li>

                  <li class="nav__item">
                     <a href="#" class="nav__link">About Us</a>
                  </li>

                  <li class="nav__item">
                     <a href="#" class="nav__link">Services</a>
                  </li>

                  <li class="nav__item">
                     <a href="#" class="nav__link">Featured</a>
                  </li>

                  <li class="nav__item">
                     <a href="#" class="nav__link">Contact Me</a>
                  </li>
               </ul>

               <div class="nav__close" id="nav-close">
                  <i class="ri-close-line"></i>
               </div>
            </div>

            <div class="nav__actions">
               <i class="ri-search-line nav__search" id="search-btn"></i>
               <i class="ri-user-line nav__login" id="login-btn"></i>
               <div class="nav__toggle" id="nav-toggle">
                  <i class="ri-menu-line"></i>
               </div>
            </div>
         </nav>
</header>

<!--==================== MAIN ====================-->
<div class="container">
   
    <div class="pet-list">

        <?php
        if ($result->num_rows > 0) {
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

<script src="js/main1.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
