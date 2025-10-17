<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Reports & Summary</h2>
    <a href="index.php">← Back to Home</a>
    <hr>

    <h3>Total Patients:</h3>
    <?php
    $res=mysqli_query($conn,"SELECT COUNT(*) AS total FROM patients");
    $row=mysqli_fetch_assoc($res);
    echo "<p>".$row['total']."</p>";
    ?>

    <h3>Total Doctors:</h3>
    <?php
    $res=mysqli_query($conn,"SELECT COUNT(*) AS total FROM doctors");
    $row=mysqli_fetch_assoc($res);
    echo "<p>".$row['total']."</p>";
    ?>

    <h3>Total Medicines:</h3>
    <?php
    $res=mysqli_query($conn,"SELECT COUNT(*) AS total FROM medicines");
    $row=mysqli_fetch_assoc($res);
    echo "<p>".$row['total']."</p>";
    ?>

    <h3>Total Prescriptions:</h3>
    <?php
    $res=mysqli_query($conn,"SELECT COUNT(*) AS total FROM prescriptions");
    $row=mysqli_fetch_assoc($res);
    echo "<p>".$row['total']."</p>";
    ?>
</body>
</html>
