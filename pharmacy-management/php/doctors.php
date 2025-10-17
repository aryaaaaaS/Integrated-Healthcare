<?php
// Use a consistent name for your database connection file
include 'config.php'; 

// Variable to store any feedback message for the user
$message = '';

// --- Handle Form Submission: Add a new doctor ---
if (isset($_POST['add'])) {
    // It's a good practice to sanitize input to prevent issues
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // SQL query to insert the new doctor record
    $sql = "INSERT INTO doctors (name, specialization, phone) VALUES ('$name', '$specialization', '$phone')";
    
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='message success'>Doctor added successfully!</div>";
    } else {
        // Provide a more detailed error message for debugging
        $message = "<div class='message error'>Error adding doctor: " . mysqli_error($conn) . "</div>";
    }
}

// --- Fetch all doctors from the database to display in the table ---
$doctors_result = mysqli_query($conn, "SELECT * FROM doctors ORDER BY name ASC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors | PharmaLink</title>
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
                    <h1>Doctor Management</h1>
                </div>
                <nav>
                    <a href="index.php">Home</a>
                    <a href="patients.php">Patients</a>
                    <a class="active" href="doctors.php">Doctors</a>
                    <a href="medicines.php">Medicines</a>
                    <a href="prescriptions.php">Prescriptions</a>
                    <a href="reports.php">Reports</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="page-header">
            <h2>Manage Doctors</h2>
            <p>Add new doctors to the system or view all existing records below.</p>
        </div>

        <!-- Display the success or error message here -->
        <?php if (!empty($message)) { echo $message; } ?>

        <div class="content-layout">
            <!-- Add Doctor Form Card -->
            <div class="card form-container">
                <h3>Add New Doctor</h3>
                <form method="POST" action="doctors.php">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="e.g. Dr. Jane Doe" required>
                        </div>
                        <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <input type="text" id="specialization" name="specialization" placeholder="e.g. Cardiologist" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" placeholder="e.g. 9876543210" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="add" class="btn btn-primary">Save Doctor</button>
                    </div>
                </form>
            </div>

            <!-- Display All Doctors Table Card -->
            <div class="card">
                <h3>Doctor List</h3>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Specialization</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($doctors_result) > 0) {
                                while ($row = mysqli_fetch_assoc($doctors_result)) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row['id']) . "</td>
                                            <td>" . htmlspecialchars($row['name']) . "</td>
                                            <td>" . htmlspecialchars($row['specialization']) . "</td>
                                            <td>" . htmlspecialchars($row['phone']) . "</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No doctors found. Add one using the form above.</td></tr>";
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