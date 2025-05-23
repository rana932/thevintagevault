<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('location:login.php');
    exit();
}

// Fetch user details from DB
$user_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('User query failed');
$user = mysqli_fetch_assoc($user_query);

// Optional: Set fallback values
$user_name = $user['name'] ?? 'Unknown User';
$user_email = $user['email'] ?? 'Not Available';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Profile</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="profile">
   <div class="container">

      <h1 class="title">Your Profile</h1>

      <div class="box-container">
         <div class="box">
            <i class="fas fa-user-circle"></i>
            <h3><?php echo htmlspecialchars($user_name); ?></h3>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></p>

            <div class="profile-links">
               <a href="orders.php" class="btn"><i class="fas fa-box"></i> Your Orders</a>
               <a href="update_profile.php" class="option-btn"><i class="fas fa-user-edit"></i> Edit Profile</a>
               <a href="change_password.php" class="option-btn"><i class="fas fa-lock"></i> Change Password</a>
               <a href="logout.php" class="delete-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
         </div>
      </div>

   </div>
</section>


<?php include 'footer.php'; ?>

<!-- Custom JS -->
<script src="js/script.js"></script>

</body>
</html>
