<?php
session_start();
include('db.php');


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "Your cart is empty. <a href='menu.php'>Go to Menu</a>";
    exit;
}


if (isset($_GET['remove'])) {
    $removeIndex = $_GET['remove'];
    unset($_SESSION['cart'][$removeIndex]); 
    $_SESSION['cart'] = array_values($_SESSION['cart']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - AKS Pizza Shop</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <header>
        <h1>Pizza Shop</h1>
        <nav>
            <a href="logout.php">Logout</a>
            <a href="menu.php">Back to Menu</a>
            <a href="checkout.php">Proceed to Checkout</a>
        </nav>
    </header>

    <section id="cart">
        <h2>Your Cart</h2>

        <?php
        $totalPrice = 0;
        foreach ($_SESSION['cart'] as $index => $item) {
            $pizza_price = $item['pizza_price'];
            if ($item['size'] == 'medium') {
                $pizza_price += 2;
            } elseif ($item['size'] == 'large') {
                $pizza_price += 4;
            }

            
            $toppings_price = 0;
            $toppings = explode(", ", $item['toppings']);
            foreach ($toppings as $topping) {
                if ($topping == 'extra cheese') {
                    $toppings_price += 2;
                } elseif ($topping == 'olives') {
                    $toppings_price += 1;
                } elseif ($topping == 'mushrooms') {
                    $toppings_price += 1.5;
                }
            }

            $itemTotalPrice = $pizza_price + $toppings_price;
            $totalPrice += $itemTotalPrice;
        ?>

        <div class="cart-item">
            <h3><?php echo $item['pizza_name']; ?> (<?php echo ucfirst($item['size']); ?>)</h3>
            <p>Toppings: <?php echo $item['toppings']; ?></p>
            <p>Price: $<?php echo number_format($itemTotalPrice, 2); ?></p>
            <a href="cart.php?remove=<?php echo $index; ?>">Remove from Cart</a>
        </div>

        <?php } ?>

        <h3>Total: $<?php echo number_format($totalPrice, 2); ?></h3>
    </section>

    <footer>
        <p>&copy; 2024 Pizza Shop. All Rights Reserved.</p>
    </footer>
</body>
</html>
