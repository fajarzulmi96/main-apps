<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$file = '../constraints.json'; // Jalur relatif dari file ini ke constraints.json

if (file_exists($file)) {
    $constraints = json_decode(file_get_contents($file), true);
} else {
    $constraints = [
        'budget' => 100,
        'maxA' => 10,
        'maxB' => 8,
        'maxC' => 12
    ];
}

// Contoh perhitungan linear programming
require '../vendor/autoload.php';
use PhpSolver\LinearProgramming\Solver;

$objectiveFunction = [7, 10, 8];

$constraintsMatrix = [
    [5, 8, 6],
    [1, 0, 0],
    [0, 1, 0],
    [0, 0, 1]
];

$bounds = [
    '<=' => $constraints['budget'],
    '<=' => $constraints['maxA'],
    '<=' => $constraints['maxB'],
    '<=' => $constraints['maxC']
];

$solver = new Solver();
$solver->setObjective($objectiveFunction);
$solver->setConstraints($constraintsMatrix, array_values($bounds));

$result = $solver->solve();

$solution = $result['solution'];
$optimalValue = $result['objective_value'];

header('Content-Type: application/json');
echo json_encode([
    'solution' => $solution,
    'optimal_value' => $optimalValue,
    'constraints' => $constraints
]);
?>
