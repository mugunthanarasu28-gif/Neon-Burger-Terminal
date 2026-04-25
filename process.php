<?php
include 'db.php';

// ADD ITEM
if (isset($_POST['add_item'])) {
    $name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $cat = $_POST['category'];
    $spicy = $_POST['spicy_level'] ?? 1;

    $sql = "INSERT INTO menu_items (item_name, description, price, category, spicy_level) 
            VALUES ('$name', '$desc', '$price', '$cat', '$spicy')";
    
    if ($conn->query($sql)) {
        header("Location: index.php");
    }
}

// DELETE ITEM
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM menu_items WHERE id=$id");
    header("Location: index.php");
}
?>
