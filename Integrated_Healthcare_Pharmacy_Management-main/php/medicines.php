<?php
// Use a consistent name for your database connection file
include 'config.php'; 

// Variable to store any feedback message for the user
$message = '';

// --- Handle Form Submission: Add a new medicine ---
if (isset($_POST['add'])) {
    // Sanitize user input to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);

    // SQL query to insert the new medicine record
    $sql = "INSERT INTO medicines (name, quantity, price, expiry_date) VALUES ('$name', '$quantity', '$price', '$expiry_date')";
    
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='message success'>Medicine added successfully!</div>";
    } else {
        $message = "<div class='message error'>Error adding medicine: " . mysqli_error($conn) . "</div>";
    }
}

// --- Fetch all medicines from the database ---
$medicines_result = mysqli_query($conn, "SELECT * FROM medicines ORDER BY name ASC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Medicines | Integrated Healthcare</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="brand">
                    <a href="index.php" class="logo">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                    </a>
                    <h1>Medicine Management</h1>
                </div>
                <nav>
                    <a href="index.php">Home</a>
                    <a href="patients.php">Patients</a>
                    <a href="doctors.php">Doctors</a>
                    <a class="active" href="medicines.php">Medicines</a>
                    <a href="prescriptions.php">Prescriptions</a>
                    <a href="reports.php">Reports</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="page-header">
            <h2>Manage Medicines</h2>
            <p>Add new medicines to the inventory or view the complete stock list below.</p>
        </div>

        <!-- Display the success or error message here -->
        <?php if (!empty($message)) { echo $message; } ?>

        <div class="content-layout">
            <!-- Add Medicine Form Card -->
            <div class="card form-container">
                <h3>Add New Medicine</h3>
                <form method="POST" action="medicines.php">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Medicine Name</label>
                            <input type="text" id="name" name="name" placeholder="e.g. Paracetamol 500mg" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity (Stock)</label>
                            <input type="number" id="quantity" name="quantity" placeholder="e.g. 100" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price (per unit)</label>
                            <input type="number" id="price" name="price" step="0.01" placeholder="e.g. 10.50" required>
                        </div>
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="date" id="expiry_date" name="expiry_date" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="add" class="btn btn-primary">Save Medicine</button>
                    </div>
                </form>
            </div>

            <!-- Display All Medicines Table Card -->
            <div class="card">
                <h3>Medicine Stock List</h3>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($medicines_result) > 0) {
                                while ($row = mysqli_fetch_assoc($medicines_result)) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row['id']) . "</td>
                                            <td>" . htmlspecialchars($row['name']) . "</td>
                                            <td>" . htmlspecialchars($row['quantity']) . "</td>
                                            <td>" . htmlspecialchars(number_format($row['price'], 2)) . "</td>
                                            <td>" . htmlspecialchars($row['expiry_date']) . "</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No medicines found in stock.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer>
        © 2025 Integrated Healthcare & Pharmacy. All Rights Reserved.
    </footer>

    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
</html>
