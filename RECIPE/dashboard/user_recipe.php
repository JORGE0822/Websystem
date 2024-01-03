<?php
session_start();
include '../connection/db.php';
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Retrieve the logged-in username
$username = $_SESSION['username'];

// Logout logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: ../loginpage/login.php");
    exit();
}
// Recipe submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_recipe'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $username = mysqli_real_escape_string($conn, $username); // Assuming $username is already sanitized

    // Handle the uploaded image
    $image_path = ''; // Set a default value

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Specify the directory where you want to store images
        $target_file = $target_dir . basename($_FILES['image']['name']);

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
        }
    }

    // Insert the recipe data into the database
    $sql = "INSERT INTO recipes (title, description, ingredients, image_path, username) VALUES ('$title', '$description', '$ingredients', '$image_path', '$username')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Recipe submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Profile</title>
    <style>
        /* Additional styles for the recipe form */
        form.recipe-form {
    margin-top: 20px;
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 8px;
}

form.recipe-form label {
    display: block;
    margin-bottom: 8px;
}

form.recipe-form input,
form.recipe-form textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 12px;
    box-sizing: border-box;
}

form.recipe-form button {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

/* Styles for the success message */
.success-message {
    color: green;
    margin-bottom: 10px;
    text-align: center; /* Align the text to the center for better visibility */
}
    </style>
    <title>Dashboard</title>
</head>
</head>
<body>
<header>
        <div class="header-container">
            <div class="welcome-container">
                <h2>Welcome, <?php echo $username; ?>!</h2>
            </div>
            <div class="navigation-container">
                <nav>
                    <a href="dashboard.php">Home</a>
                    <a href="about.php">About</a>
                    <a href="recipe.php">Recipe</a>
                    <a href="profile.php">Profile</a>
                </nav>
            </div>
            <div class="search-container">
                <form action="search.php" method="get">
                    <input type="text" name="query" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
            </div>
            <form method="post" style="margin-left: 10px;">
                <button type="submit" name="logout">Logout</button>
            </form>
        </div>
    </header>

    <main class="main-container">
    <div class="recipe-form-container">
            <form method="post" class="recipe-form" enctype="multipart/form-data">
                <label for="title">Recipe Title:</label>
                <input type="text" name="title" required>

                <label for="description">Recipe Description:</label>
                <textarea name="description" rows="4" required></textarea>

                <label for="ingredients">Recipe Ingredients:</label>
                <textarea name="ingredients" rows="4" required></textarea>

                <label for="image">Recipe Image:</label>
                <input type="file" name="image" accept="image/*">
                <!-- Display the success message if it's not empty -->
            <?php if (!empty($successMessage)): ?>
                <p class="success-message"><?php echo $successMessage; ?></p>
            <?php endif; ?>

                <button type="submit" name="submit_recipe">Submit Recipe</button>
            </form>
            
        </div>
    
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date("Y"); ?> Food Recipe System</p>
        </div>
    </footer>
</body>
</html>
