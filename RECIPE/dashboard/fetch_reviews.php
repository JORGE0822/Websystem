<?php
include '../connection/db.php';

if (isset($_GET['recipe_id'])) {
    $recipe_id = $_GET['recipe_id'];

    $reviewsSql = "SELECT * FROM recipe_reviews WHERE recipe_id = $recipe_id";
    $reviewsResult = $conn->query($reviewsSql);

    $reviews = array();
    if ($reviewsResult->num_rows > 0) {
        while ($reviewRow = $reviewsResult->fetch_assoc()) {
            $reviews[] = $reviewRow;
        }
    }

    // Return the reviews as JSON
    echo json_encode(array('status' => 'success', 'reviews' => $reviews));
} else {
    // Invalid request, return an error
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request'));
}

$conn->close();
?>
