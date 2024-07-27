<?php
include_once '../classes/Database.php';
include_once '../models/Product.php';

// Create a new Database instance and get the connection
$database = new Database();
$db = $database->getConnection();

// Create a new Product instance
$product = new Product($db);

// Determine if data is being sent as JSON or from a form
$isJsonRequest = strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;

// Handle JSON request
if ($isJsonRequest) {
    $data = json_decode(file_get_contents("php://input"));
    $product->name = $data->name;
    $product->price = $data->price;
    $product->quantity = $data->quantity;

    $response = $product->create(); // Call create method
    echo json_encode($response);
}
// Handle form submission
else {
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->quantity = $_POST['quantity'];

    if ($product->create()) {
        header("Location: ../views/product_view.php");
        exit(); // Ensure no further code is executed after redirect
    } else {
        echo "Unable to create product.";
    }
}
?>
