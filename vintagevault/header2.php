<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . $msg . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<header class="header">

    <!-- Top bar with login and register -->
    <div class="header-1">
        <div class="flex">
            <p>
                <a href="login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a> |
                <a href="register.php"><i class="fa-solid fa-user-plus"></i> Register</a>
            </p>
        </div>
    </div>

    <!-- Main navigation -->
    <div class="header-2">
        <div class="flex">
            <a href="index.php">
                <img src="images/logo.png" alt="TheVintageVault" class="logo">
            </a>

            <nav class="navbar">
                <a href="index.php"><i class="fa-solid fa-house"></i> HOME</a>
                <a href="index.php"><i class="fa-solid fa-shop"></i> SHOP</a>
                <a href="about.php"><i class="fa-solid fa-circle-info"></i> ABOUT</a>
                <a href="contact.php"><i class="fa-solid fa-envelope"></i> CONTACT</a>
            </nav>

            <div id="menu-btn" class="fas fa-bars"></div>
        </div>
    </div>

</header>

<script>
    let menu = document.querySelector('#menu-btn');
    let navbar = document.querySelector('.header .header-2 .navbar');

    menu.onclick = () => {
        navbar.classList.toggle('active');
    };
</script>
