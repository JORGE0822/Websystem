<?php
include '../connection/db.php';

$errors = array(); // Array to store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the username exists
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            // Valid login credentials
            session_start(); // Start a session to store user information
            $_SESSION['username'] = $username;
            header("Location: ../dashboard/dashboard.php"); // Redirect to the dashboard page
            exit();
        } else {
            $errors[] = "Invalid password. Please try again.";
        }
    } else {
        $errors[] = "Invalid username. Please try again.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <style>
        /* Additional style for the anchor tag */
        a {
            color: white;
        }
    </style>
    <title>Login Page</title>
</head>
<body>
    <div class="login-container">
        <h2>Login to Your Food Recipe System</h2>

        <?php
        // Display error messages
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<div class="error">' . $error . '</div>';
            }
        }
        ?>

        <form class="login-form" action="login.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="createaccount.php">Create one</a></p>
    </div>
</body>
</html>
