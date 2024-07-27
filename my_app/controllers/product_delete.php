<?php
include_once '../classes/Database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// Verifikasi bahwa ID ada dan valid
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product->id = $_GET['id'];

    // Coba untuk menghapus produk
    if ($product->delete()) {
        // Redirect ke halaman tampilan produk setelah berhasil dihapus
        header("Location: ../views/product_view.php");
        exit(); // Hentikan eksekusi skrip setelah redirect
    } else {
        echo "Unable to delete product.";
    }
} else {
    echo "Invalid ID.";
}
?>
