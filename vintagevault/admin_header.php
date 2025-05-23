<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="flex">
      <a href="admin_page.php" class="logo">Admin<span>Panel</span></a>
      <div class="icons">
        <p><i class="fa fa-user-circle"></i> <span><?php echo $_SESSION['admin_name']; ?></span></p>
        <p><i class="fa fa-envelope"></i> <span><?php echo $_SESSION['admin_email']; ?></span></p>
      </div>	  
      <div><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout Admin</a></div>
	  <nav class="navbar">
        <a href="admin_page.php">HOME</a>
        <a href="admin_products.php">PRODUCTS</a>
        <a href="admin_orders.php">ORDERS</a>
        <a href="admin_users.php">USERS</a>
        <a href="admin_contacts.php">MESSAGE</a>
      </nav>
      <div id="menu-btn" class="fas fa-bars"></div>
   </div>
   
   <script>
   let menuBtn = document.querySelector('#menu-btn');
   let navbar = document.querySelector('.header .flex .navbar');

   menuBtn.onclick = () => {
      navbar.classList.toggle('active');
   };
   </script>

</header>