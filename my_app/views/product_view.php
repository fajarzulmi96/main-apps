<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <h1 class="mb-4">Product Management</h1>

        <!-- Create Product -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Create Product</h2>
            </div>
            <div class="card-body">
                <form action="../controllers/product_create.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price">Price:</label>
                            <input type="number" id="price" name="price" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>

        <!-- Product List -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Product List</h2>
            </div>
            <div class="card-body">
                <?php
                include_once '../classes/Database.php';
                include_once '../models/Product.php';

                $database = new Database();
                $db = $database->getConnection();
                $product = new Product($db);

                $stmt = $product->read();
                ?>
                <table class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['price']); ?></td>
                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td>
                                    <a href="?action=update&id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-warning btn-sm">Update</a>
                                    <a href="../controllers/product_delete.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Display Update Form -->
        <?php
        if (isset($_GET['action']) && $_GET['action'] === 'update' && isset($_GET['id'])) {
            $product_id = $_GET['id'];
            $stmt = $product->getProductById($product_id);
            if ($stmt) {
                $product_data = $stmt;
                ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h2>Update Product</h2>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/product_update.php" method="post">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($product_data['id']); ?>">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name:</label>
                                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product_data['name']); ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price">Price:</label>
                                    <input type="number" id="price" name="price" class="form-control" value="<?php echo htmlspecialchars($product_data['price']); ?>" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity:</label>
                                <input type="number" id="quantity" name="quantity" class="form-control" value="<?php echo htmlspecialchars($product_data['quantity']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
                <?php
            } else {
                echo "<div class='alert alert-danger'>Product not found.</div>";
            }
        }
        ?>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
