<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('location:login.php');
    exit();
}

if (isset($_POST['update_password'])) {
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    // Fetch hashed password from DB
    $query = mysqli_query($conn, "SELECT password FROM `users` WHERE id = '$user_id'") or die('Query failed');
    $user = mysqli_fetch_assoc($query);
    $current_hashed = $user['password'];

    if (!password_verify($old_pass, $current_hashed)) {
        $message[] = 'Old password is incorrect!';
    } elseif ($new_pass !== $confirm_pass) {
        $message[] = 'New passwords do not match!';
    } else {
        $new_hashed = password_hash($new_pass, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE `users` SET password = '$new_hashed' WHERE id = '$user_id'") or die('Query failed');

        // Log the user out
        session_unset();
        session_destroy();

        // Redirect to login with message
        header('Location: login.php?message=password_updated');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Change Password</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="form-container">
   <form action="" method="post">
      <h3>Change Password</h3>
      <input type="password" name="old_pass" required placeholder="Enter current password" class="box">
      <input type="password" name="new_pass" required placeholder="Enter new password" class="box">
      <input type="password" name="confirm_pass" required placeholder="Confirm new password" class="box">
      <input type="submit" name="update_password" value="Update Password" class="btn">
      <a href="profile.php" class="option-btn">Back to Profile</a>
   </form>
</section>

<?php include 'footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>
