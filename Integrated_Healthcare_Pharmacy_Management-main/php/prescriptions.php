<?php
// Use a consistent name for your database connection file
include 'db_connect.php'; 

// Variable to store any feedback message for the user
$message = '';

// --- Handle Form Submission: Add a new prescription ---
if (isset($_POST['add'])) {
    // Sanitize user input to prevent SQL injection
    $patient_id = mysqli_real_escape_string($conn, $_POST['patient_id']);
    $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor_id']);
    $medicine_id = mysqli_real_escape_string($conn, $_POST['medicine_id']);
    $dosage = mysqli_real_escape_string($conn, $_POST['dosage']);

    // SQL query to insert the new prescription record
    $sql = "INSERT INTO prescriptions (patient_id, doctor_id, medicine_id, dosage) VALUES ('$patient_id', '$doctor_id', '$medicine_id', '$dosage')";
    
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='message success'>Prescription added successfully!</div>";
    } else {
        $message = "<div class='message error'>Error adding prescription: " . mysqli_error($conn) . "</div>";
    }
}

// --- Fetch data for dropdown menus ---
$patients_result = mysqli_query($conn, "SELECT id, name FROM patients ORDER BY name ASC");
$doctors_result = mysqli_query($conn, "SELECT id, name FROM doctors ORDER BY name ASC");
$medicines_result = mysqli_query($conn, "SELECT id, name FROM medicines ORDER BY name ASC");


// --- Fetch all prescriptions with names using JOINs ---
$prescriptions_sql = "SELECT pre.id, pat.name as patient_name, doc.name as doctor_name, med.name as medicine_name, pre.dosage, pre.prescription_date
                      FROM prescriptions pre
                      JOIN patients pat ON pre.patient_id = pat.id
                      JOIN doctors doc ON pre.doctor_id = doc.id
                      JOIN medicines med ON pre.medicine_id = med.id
                      ORDER BY pre.prescription_date DESC";
$prescriptions_result = mysqli_query($conn, $prescriptions_sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Prescriptions | Integrated Healthcare</title>
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
                    <h1>Prescription Management</h1>
                </div>
                <nav>
                    <a href="index.php">Home</a>
                    <a href="patients.php">Patients</a>
                    <a href="doctors.php">Doctors</a>
                    <a href="medicines.php">Medicines</a>
                    <a class="active" href="prescriptions.php">Prescriptions</a>
                    <a href="reports.php">Reports</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="page-header">
            <h2>Manage Prescriptions</h2>
            <p>Create new prescriptions by linking patients, doctors, and medicines.</p>
        </div>

        <!-- Display the success or error message here -->
        <?php if (!empty($message)) { echo $message; } ?>

        <div class="content-layout">
            <!-- Add Prescription Form Card -->
            <div class="card form-container">
                <h3>Add New Prescription</h3>
                <form method="POST" action="prescriptions.php">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="patient_id">Patient</label>
                            <select id="patient_id" name="patient_id" required>
                                <option value="" disabled selected>Select a patient</option>
                                <?php while($p = mysqli_fetch_assoc($patients_result)) { echo "<option value='{$p['id']}'>" . htmlspecialchars($p['name']) . "</option>"; } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="doctor_id">Doctor</label>
                            <select id="doctor_id" name="doctor_id" required>
                                <option value="" disabled selected>Select a doctor</option>
                                <?php while($d = mysqli_fetch_assoc($doctors_result)) { echo "<option value='{$d['id']}'>" . htmlspecialchars($d['name']) . "</option>"; } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="medicine_id">Medicine</label>
                            <select id="medicine_id" name="medicine_id" required>
                                <option value="" disabled selected>Select a medicine</option>
                                <?php while($m = mysqli_fetch_assoc($medicines_result)) { echo "<option value='{$m['id']}'>" . htmlspecialchars($m['name']) . "</option>"; } ?>
                            </select>
                        </div>
                         <div class="form-group">
                            <label for="dosage">Dosage</label>
                            <input type="text" id="dosage" name="dosage" placeholder="e.g., 1 tablet twice a day" required>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="add" class="btn btn-primary">Save Prescription</button>
                    </div>
                </form>
            </div>

            <!-- Display All Prescriptions Table Card -->
            <div class="card">
                <h3>Prescription List</h3>
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Medicine</th>
                                <th>Dosage</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($prescriptions_result) > 0) {
                                while ($row = mysqli_fetch_assoc($prescriptions_result)) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row['id']) . "</td>
                                            <td>" . htmlspecialchars($row['patient_name']) . "</td>
                                            <td>" . htmlspecialchars($row['doctor_name']) . "</td>
                                            <td>" . htmlspecialchars($row['medicine_name']) . "</td>
                                            <td>" . htmlspecialchars($row['dosage']) . "</td>
                                            <td>" . htmlspecialchars(date('d M, Y', strtotime($row['prescription_date']))) . "</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No prescriptions found.</td></tr>";
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
