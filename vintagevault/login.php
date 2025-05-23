<?php
include 'config.php';
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: admin_page.php');
    exit;
}
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_input = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Invalid email format!';
    } else {
        // Fetch user by email
        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('Query failed');

        if (mysqli_num_rows($select_users) > 0) {
            $row = mysqli_fetch_assoc($select_users);

            // Verify hashed password
            if (password_verify($password_input, $row['password'])) {
                // Set session variables based on user type
                if ($row['user_type'] == 'admin') {
                    $_SESSION['admin_id'] = $row['id'];
                    $_SESSION['admin_name'] = $row['name'];
                    $_SESSION['admin_email'] = $row['email'];
                    header('Location: admin_page.php');
                    exit;
                } elseif ($row['user_type'] == 'user') {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_email'] = $row['email'];
                    header('Location: home.php');
                    exit;
                }
            } else {
                $message[] = 'Incorrect email or password!';
            }
        } else {
            $message[] = 'User not found!';
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
    <title>Login</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
<?php include 'header2.php'; ?>

<?php
if (isset($_GET['message']) && $_GET['message'] === 'profile_updated') {
    echo '<div class="message"><span>Profile updated! Please log in again.</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
}
?>
<?php
if (isset($_GET['message']) && $_GET['message'] === 'password_updated') {
    echo '<div class="message"><span>Password updated! Please log in again.</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
}
?>




<div class="form-container">
    <form action="" method="post" onsubmit="return validateForm()">
        <h3>Welcome back!</h3>
        <h4>Please login to continue</h4>
        <input type="email" name="email" placeholder="Enter your email" required class="box">
        <input type="password" name="password" placeholder="Enter your password" required class="box">
        <input type="submit" name="submit" value="Continue" class="btn">
        <p>Don't have an account? <a href="register.php">Register Here</a></p>
    </form>

    <script>
    function validateForm() {
        const emailInput = document.querySelector('input[name="email"]');
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(emailInput.value)) {
            alert('Please enter a valid email address.');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
    </script>
</div>

<?php include 'footer.php'; ?>
</body>

</html>
