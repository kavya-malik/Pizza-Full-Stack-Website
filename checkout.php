<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<div style='text-align: center; color: white; font-size: 24px;'>Your cart is empty. <a href='menu.php' style='color: white;'>Go to Menu</a></div>";
    exit;
}

$user_id = $_SESSION['user_id'];
$totalPrice = 0;
foreach ($_SESSION['cart'] as $item) {
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
}

$sql = "INSERT INTO orders (user_id, total_price, status) VALUES ('$user_id', '$totalPrice', 'Pending')";
if (mysqli_query($conn, $sql)) {
    $order_id = mysqli_insert_id($conn); 
    foreach ($_SESSION['cart'] as $item) {
        $pizza_id = $item['pizza_id'];
        $size = $item['size'];
        $toppings = $item['toppings'];
        $quantity = 1;

        $sql = "INSERT INTO order_items (order_id, pizza_id, quantity) VALUES ('$order_id', '$pizza_id', '$quantity')";
        mysqli_query($conn, $sql);
    }

    unset($_SESSION['cart']);

    echo "<div style='text-align: center; color: white; font-size: 30px;'>Your order has been placed successfully! Total: $" . number_format($totalPrice, 2) . "</div>";
    echo "<div style='text-align: center; color: white; font-size: 20px;'><a href='menu.php' style='color: white;'>Go to Menu</a></div>";
} else {
    echo "<div style='text-align: center; color: white; font-size: 20px;'>Error: " . mysqli_error($conn) . "</div>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Menu - Pizza Shop</title>
    
   

</head>
<body style="background-image: url('https://img.freepik.com/free-photo/top-view-delicious-food-with-copy-space_23-2150873986.jpg?semt=ais_hybrid'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh;">
    
</body>
</html>
