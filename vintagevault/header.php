<?php
// Prevent header being loaded multiple times
if (!defined('HEADER_INCLUDED')) {
    define('HEADER_INCLUDED', true);

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

        <div class="header-1">
            <div class="flex">
                <p><a href="profile.php"><i class="fas fa-user"></i> Account</a> | <a href="logout.php">	<i class="fa-solid fa-right-from-bracket"></i>Logout</a></p>
            </div>
        </div>

        <div class="header-2">
            <div class="flex">
                <a href="home.php">
                    <img src="images/logo.png" alt="TheVintageVault" class="logo">
                </a>
                <nav class="navbar">
                    <a href="home.php"><i class="fa-solid fa-house"></i> HOME</a>
                    <a href="shop.php"><i class="fa-solid fa-shop"></i> SHOP</a>
                    <a href="about.php"><i class="fa-solid fa-circle-info"></i> ABOUT</a>
                    <a href="contact.php"><i class="fa-solid fa-envelope"></i> CONTACT</a>
                    <a href="orders.php"><i class="fa-solid fa-box"></i> ORDERS</a>
                    <?php
                    $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                    $cart_rows_number = mysqli_num_rows($select_cart_number);
                    ?>
                    <a href="cart.php"> <i class="fas fa-shopping-cart"></i> CART<span>(<?php echo $cart_rows_number; ?>)</span> </a>
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

<?php
}
?>

