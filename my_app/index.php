<?php
// Autoload classes and include configuration
require_once 'config/config.php';
require_once 'classes/Database.php';

// Routing logic
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Include the controller based on the request
if (strpos($request_uri, '/create') !== false) {
    require_once 'controllers/product_create.php';
} elseif (strpos($request_uri, '/update') !== false) {
    require_once 'controllers/product_update.php';
} elseif (strpos($request_uri, '/delete') !== false) {
    require_once 'controllers/product_delete.php';
} elseif (strpos($request_uri, '/linear-programming') !== false) {
    require_once 'controllers/linear_programming_result.php';
} else {
    switch ($request_uri) {
        case '/':
            $content = 'home.php';
            break;
        case '/about':
            $content = 'about.php';
            break;
        case '/contact':
            $content = 'contact.php';
            break;
        case '/product_view':
            $content = 'product_view.php';
            break;
        case '/dashboard':
            $content = 'view_package.php';
            break;    
        case '/dashboard':
            $content = 'dashboard.php';
            break;
        default:
            http_response_code(404);
            $content = '404.php';
            break;
    }
    
    // Include header, content, and footer
    include 'views/header.php';
    include "views/$content";
    include 'views/footer.php';
}
?>
