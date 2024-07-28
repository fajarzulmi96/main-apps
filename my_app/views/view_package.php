<?php 
$pageTitle = 'Linear Programming'; 
include 'header.php'; 
?>

<!-- Form Input -->
<div class="card mb-4">
    <div class="card-header">
        Input Constraints
    </div>
    <div class="card-body">
        <form id="constraintsForm">
            <div class="form-group">
                <label for="budget">Budget</label>
                <input type="number" class="form-control" id="budget" value="100" required>
            </div>
            <div class="form-group">
                <label for="maxA">Max Demand for Product A</label>
                <input type="number" class="form-control" id="maxA" value="10" required>
            </div>
            <div class="form-group">
                <label for="maxB">Max Demand for Product B</label>
                <input type="number" class="form-control" id="maxB" value="8" required>
            </div>
            <div class="form-group">
                <label for="maxC">Max Demand for Product C</label>
                <input type="number" class="form-control" id="maxC" value="12" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Constraints</button>
        </form>
    </div>
</div>

<!-- Results Output -->
<div class="card mb-4">
    <div class="card-header">
        Results
    </div>
    <div class="card-body">
        <pre id="results">Loading...</pre>
    </div>
</div>

<?php include 'footer.php'; ?>

    <!-- JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
    // Function to fetch results from the server
    function fetchResults() {
        fetch('controllers/linear_programming_result.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('Results:', data); // Debugging output
                document.getElementById('results').textContent = JSON.stringify(data, null, 2);
            })
            .catch((error) => {
                console.error('Error fetching results:', error);
                document.getElementById('results').textContent = 'Error fetching results: ' + error.message;
            });
    }

    // Event listener for form submission
    document.getElementById('constraintsForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const budget = document.getElementById('budget').value;
        const maxA = document.getElementById('maxA').value;
        const maxB = document.getElementById('maxB').value;
        const maxC = document.getElementById('maxC').value;

        fetch('controllers/update_constraints.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                budget: budget,
                maxA: maxA,
                maxB: maxB,
                maxC: maxC
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Constraints updated successfully:', data);
            fetchResults(); // Refresh results after updating constraints
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    });

    // Initial fetch of results when the page loads
    fetchResults();
});

    </script>
</body>
</html>
