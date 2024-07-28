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

if ($isJsonRequest) {
    // Handle JSON request
    $data = json_decode(file_get_contents("php://input"));

    // Set values to Product object
    $product->name = isset($data->name) ? $data->name : null;
    $product->price = isset($data->price) ? $data->price : null;
    $product->quantity = isset($data->quantity) ? $data->quantity : null;
    $product->description = isset($data->description) ? $data->description : null;

    // Create the product
    $response = $product->create() ? ["message" => "Product created successfully."] : ["message" => "Unable to create product."];
    echo json_encode($response);

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission
    $product->name = isset($_POST['name']) ? $_POST['name'] : null;
    $product->price = isset($_POST['price']) ? $_POST['price'] : null;
    $product->quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;
    $product->description = isset($_POST['description']) ? $_POST['description'] : null;

    // Create the product
    if ($product->create()) {
        header("Location: ../views/product_view.php");
        exit(); // Ensure no further code is executed after redirect
    } else {
        echo "Unable to create product.";
    }
} else {
    echo "Invalid request.";
}
?>
