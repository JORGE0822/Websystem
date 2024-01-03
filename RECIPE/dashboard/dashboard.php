<?php
session_start();
// Include your database connection file
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


// Fetch all recipes
$sql = "SELECT * FROM recipes";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Dashboard</title>
    <style>
        /* Additional styles for recipe display */
        .recipe-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .recipe-card {
        max-width: 300px;
        width: 100%; /* Set the width to 100% */
        text-align: center;
        overflow: hidden; /* Hide overflow content (if any) */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 10px; /* Add margin for spacing */
    }

    .recipe-card img {
        width: 100%; /* Make the image fill the container width */
        height: 150px; /* Set a fixed height for all images */
        object-fit: cover; /* Maintain aspect ratio and cover the container */
        border-radius: 8px; /* Rounded corners for the image */
        cursor: pointer;
    }

    .recipe-card h3 {
        margin-top: 10px;
        font-size: 16px;
        color: #333;
    }
        
    </style>
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

    <main>
    <div class="recipe-container">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="recipe-card">
                    <a href="full_view.php?recipe_id=<?php echo $row['id']; ?>">
                        <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['title']; ?>">
                        <h3><?php echo $row['title']; ?></h3>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>

    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date("Y"); ?> Food Recipe System</p>
        </div>
    </footer>
</body>
</html>
