<?php
// process_comment.php

session_start();
include '../connection/db.php';

// Assuming you have a 'recipe_reviews' table with columns 'recipe_id', 'comment', and 'rating'
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipe_id = $_POST['recipe_id'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    // Add server-side validation as needed

    // Insert the review into the database
    $insertSql = "INSERT INTO recipe_reviews (recipe_id, comment, rating) VALUES ('$recipe_id', '$comment', '$rating')";
    
    if ($conn->query($insertSql) === TRUE) {
        $response = ['status' => 'success', 'message' => 'Review submitted successfully'];
    } else {
        $response = ['status' => 'error', 'message' => 'Error submitting review'];
    }

    // Return a JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Redirect or handle the case where the request method is not POST
}
?>
