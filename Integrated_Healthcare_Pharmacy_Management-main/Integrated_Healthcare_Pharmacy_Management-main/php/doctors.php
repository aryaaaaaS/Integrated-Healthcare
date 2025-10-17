<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Doctors</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Doctor Management</h2>
    <a href="index.php">← Back to Home</a>
    <hr>

    <!-- Add Doctor Form -->
    <h3>Add Doctor</h3>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Specialization:</label>
        <input type="text" name="specialization" required>
        <label>Phone:</label>
        <input type="text" name="phone" required>
        <button type="submit" name="add">Add Doctor</button>
    </form>

    <?php
    // Insert doctor
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $specialization = $_POST['specialization'];
        $phone = $_POST['phone'];

        $sql = "INSERT INTO doctors (name, specialization, phone)
                VALUES ('$name', '$specialization', '$phone')";
        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green;'>Doctor added successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
    ?>

    <!-- Display All Doctors -->
    <h3>Doctor List</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Phone</th>
        </tr>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM doctors");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['doctor_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['specialization']}</td>
                        <td>{$row['phone']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No doctors found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
