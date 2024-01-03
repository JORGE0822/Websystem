<?php
session_start();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="about.css"> 
    <style>
       /* Style the main content */
main {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
}

.about-section h2,
.contact-section h2,
.creators-section h2 {
    color: #333;
    border-bottom: 2px solid #333;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.about-section p,
.contact-section p,
.creators-section p {
    margin-bottom: 15px;
}

.contact-section ul {
    list-style-type: none;
    padding: 0;
}

.contact-section ul li {
    margin-bottom: 10px;
}

.creators-section .creator {
    margin-bottom: 20px;
}

.creators-section .creator img {
    max-width: 100%;
    border-radius: 50%;
    margin-bottom: 10px;
}
.creator {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .creator img {
        max-width: 100%;
        height: auto;
        border-radius: 50%; /* Optional: Add rounded corners to the image */
        margin-bottom: 10px; /* Adjust as needed */
    }

    .creator-description {
        font-size: 14px;
        color: #555;
    }
    </style>
    <title>About Us</title>
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
        <section class="about-section">
            <h2>About Us</h2>
            <p>Welcome to our Food Recipe System dedicated to showcasing the rich and diverse flavors of Filipino cuisine. Our goal is to bring authentic Filipino recipes to food enthusiasts around the world, celebrating the unique taste and cultural heritage of the Philippines.</p>
        </section>

        <section class="contact-section">
            <h2>Contact Us</h2>
            <p>Connect with us on social media:</p>
            <ul>
                <li>Facebook: <a href="https://web.facebook.com/profile.php?id=100056342206884/">Facebook Page</a></li>
                <li>YouTube: <a href="https://www.youtube.com/channel/UCqXhdgytu50iLbkH-0BVUBA/">YouTube Channel</a></li>
                <li>Instagram: <a href="https://www.instagram.com/akosijong_//">Instagram Page</a></li>
                <li>Behance: <a href="https://www.behance.net/JorgeDesigns_?log_shim_removal=1/">Behance Profile</a></li>
                <li>Gmail: <a href="https://mail.google.com/mail/u/0/?tab=rm&ogbl#inbox/">Email</a></li>
            </ul>
        </section>

        <section class="creators-section">
        <div class="creators-section">
     <!-- Jorge -->
    <div class="creator">
        <img src="../img/jorge.jpg" alt="Jorge">
        <p class="creator-description">Jorge - Co-founder and Content Creator</p>
    </div>       
    
    <!-- Arvin -->
    <div class="creator">
        <img src="../img/arvin.jpg" alt="Arvin">
        <p class="creator-description">Arvin - Co-founder and Designer</p>
    </div>

    <!-- Jan -->
    <div class="creator">
        <img src="../img/jan.jpg" alt="Jan">
        <p class="creator-description">Jan - Co-founder and Developer</p>
    </div>
</div>
        </section>
    </main>

    <footer>
        <div class="footer-container">
            <p>&copy; <?php echo date("Y"); ?> Food Recipe System</p>
        </div>
    </footer>
</body>
</html>
