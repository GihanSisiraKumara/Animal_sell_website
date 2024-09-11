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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $pet_name = $_POST['name'];
    $gender = $_POST['email']; // Assuming gender is collected in this field
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    
    // Handle the image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);

        // Move the uploaded file to the server
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Prepare SQL query to insert data
            $sql = "INSERT INTO petdata (pet_name, gender, phone, message, image) VALUES (?, ?, ?, ?, ?)";
            
            // Prepare statement
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                // Output SQL preparation error
                die("Error preparing statement: " . $conn->error);
            }
            
            // Bind parameters
            $stmt->bind_param("sssss", $pet_name, $gender, $phone, $message, $image);
            
            // Execute the query
            if ($stmt->execute()) {
                // Redirect to home.php after successful insertion
                header("Location: home.php");
                exit(); // Ensure that no further code is executed
            } else {
                echo "Error: " . $stmt->error;
            }
            
            // Close statement
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "No file uploaded or upload error.";
    }
}

// Close connection
$conn->close();
?>





<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Form</title>
    <link rel="stylesheet" href="css/style1.css" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div class="container">
      <span class="big-circle"></span>
      <img src="img/shape.png" class="square" alt="" />
      <div class="form">
        <div class="contact-info">
          <h3 class="title">Let's Add Your Pet</h3>
          <p class="text">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe
            dolorum adipisci recusandae praesentium dicta!
          </p>

          <div class="info">
            <div class="information">
              <img src="img/location.png" class="icon" alt="" />
              <p>92 Cherry Drive Uniondale, NY 11553</p>
            </div>
            <div class="information">
              <img src="img/email.png" class="icon" alt="" />
              <p>lorem@ipsum.com</p>
            </div>
            <div class="information">
              <img src="img/phone.png" class="icon" alt="" />
              <p>123-456-789</p>
            </div>
          </div>

          <div class="social-media">
            <p>Connect with us :</p>
            <div class="social-icons">
              <a href="#">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="#">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="contact-form">
          <span class="circle one"></span>
          <span class="circle two"></span>

          <form action="addpet.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <h3 class="title">Add your Pet</h3>
            <div class="input-container">
              <input type="text" name="name" class="input" />
              <label for="">Pet Name</label>
              <span>Username</span>
            </div>
            <div class="input-container">
              <input type="text" name="email" class="input" />
              <label for="">Gender</label>
              <span>Email</span>
            </div>
            <div class="input-container">
              <input type="tel" name="phone" class="input" />
              <label for="">Phone</label>
              <span>Phone</span>
            </div>
            <div class="input-container textarea">
              <textarea name="message" class="input"></textarea>
              <label for="">Message</label>
              <span>Message</span>
            </div>
            <div class="">
             <input type="file" name="image" class="input" accept="image/*" />
             <label for="image"></label>
             <span></span>
            </div>
             <br>
            <input type="submit" value="Add" class="btn" />
          </form>
        </div>
      </div>
    </div>

    <script src="js/app.js"></script>
  </body>
</html>
