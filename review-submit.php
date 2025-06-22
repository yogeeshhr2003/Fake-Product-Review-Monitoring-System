<?php 
    session_start();
    include("login_header.php");
    $conn = mysqli_connect("localhost", "root", "");
    
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    mysqli_select_db($conn, "ita");

    if (isset($_POST['submit'])) {    
        // Get user details from the query parameters
        $username = $_GET['username'];
        $pid = $_GET['pid'];
        $prod = "SELECT * FROM products WHERE pid='$pid'";
        $res = mysqli_query($conn, $prod);
        $row1 = mysqli_fetch_array($res);
        $pname = $row1[2];
        $email = $_GET['email'];
        $review = htmlspecialchars($_POST['comment']);
        $rating = $_POST['rating'];
        // Check if the rating field is set in the POST data
       
        
        // Get the user's IP address from the session
        $ip = $_SESSION['user_ip'];

        $sql = "INSERT INTO reviews (pid, pname, username, email, review, rating, ip) 
                VALUES ('$pid', '$pname', '$username', '$email', '$review', '$rating', '$ip')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Review submitted successfully!";
        } else {
            echo "Could not submit review.";
        }
        
        // Redirect the user back to the review page after submission
        header("Location: review-product.php?login=1&username={$username}");
        exit();
    }

    include("footer.php");
?>
