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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: ../loginpage/login.php");
    exit();
}

// Fetch specific recipe details
if (isset($_GET['recipe_id'])) {
    $recipe_id = $_GET['recipe_id'];
    $sql = "SELECT * FROM recipes WHERE id = $recipe_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $description = $row['description'];
        $image_path = $row['image_path'];
        $ingredients = $row['ingredients'];
    } else {
        // Redirect to a page indicating that the recipe was not found
        header("Location: recipe_not_found.php");
        exit();
    }
} else {
    // Redirect to a page indicating that the recipe ID is not provided
    header("Location: recipe_not_found.php");
    exit();
}

// Fetch reviews for the recipe
$reviewsSql = "SELECT * FROM recipe_reviews WHERE recipe_id = $recipe_id";
$reviewsResult = $conn->query($reviewsSql);

$reviews = array();
if ($reviewsResult->num_rows > 0) {
    while ($reviewRow = $reviewsResult->fetch_assoc()) {
        $reviews[] = $reviewRow;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="full_view.css">
    <style>
        /* Additional styles for full view */
        .recipe-details-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .recipe-details-container img {
            width: 100%;
            max-height: 400px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .recipe-details-container h2 {
            margin-bottom: 10px;
        }

        .recipe-details-container p {
            margin-bottom: 15px;
            color: #333; /* Adjust text color as needed */
        }

        .recipe-details-container form {
            margin-top: 15px;
        }

        .recipe-details-container textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .recipe-details-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Additional styles for star rating */
        .rating-container {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }

        .rating-stars {
            display: flex;
            font-size: 24px;
        }

        .rating-stars input {
            display: none;
        }

        .rating-stars label {
            cursor: pointer;
            color: #ccc;
        }

        .rating-stars label:hover,
        .rating-stars input:checked ~ label {
            color: #ffc107;
        }

        .rating-value {
            margin-left: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .reviews-container {
            margin-top: 20px;
        }

        .reviews-container h3 {
            margin-bottom: 10px;
        }

        .reviews-container ul {
            list-style: none;
            padding: 0;
        }

        .reviews-container li {
            margin-bottom: 5px;
        }

        .ajax-message {
            margin-top: 10px;
            color: green; /* Adjust the color as needed */
        }

        .ajax-error {
            margin-top: 10px;
            color: red; /* Adjust the color as needed */
        }
    </style>
    <title>Recipe Details</title>
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
        <div class="recipe-details-container">
            <img src="<?php echo $image_path; ?>" alt="<?php echo $title; ?>">
            <h2><?php echo $title; ?></h2>
            <p><?php echo $description; ?></p>
            <p><strong>Ingredients:</strong> <?php echo $ingredients; ?></p>

            <!-- Star rating section -->
            <div class="rating-container">
                <div class="rating-stars">
                    <input type="radio" id="star5" name="rating" value="5" />
                    <label for="star5">&#9733;</label>
                    <input type="radio" id="star4" name="rating" value="4" />
                    <label for="star4">&#9733;</label>
                    <input type="radio" id="star3" name="rating" value="3" />
                    <label for="star3">&#9733;</label>
                    <input type="radio" id="star2" name="rating" value="2" />
                    <label for="star2">&#9733;</label>
                    <input type="radio" id="star1" name="rating" value="1" />
                    <label for="star1">&#9733;</label>
                </div>
                <div class="rating-value">Rating: <span id="selectedRating">0</span></div>
            </div>

            <!-- Form for comments and rating -->
            <form id="reviewForm">
                <textarea name="comment" placeholder="Leave a comment..." rows="4" required></textarea>
                <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
                <!-- Ensure you have the input field for rating -->
                <input type="hidden" name="rating" id="selectedRatingInput" value="0">
                <input type="submit" value="Submit">
            </form>

            <!-- Display messages from AJAX response -->
            <div id="ajaxMessage" class="ajax-message"></div>
            <div id="ajaxError" class="ajax-error"></div>

            <!-- Display existing reviews -->
            <div class="reviews-container">
                <h3>Reviews</h3>
                <ul id="reviewsList">
                    <?php foreach ($reviews as $review) : ?>
                        <li><?php echo $review['user_name']; ?>: <?php echo $review['comment']; ?> (Rating: <?php echo $review['rating']; ?>)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date("Y"); ?> Food Recipe System</p>
        </div>
    </footer>

    <!-- Add the following JavaScript code at the end of the <body> section -->
    <script>
        // JavaScript for updating the selected rating value
        const ratingStars = document.querySelectorAll('.rating-stars input');
        const selectedRating = document.getElementById('selectedRating');
        const selectedRatingInput = document.getElementById('selectedRatingInput');
        const reviewForm = document.getElementById('reviewForm');
        const ajaxMessage = document.getElementById('ajaxMessage');
        const ajaxError = document.getElementById('ajaxError');
        const reviewsList = document.getElementById('reviewsList');

        ratingStars.forEach(star => {
            star.addEventListener('change', (event) => {
                selectedRating.textContent = event.target.value;
                // Set the value in the hidden input field
                selectedRatingInput.value = event.target.value;
            });
        });

        // AJAX for form submission
        reviewForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(reviewForm);

            fetch('process_comment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    ajaxMessage.textContent = data.message;
                    ajaxError.textContent = '';

                    // Optionally, update the reviews list
                    fetchReviews();
                } else {
                    ajaxError.textContent = data.message;
                    ajaxMessage.textContent = '';
                }
            })
            .catch(error => {
                ajaxError.textContent = 'An error occurred. Please try again.';
                ajaxMessage.textContent = '';
            });
        });

        // Function to fetch and update reviews
        function fetchReviews() {
            // Fetch reviews for the recipe
            fetch(`fetch_reviews.php?recipe_id=<?php echo $recipe_id; ?>`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Update the reviews list
                        reviewsList.innerHTML = '';
                        data.reviews.forEach(review => {
                            const listItem = document.createElement('li');
                            listItem.textContent = `${review.user_name}: ${review.comment} (Rating: ${review.rating})`;
                            reviewsList.appendChild(listItem);
                        });
                    } else {
                        console.error('Failed to fetch reviews');
                    }
                })
                .catch(error => {
                    console.error('Error fetching reviews:', error);
                });
        }

        // Initial fetch of reviews on page load
        fetchReviews();
    </script>
</body>
</html>
