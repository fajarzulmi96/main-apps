<?php
include_once '../classes/Database.php';
include_once '../models/SalesPackage.php';

// Create a new Database instance and get the connection
$database = new Database();
$db = $database->getConnection();

// Create a new SalesPackage instance
$package = new SalesPackage($db);

// Determine if data is being sent as JSON or from a form
$isJsonRequest = strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false;

// Handle JSON request
if ($isJsonRequest) {
    $data = json_decode(file_get_contents("php://input"));
    $package->name = $data->name;
    $package->price = $data->price;

    $response = $package->create(); // Call create method
    echo json_encode($response);
}
// Handle form submission
else {
    $package->name = $_POST['name'];
    $package->price = $_POST['price'];

    if ($package->create()) {
        header("Location: ../views/package_view.php");
        exit(); // Ensure no further code is executed after redirect
    } else {
        echo "Unable to create package.";
    }
}
?>
