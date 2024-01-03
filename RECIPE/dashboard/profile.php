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

// Retrieve recipes submitted by the logged-in user
$selectRecipesSQL = "SELECT * FROM recipes WHERE username = '$username'";
$recipesResult = $conn->query($selectRecipesSQL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <title>Profile</title>
    <style>
        /* Additional styles for the recipe form and submitted recipes */
        /* ... (Your existing styles) */
        .submitted-recipes-container {
    margin-top: 20px;
}

.recipe-card {
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 8px;
    position: relative;
    text-align: center; /* Center the content */
}

.recipe-card img {
    max-width: 70%;
    height: auto;
    margin-top: 10px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

.recipe-actions {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.recipe-actions a,
.recipe-actions button {
    background-color: #4CAF50;
    color: white;
    padding: 8px;
    border: none;
    border-radius: 5px;
    margin-right: 5px;
    cursor: pointer;
    text-decoration: none;
}

.recipe-actions button {
    padding: 8px 12px;
}

.recipe-actions a:hover,
.recipe-actions button:hover {
    background-color: #45a049;
   background-color: #45a049;
   }
   .add-recipe-button {
    background-color: #4CAF50;
    color: white;
    padding: 8px;
    border: none;
    border-radius: 5px;
    margin-right: 5px;
    cursor: pointer;
    text-decoration: none;
}

.add-recipe-button:hover {
    background-color: #45a049;
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
    <!-- Display submitted recipes -->
    <div class="submitted-recipes-container">
    <a href="user_recipe.php" class="add-recipe-button">Add Recipe</a>
        <h2>Your Submitted Recipes</h2>

        <?php
        if ($recipesResult->num_rows > 0) {
            while ($row = $recipesResult->fetch_assoc()) {
                ?>
                <div class="recipe-card">
                    <h3><?php echo $row['title']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                    <p><strong>Ingredients:</strong> <?php echo $row['ingredients']; ?></p>
                    <?php
                    if (!empty($row['image_path'])) {
                        ?>
                        <img src="<?php echo $row['image_path']; ?>" alt="Recipe Image">
                        <?php
                    }
                    ?>
                    <div class="recipe-actions">
                        <a href="update_recipe.php?id=<?php echo $row['id']; ?>">Update Recipe</a>
                        <button onclick="confirmDelete(<?php echo $row['id']; ?>)">Delete Recipe</button>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <p>No recipes submitted yet.</p>
            <?php
        }
        ?>
    </div>
</main>

<footer>
    <div class="footer-container">
        <p>&copy; <?php echo date("Y"); ?> Food Recipe System</p>
    </div>
</footer>

<!-- Add the JavaScript function for confirmation -->
<script>
    function confirmDelete(recipeId) {
        var confirmation = confirm("Are you sure you want to delete this recipe?");
        if (confirmation) {
            // If the user confirms, submit the form with the recipe ID
            var form = document.createElement('form');
            form.method = 'post';
            form.action = 'delete_recipe.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'recipe_id';
            input.value = recipeId;

            var submit = document.createElement('button');
            submit.type = 'submit';
            submit.name = 'delete_recipe';
            submit.style.display = 'none'; // Hide the button

            form.appendChild(input);
            form.appendChild(submit);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>