<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('location:login.php');
    exit;
}

if (isset($_GET['search'])) {
    $search_item = mysqli_real_escape_string($conn, $_GET['search']);
}

if (isset($_POST['add_to_cart'])) {
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Products</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="products">
   <div class="box-container">
      <?php
      if (!empty($search_item)) {
         $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%$search_item%'") or die('query failed');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_product = mysqli_fetch_assoc($select_products)) {
               ?>
               <form action="" method="post" class="box">
                  <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
                  <div class="name"><?php echo $fetch_product['name']; ?></div>
                  <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                  <input type="number" name="product_quantity" min="1" value="1" class="qty">
                  <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                  <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                  <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                  <input type="submit" name="add_to_cart" value="Add to Cart" class="btn">
               </form>
               <?php
            }
         } else {
            echo '<p class="empty">No products found for your search.</p>';
         }
      } else {
         echo '<p class="empty">Please enter a search term.</p>';
      }
      ?>
   </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
