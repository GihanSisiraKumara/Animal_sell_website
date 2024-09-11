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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Either 'admin' or 'user'

    // Choose the correct table based on role
    if ($role == 'admin') {
        $sql = "SELECT * FROM adminbord WHERE email = ? AND password = ?";
    } else {
        $sql = "SELECT * FROM owneruser WHERE email = ? AND password = ?";
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Error preparing the SQL statement: ' . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("ss", $email, $password);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        // Successful login
        if ($role == 'admin') {
            // Redirect to admin dashboard
            header("Location: adminbord.php");
        } else {
            // Redirect to user page
            header("Location: home.php");
        }
        exit();
    } else {
        // Invalid email or password
        echo "<p style='color:red;'>Invalid email or password. Please try again.</p>";
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

				<a href="signup.php">Haven't an account?</a>
				<input type="submit" class="btn" value="Sign In">
			</form>
		</div>
	</div>
	<script type="text/javascript" src="js/main.js"></script>
</body>

</html>
