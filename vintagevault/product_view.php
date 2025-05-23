<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'] ?? null;

// Check if product ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Get product details
    $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id'") or die('query failed');

    if (mysqli_num_rows($select_product) > 0) {
        $product = mysqli_fetch_assoc($select_product);
    } else {
        header('location:shop.php');
        exit();
    }
} else {
    header('location:shop.php');
    exit();
}

// Handle add to cart
if (isset($_POST['add_to_cart'])) {
    if (!$user_id) {
        header('location:login.php');
        exit();
    }

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $fetch_cart = mysqli_fetch_assoc($check_cart_numbers);
        $existing_quantity = $fetch_cart['quantity'];
        $new_quantity = $existing_quantity + $product_quantity;

        if ($new_quantity > 5) {
            $message[] = 'You cannot add more than 5 units of a product to the cart!';
        } else {
            mysqli_query($conn, "UPDATE `cart` SET quantity = '$new_quantity' WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
            $message[] = 'Product quantity updated in cart!';
        }
    } else {
        if ($product_quantity <= 5) {
            mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
            $message[] = 'Product added to cart!';
        } else {
            $message[] = 'You cannot add more than 5 units of a product to the cart!';
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
    <title><?php echo $product['name']; ?> - The Vintage Vault</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        .view-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .view-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            max-width: 900px;
            margin: auto;
        }

        .box {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            background: #F0EAD6;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: 2px solid #333;
        }

        .image-container {
            flex: 1;
            max-width: 300px;
        }

        .image-container img {
            width: 100%;
            border-radius: 10px;
        }

        .details-container {
            flex: 2;
            padding-left: 20px;
        }

        .details-container .name {
            font-size: 24px;
            font-weight: bold;
        }

        .details-container .price {
            font-size: 20px;
            color: #e67e22;
            margin: 10px 0;
        }

        .details-container .description {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }

        .quantity-selector {
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .box {
                flex-direction: column;
                text-align: center;
            }

            .details-container {
                padding-left: 0;
            }
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="view-item">
        <h1 class="title">Product Overview</h1>

        <div class="view-container">
            <div class="box">
                <div class="image-container">
                    <img src="uploaded_img/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                </div>
                <div class="details-container">
                    <div class="name"><?php echo $product['name']; ?></div>
                    <div class="price">₹<?php echo $product['price']; ?>/-</div>
                    <div class="description">
                        <h3>Description</h3>
                        <?php if (!empty($product['description'])): ?>
                            <p><?php echo $product['description']; ?></p>
                        <?php endif; ?>
                    </div>
                    <form action="" method="post">
                        <div class="quantity-selector">
                            <label for="quantity">Quantity:</label>
                            <input type="number" min="1" max="5" name="product_quantity" value="1" class="qty">
                        </div>
                        <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
                        <div class="product-actions">
                            <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
                            <a href="shop.php" class="option-btn">Back to Shop</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>
</html>

