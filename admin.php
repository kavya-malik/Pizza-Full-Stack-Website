<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $sql = "INSERT INTO pizzas (name, description, price, image) VALUES ('$name', '$description', '$price', '$image')";
    if (mysqli_query($conn, $sql)) {
        echo "Pizza added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

?>

<form action="admin.php" method="POST">
    <input type="text" name="name" placeholder="Pizza Name" required><br>
    <br>
    <textarea name="description" placeholder="Pizza Description" required></textarea><br>
    <br>
    <input type="number" name="price" placeholder="Price" step="0.01" required><br>
    <br>
    <input type="text" name="image" placeholder="Image URL" required><br>
    <br>
    <button type="submit">Add Pizza</button>
    <br>
</form>
