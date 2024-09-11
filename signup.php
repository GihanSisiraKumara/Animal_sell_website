<?php
// Database connection
$host = "localhost"; // Change this to your host
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "petdatabase"; // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Storing the password as plain text
    $role = $_POST['role']; // Either 'admin' or 'user'

    // Insert data into the corresponding table
    if ($role == 'admin') {
        $sql = "INSERT INTO adminbord (name, email, password) VALUES (?, ?, ?)";
    } else {
        $sql = "INSERT INTO owneruser (name, email, password) VALUES (?, ?, ?)";
    }

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to login.php after successful insertion
        header("Location: signin.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html>

<head>
	<title>Animated Login Form</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/bg.svg">
		</div>
		<div class="login-content">
			<form method="post">
				<img src="img/avatar.svg">
				<h2 class="title">Welcome</h2>
				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>Username</h5>
						<input type="text" name="name" class="input">
					</div>
				</div>
                <div class="input-div one">
					<div class="i">
                    <i class="fas fa-envelope"></i>

					</div>
					<div class="div">
						<h5>E-mail</h5>
						<input type="text" name="email" class="input">
					</div>
				</div>
				<div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
						<input type="password" name="password" class="input">
					</div>
				</div>
                <div class="input-div radio">
	        <label>
		       <input type="radio" name="role" value="user" checked>
		        User
		    <span class="checkmark"></span>
	        </label>
	         <label>
		     <input type="radio" name="role" value="admin">
		      Admin
		     <span class="checkmark"></span>
	       </label>
           </div>

				<a href="signin.php">All ready have an account?</a>
				<input type="submit" class="btn" value="Sign Up">
			</form>
		</div>
	</div>
	<script type="text/javascript" src="js/main.js"></script>
</body>

</html>