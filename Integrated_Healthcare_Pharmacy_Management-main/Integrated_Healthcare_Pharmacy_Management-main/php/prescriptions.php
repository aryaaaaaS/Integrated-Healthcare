<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Prescriptions</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Prescription Management</h2>
    <a href="index.php">← Back to Home</a>
    <hr>

    <!-- Add Prescription Form -->
    <h3>Add Prescription</h3>
    <form method="POST">
        <label>Patient ID:</label>
        <input type="number" name="patient_id" required>
        <label>Doctor ID:</label>
        <input type="number" name="doctor_id" required>
        <label>Medicine ID:</label>
        <input type="number" name="medicine_id" required>
        <label>Dosage:</label>
        <input type="text" name="dosage" required>
        <button type="submit" name="add">Add Prescription</button>
    </form>

    <?php
    if(isset($_POST['add'])){
        $pid=$_POST['patient_id'];
        $did=$_POST['doctor_id'];
        $mid=$_POST['medicine_id'];
        $dosage=$_POST['dosage'];

        $sql="INSERT INTO prescriptions(patient_id, doctor_id, medicine_id, dosage)
              VALUES('$pid','$did','$mid','$dosage')";
        if(mysqli_query($conn,$sql)){
            echo "<p style='color:green;'>Prescription added successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: ".mysqli_error($conn)."</p>";
        }
    }
    ?>

    <!-- Display Prescriptions -->
    <h3>Prescription List</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Patient Name</th>
            <th>Doctor Name</th>
            <th>Medicine Name</th>
            <th>Dosage</th>
        </tr>
        <?php
        $sql="SELECT p.prescription_id, pt.name as patient, d.name as doctor, m.name as medicine, p.dosage
              FROM prescriptions p
              JOIN patients pt ON p.patient_id=pt.patient_id
              JOIN doctors d ON p.doctor_id=d.doctor_id
              JOIN medicines m ON p.medicine_id=m.medicine_id";
        $result=mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                echo "<tr>
                        <td>{$row['prescription_id']}</td>
                        <td>{$row['patient']}</td>
                        <td>{$row['doctor']}</td>
                        <td>{$row['medicine']}</td>
                        <td>{$row['dosage']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No prescriptions found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
