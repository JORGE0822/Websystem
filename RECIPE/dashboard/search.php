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

// Check if the search form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    // Sanitize the search query to prevent SQL injection
    $searchQuery = mysqli_real_escape_string($conn, $_GET['query']);

    // Perform the search query
    $sql = "SELECT * FROM recipes WHERE title LIKE '%$searchQuery%'";
    $result = $conn->query($sql);
} else {
    // Redirect back to the dashboard or another page if the search form is not submitted
    header("Location: dashboard.php");
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="search.css">
    <title>Search Results</title>
    <style>
        /* Additional styles for search results */
        .search-results-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .search-result-card {
            max-width: 300px;
            text-align: center;
        }

        .search-result-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .search-result-card h3 {
            margin-top: 10px;
            font-size: 16px;
            
        }
    </style>
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
        <h2>Search Results for "<?php echo $searchQuery; ?>"</h2>

        <div class="search-results-container">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="search-result-card">
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
