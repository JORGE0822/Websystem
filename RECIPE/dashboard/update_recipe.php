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

// Check if the recipe ID is provided in the query parameter
if (!isset($_GET['id'])) {
    // Redirect to an error page or handle the situation accordingly
    header("Location: error.php");
    exit();
}

$recipe_id = mysqli_real_escape_string($conn, $_GET['id']);

// Retrieve the recipe details
$selectRecipeSQL = "SELECT * FROM recipes WHERE id = '$recipe_id' AND username = '$username'";
$recipeResult = $conn->query($selectRecipeSQL);

// Check if the recipe exists and belongs to the logged-in user
if ($recipeResult->num_rows !== 1) {
    // Redirect to an error page or handle the situation accordingly
    header("Location: error.php");
    exit();
}

$row = $recipeResult->fetch_assoc();

// Handle the update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_recipe'])) {
    $newTitle = mysqli_real_escape_string($conn, $_POST['new_title']);
    $newDescription = mysqli_real_escape_string($conn, $_POST['new_description']);
    $newIngredients = mysqli_real_escape_string($conn, $_POST['new_ingredients']);

    // Update the recipe data in the database
    $updateSQL = "UPDATE recipes SET title = '$newTitle', description = '$newDescription', ingredients = '$newIngredients' WHERE id = '$recipe_id'";

    if ($conn->query($updateSQL) === TRUE) {
        $successMessage = "Recipe updated successfully!";
    } else {
        echo "Error: " . $updateSQL . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Recipe</title>
    <link rel="stylesheet" href="recipe.css">
    <style>
      .main-container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f2f2f2;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
}

input,
textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 12px;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

/* Style for the success message */
.success-message {
    color: green;
    text-align: center;
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
    <main class="main-container">
    <h2>Update Recipe</h2>
    
    <?php if (isset($successMessage)): ?>
        <p style="color: green;"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="new_title">New Recipe Title:</label>
        <input type="text" name="new_title" value="<?php echo $row['title']; ?>" required>

        <label for="new_description">New Recipe Description:</label>
        <textarea name="new_description" rows="4" required><?php echo $row['description']; ?></textarea>

        <label for="new_ingredients">New Recipe Ingredients:</label>
        <textarea name="new_ingredients" rows="4" required><?php echo $row['ingredients']; ?></textarea>

        <button type="submit" name="update_recipe">Update Recipe</button>
    </form>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date("Y"); ?> Food Recipe System</p>
        </div>
    </footer>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
