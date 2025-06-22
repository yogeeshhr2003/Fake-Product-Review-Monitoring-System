<?php
session_start();
include("admin_login_header.php");

$conn = mysqli_connect("localhost", "root", "");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_select_db($conn, "ita");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["pid"])) {
    $pid = $_GET["pid"];

    // Calculate the average rating based on user reviews
    $sql = "SELECT AVG(rating) AS avg_rating FROM reviews WHERE pid = '$pid'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $avg_rating = $row['avg_rating'];
    
    // Calculate the rating out of 5
    $rating_out_of_5 = round($avg_rating, 1) * 5;

    // Update the product's rating in the database
    $updateQuery = "UPDATE products SET rating = $rating_out_of_5 WHERE pid = '$pid'";
    $result = $conn->query($updateQuery);

    if ($result) {
        echo "Rating updated successfully!";
    } else {
        echo "Error updating rating: " . $conn->error;
    }
}
?>

<!-- ... Your HTML and form ... -->
