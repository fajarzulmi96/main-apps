<?php
require '../vendor/autoload.php';

use PhpSolver\LinearProgramming\Solver;

// Define the coefficients for the objective function
$objectiveFunction = [7, 10, 8]; // Coefficients for xA, xB, xC

// Define the constraints matrix (coefficients for xA, xB, xC)
$constraints = [
    [5, 8, 6], // Coefficient for the budget
    [1, 0, 0], // Constraint for product A
    [0, 1, 0], // Constraint for product B
    [0, 0, 1]  // Constraint for product C
];

// Define the bounds for the constraints
$bounds = [
    '<=', 100, // Budget constraint
    '<=', 10,  // Product A max demand
    '<=', 8,   // Product B max demand
    '<=', 12   // Product C max demand
];

// Create the solver instance
$solver = new Solver();

// Set the coefficients and constraints
$solver->setObjective($objectiveFunction);
$solver->setConstraints($constraints, $bounds);

// Solve the problem
$result = $solver->solve();

// Extract the results
$solution = $result['solution']; // Optimal values for xA, xB, xC
$optimalValue = $result['objective_value']; // Optimal value of the objective function

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode([
    'solution' => $solution,
    'optimal_value' => $optimalValue
]);
?>
