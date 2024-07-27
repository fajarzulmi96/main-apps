<?php
// Get input data from POST request
$data = json_decode(file_get_contents('php://input'), true);

// For simplicity, assume these values are stored somewhere (e.g., database or file)
// Example response for demonstration purposes
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'constraints' => $data
]);
?>
