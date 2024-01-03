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

// Check if the recipe ID is provided in the form data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_recipe'])) {
    $recipe_id = mysqli_real_escape_string($conn, $_POST['recipe_id']);

    // Delete the recipe from the database
    $deleteSQL = "DELETE FROM recipes WHERE id = '$recipe_id' AND username = '$username'";

    if ($conn->query($deleteSQL) === TRUE) {
        $successMessage = "Recipe deleted successfully!";
    } else {
        echo "Error: " . $deleteSQL . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Recipe</title>
    <!-- Add your stylesheets or link to external stylesheets here -->
</head>
<body>
    <h2>Delete Recipe</h2>
    
    <?php if (isset($successMessage)): ?>
        <p style="color: green;"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <form method="post">
        <p>Are you sure you want to delete this recipe?</p>
        <input type="hidden" name="recipe_id" value="<?php echo $_GET['id']; ?>">
        <button type="submit" name="delete_recipe">Yes, Delete Recipe</button>
        <a href="profile.php">No, Go Back</a>
    </form>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
