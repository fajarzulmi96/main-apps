<?php
include_once '../classes/Database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// Periksa apakah data POST ada
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Periksa data POST
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    $product->id = isset($_POST['id']) ? $_POST['id'] : null;
    $product->name = isset($_POST['name']) ? $_POST['name'] : null;
    $product->price = isset($_POST['price']) ? $_POST['price'] : null;
    $product->quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null;

    // Perbarui produk
    if ($product->update()) {
        header("Location: ../views/product_view.php"); // Arahkan ke halaman daftar produk
        exit(); // Pastikan untuk menghentikan eksekusi lebih lanjut
    } else {
        echo "Unable to update product.";
    }
} else {
    echo "Invalid request.";
}
?>
