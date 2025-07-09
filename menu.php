<?php
session_start();
include('db.php');


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$sql = "SELECT * FROM pizzas";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "No pizzas available.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Menu - AKS Pizza Shop</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>

</head>
<body style="background-image: url('https://img.freepik.com/free-photo/top-view-delicious-food-with-copy-space_23-2150873986.jpg?semt=ais_hybrid'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh;">
    <header>
        <h1>Pizza Shop</h1>
        <nav>
            <a href="logout.php">Logout</a>
            <a href="cart.php">Go to Cart</a>
        </nav>
    </header>

    <section id="menu">
        <h2>Choose Your Pizza</h2>

        <?php while ($pizza = mysqli_fetch_assoc($result)): ?>
            <?php
            $image_path = 'images/' . $pizza['id'] . '.jpg';
            if (!file_exists($image_path)) {
                $image_path = 'images/placeholder.jpg'; 
            }
            ?>
            <div class="menu-item">
                <img src="<?php echo $image_path; ?>" alt="<?php echo $pizza['name']; ?>" class="pizza-img">
                <h3><?php echo $pizza['name']; ?></h3>
                <p><?php echo $pizza['description']; ?></p>
                <p>Price: $<?php echo $pizza['price']; ?></p>

                
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="pizza_id" value="<?php echo $pizza['id']; ?>"> <!-- Pizza ID -->
                    <input type="hidden" name="pizza_name" value="<?php echo $pizza['name']; ?>"> <!-- Pizza Name -->
                    <input type="hidden" name="pizza_price" value="<?php echo $pizza['price']; ?>"> <!-- Pizza Price -->

                    <label for="size">Size:</label>
                    <select name="size" required>
                        <option value="small">Small - $<?php echo $pizza['price']; ?></option>
                        <option value="medium">Medium - $<?php echo $pizza['price'] + 2; ?></option>
                        <option value="large">Large - $<?php echo $pizza['price'] + 4; ?></option>
                    </select>

                    <div class="topping-options">
                        <span>Toppings:</span><br>
                        <label><input type="checkbox" name="toppings[]" value="extra cheese"> Extra Cheese ($2)</label><br>
                        <label><input type="checkbox" name="toppings[]" value="olives"> Olives ($1)</label><br>
                        <label><input type="checkbox" name="toppings[]" value="mushrooms"> Mushrooms ($1.5)</label><br>
                    </div>

                    <button type="submit">Add to Cart</button>
                </form>
            </div>



        <?php endwhile; ?>
    </section>

    <footer>
        <p>&copy; 2024 Pizza Shop. All Rights Reserved.</p>
    </footer>
</body>
</html>
