<?php
include_once '../classes/Database.php';
include_once '../models/Product.php';

// Create a new Database instance and get the connection
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // For debugging: Print POST data
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    // Get data from POST
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
    $description = isset($_POST['description']) ? $_POST['description'] : null;

    // Set values to Product object
    $product->id = $id;
    $product->name = $name;
    $product->price = $price;
    $product->quantity = $quantity;
    $product->description = $description;

    // Update the product
    if ($product->update()) {
        echo "Product updated successfully.";
    } else {
        echo "Unable to update product.";
    }
} else {
    echo "Invalid request.";
}
?>
