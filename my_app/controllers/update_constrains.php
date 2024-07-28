<?php
$data = json_decode(file_get_contents('php://input'), true);

$file = '../constraints.json'; // Jalur relatif dari file ini ke constraints.json

file_put_contents($file, json_encode($data));

header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'message' => 'Constraints updated successfully',
    'constraints' => $data
]);
?>
