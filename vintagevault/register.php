<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = $_POST['user_type'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Invalid email format!';
    } elseif ($password !== $cpassword) {
        $message[] = 'Passwords do not match!';
    } else {
        // Check if user already exists
        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('Query failed');

        if (mysqli_num_rows($select_users) > 0) {
            $message[] = 'User already exists with this email!';
        } else {
            // Admin rule check
            if ($user_type === 'admin') {
                $check_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('Query failed');
                if (mysqli_num_rows($check_admin) > 0) {
                    $message[] = 'An admin already exists. Only one admin can be registered.';
                } else {
                    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_query($conn, "INSERT INTO `users` (name, email, password, user_type) VALUES ('$name', '$email', '$hashed_pass', '$user_type')") or die('Query failed');
                    $message[] = 'Admin registered successfully!';
                    header('location:login.php');
                    exit;
                }
            } else {
                $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
                mysqli_query($conn, "INSERT INTO `users` (name, email, password, user_type) VALUES ('$name', '$email', '$hashed_pass', '$user_type')") or die('Query failed');
                $message[] = 'User registered successfully!';
                header('location:login.php');
                exit;
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include 'header2.php'; ?> 

<?php
// Display any messages (errors or success)
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<div class="form-container">
   <form action="" method="post">
      <h3>New here?</h3>
      <h4>Create an account to start your shopping journey</h4>
      <input type="text" name="name" placeholder="Enter your name" required class="box">
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
      <select name="user_type" class="box">
         <option value="user">User</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Create Account" class="btn">
      <p>Already have an account? <a href="login.php">Login Here</a></p>
   </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
