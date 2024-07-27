<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Laporan Rugi Laba</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="container mt-5">
        <h1 class="mb-4">Dashboard Laporan Rugi Laba</h1>

        <?php
        // Include the database and product models
        include_once '../classes/Database.php';
        include_once '../models/Product.php';

        // Initialize database connection
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        // Fetch product data
        $stmt = $product->read();
        
        $productNames = [];
        $productQuantities = [];
        $productPrices = [];
        $productTotalValues = [];
        $totalSales = 0;
        $totalQuantity = 0;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $totalValue = $price * $quantity; // Calculate total value for each product
            $totalSales += $totalValue;
            $totalQuantity += $quantity;

            $productNames[] = $name;
            $productQuantities[] = $quantity;
            $productPrices[] = $price;
            $productTotalValues[] = $totalValue;
        }
        ?>

        <!-- Bar Chart -->
        <div class="card mb-4">
            <div class="card-header">
                Grafik Penjualan Barang
                <div id="totalSales" class="mt-2"></div> <!-- Menampilkan total nilai barang untuk bar chart -->
            </div>
            <div class="card-body">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="card mb-4">
            <div class="card-header">
                Grafik Distribusi Total Nilai Barang
                <div id="totalPie" class="mt-2"></div> <!-- Menampilkan total nilai barang untuk pie chart -->
            </div>
            <div class="card-body">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script>
        // Debug Output
        console.log("Product Names:", <?php echo json_encode($productNames); ?>);
        console.log("Product Quantities:", <?php echo json_encode($productQuantities); ?>);
        console.log("Product Total Values:", <?php echo json_encode($productTotalValues); ?>);
        console.log("Product Prices:", <?php echo json_encode($productPrices); ?>);

        // Calculate total sales and update the totalSales element
        var totalSales = <?php echo $totalSales; ?>;
        document.getElementById('totalSales').innerText = 'Total Nilai Barang: Rp ' + totalSales.toFixed(2);

        // Bar Chart
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($productNames); ?>,
                datasets: [{
                    label: 'Jumlah Barang',
                    data: <?php echo json_encode($productQuantities); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value, context) {
                            return 'Rp ' + <?php echo json_encode($productPrices); ?>[context.dataIndex].toFixed(2);
                        },
                        color: '#000'
                    }
                }
            }
        });

        // Calculate total sales for pie chart and update the totalPie element
        var totalPie = totalSales; // Total sales is the same for the pie chart
        document.getElementById('totalPie').innerText = 'Total Nilai Barang: Rp ' + totalPie.toFixed(2);

        // Pie Chart
        var ctxPie = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($productNames); ?>,
                datasets: [{
                    label: 'Total Nilai Barang',
                    data: <?php echo json_encode($productTotalValues); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        formatter: function(value, context) {
                            return 'Rp ' + value.toFixed(2);
                        },
                        color: '#fff'
                    }
                }
            }
        });
    </script>
</body>
</html>
