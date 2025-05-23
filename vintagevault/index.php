<?php
include 'config.php';
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if (isset($_POST['add_to_cart'])) {
    if ($user_id == '') {
        // Redirect to login if not logged in
        header('Location: login.php');
        exit();
    } else {
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if (mysqli_num_rows($check_cart_numbers) > 0) {
            $message[] = 'Already added to cart!';
        } else {
            mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
            $message[] = 'Product added to cart!';
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
   <title>Home</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<div class="message"><span>' . $msg . '</span> <i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
    }
}
?>

<!-- Header -->
<?php include_once 'header2.php'; ?>

<section class="home">
   <div class="content">
      <h3>Hand Picked Items to your door.</h3>
      <p>At The Vintage Vault, we believe that every antique has a story to tell. Our passion for preserving history drives us to create a vibrant online marketplace where collectors, enthusiasts,             and casual buyers can connect with unique pieces from the past.</p>
   </div>
</section>

<section class="products">
   <h1 class="title">Latest Products</h1>

   <div class="box-container">
      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 8") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <form method="post" action="">
            <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <div class="price"> ₹<?php echo $fetch_products['price']; ?>/-</div>
            <input type="number" min="1" max="5" name="product_quantity" value="1" class="qty">
            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
            <div class="button-group">
               <button type="submit" value="add_to_cart" name="add_to_cart" class="btn">Add to Cart</button>
               <a href="product_view.php?id=<?php echo $fetch_products['id']; ?>" class="option-btn">View Product</a>
            </div>
         </form>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">No products added yet!</p>';
         }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">Load More</a>
   </div>
</section>

<section class="about">
   <div class="flex">

      <div class="content">
         <h3>About Us</h3>
         <p>Welcome to The Vintage Vault – Where Timeless Treasures Find Their Way to Your Doorstep.<br>
         Discover a curated collection of antique items from around the world, available at your fingertips. Whether you're searching for a rare artifact, a vintage collectible, or a one-of-a-kind             masterpiece, we bring history to your home with ease.</p>
         <a href="about.php" class="btn">Read More ></a>
      </div>
      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>
   </div>
</section>

<section class="home-contact">
   <div class="content">
      <h3>Have Any Questions?</h3>
      <p>Whether you're looking to sell a cherished heirloom or find that perfect vintage decor item, The Vintage Vault is your trusted partner in navigating the world of antiques. Explore our                 collection today and uncover the timeless treasures waiting just for you!</p>
      <?php if($user_id != ''): ?>
         <a href="contact.php" class="white-btn">Contact Us</a>
      <?php else: ?>
         <a href="login.php" class="white-btn">Login to contact us</a>
      <?php endif; ?>
   </div>
</section>

<?php include 'footer.php'; ?>

<!-- Custom JS File Link -->
<script src="js/script.js"></script>

</body>
</html>
