<?php
include '../connection/db.php';

$errors = array(); // Array to store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if the password and confirm password match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if the username already exists
    $checkQuery = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        $errors[] = "Username already taken. Please choose a different username.";
    }

    // If there are no errors, proceed with registration
    if (empty($errors)) {
        // Hash the password (for security)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the 'users' table
        $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

        if ($conn->query($insertQuery) === TRUE) {
            $successMessage = "User registered successfully!";
        } else {
            $errors[] = "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="createaccount.css">
    <style>
        .error {
            color: white;
            background-color: red;
            padding: 10px;
            margin-bottom: 10px;
        }

        .success {
            color: white;
            background-color: green;
            padding: 10px;
            margin-bottom: 10px;
        }
        /* Additional style for the anchor tag */
        a {
            color: white;
        }
    
    </style>
    <title>Create Account</title>
</head>
<body>
    <div class="login-container">
        <h2>Create Your Food Recipe System Account</h2>
        
        <?php
        // Display error messages
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<div class="error">' . $error . '</div>';
            }
        }

        // Display success message
        if (isset($successMessage)) {
            echo '<div class="success">' . $successMessage . '</div>';
        }
        ?>
        
        <form class="login-form" action="#" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Create Account</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
