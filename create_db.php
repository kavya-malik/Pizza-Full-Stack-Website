<?php

$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "final";   


$conn = mysqli_connect($servername, $username, $password);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (mysqli_query($conn, $sql)) {
    echo "Database '$dbname' created or already exists.<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}


mysqli_select_db($conn, $dbname);


$sql_users = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);";

if (mysqli_query($conn, $sql_users)) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating 'users' table: " . mysqli_error($conn) . "<br>";
}


$sql_pizzas = "
CREATE TABLE IF NOT EXISTS pizzas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255)
    
);";

if (mysqli_query($conn, $sql_pizzas)) {
    echo "Table 'pizzas' created successfully.<br>";
} else {
    echo "Error creating 'pizzas' table: " . mysqli_error($conn) . "<br>";
}


$sql_orders = "
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if (mysqli_query($conn, $sql_orders)) {
    echo "Table 'orders' created successfully.<br>";
} else {
    echo "Error creating 'orders' table: " . mysqli_error($conn) . "<br>";
}


$sql_order_items = "
CREATE TABLE IF NOT EXISTS order_items (
    order_id INT NOT NULL,
    pizza_id INT NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (order_id, pizza_id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (pizza_id) REFERENCES pizzas(id)
)";

if (mysqli_query($conn, $sql_order_items)) {
    echo "Table 'order_items' created successfully.<br>";
} else {
    echo "Error creating 'order_items' table: " . mysqli_error($conn) . "<br>";
}


$sql_cart = "
CREATE TABLE IF NOT EXISTS cart (
    user_id INT NOT NULL,
    pizza_id INT NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (user_id, pizza_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (pizza_id) REFERENCES pizzas(id)
)";

if (mysqli_query($conn, $sql_cart)) {
    echo "Table 'cart' created successfully.<br>";
} else {
    echo "Error creating 'cart' table: " . mysqli_error($conn) . "<br>";
}

mysqli_close($conn);
?>
