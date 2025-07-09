<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$pizza_id = $_POST['pizza_id'];
$pizza_name = $_POST['pizza_name'];
$pizza_price = $_POST['pizza_price'];
$size = $_POST['size'];
$toppings = isset($_POST['toppings']) ? implode(", ", $_POST['toppings']) : 'None';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$_SESSION['cart'][] = [
    'pizza_id' => $pizza_id,
    'pizza_name' => $pizza_name,
    'pizza_price' => $pizza_price,
    'size' => $size,
    'toppings' => $toppings,
];

header("Location: menu.php");
exit;
?>
