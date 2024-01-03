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

// Fetch recipes from the database
$sql = "SELECT * FROM recipes ORDER BY created_at DESC";
$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="recipe.css">
    <style>
        /* Additional styles for recipe cards */
        .recipe-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .recipe-card {
            flex: 0 0 calc(33.33% - 40px); /* Adjust the width as needed and consider margin */
            margin: 20px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            position: relative;
            overflow: hidden;
        }

        .recipe-card img {
            width: 100%;
            max-height: 300px; /* Adjust the max-height as needed */
            height: auto;
            border-radius: 8px;
        }

        .recipe-card h3 {
            margin-top: 10px;
        }

        .recipe-card p {
            margin-top: 5px;
            color: #333; /* Adjust text color as needed */
        }

        .recipe-card:hover .ingredients-button {
            opacity: 1;
        }

        .ingredients-button {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
        }
    </style>
    <title>Recipes</title>
</head>
<body>
    <header>
        <div class="header-container">
            <h2>Welcome, <?php echo $username; ?>!</h2>
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
            <?php
            // Display recipe cards
            while ($row = $result->fetch_assoc()) {
                $recipe_id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $image_path = $row['image_path'];
                $ingredients = $row['ingredients']; // Assuming you have an 'ingredients' column in your database

                echo '<div class="recipe-card">';
                echo '<img src="' . $image_path . '" alt="' . $title . '">';
                echo '<h3>' . $title . '</h3>';
                echo '<p>' . $description . '</p>';
                echo '<button class="ingredients-button" title="Ingredients" onclick="window.location.href=\'full_view.php?recipe_id=' . $recipe_id . '\'">Ingredients</button>';
                echo '</div>';
            }
            ?>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date("Y"); ?> Food Recipe System</p>
        </div>
    </footer>
</body>
</html>
