<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('location:login.php');
    exit();
}

// Handle form submission
if (isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Update in DB
    mysqli_query($conn, "UPDATE `users` SET name = '$name', email = '$email' WHERE id = '$user_id'") or die('Query failed');

    // Destroy session and redirect to login
    session_unset();
    session_destroy();

    // Redirect with message (optional: use session or GET param)
    header('Location: login.php?message=profile_updated');
    exit();
}

// Get current user info
$select = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('Query failed');
$user = mysqli_fetch_assoc($select);
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Update Profile</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="form-container">
   <form action="" method="post">
      <h3>Update Profile</h3>
      <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required placeholder="Enter your name" class="box">
      <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required placeholder="Enter your email" class="box">
      <input type="submit" name="update_profile" value="Update Profile" class="btn">
      <a href="profile.php" class="option-btn">Back to Profile</a>
   </form>
</section>

<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
