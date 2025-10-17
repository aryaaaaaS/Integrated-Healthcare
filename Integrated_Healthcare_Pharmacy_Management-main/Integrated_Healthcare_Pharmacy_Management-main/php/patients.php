<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Patients</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Patient Management</h2>
    <a href="index.php">← Back to Home</a>
    <hr>

    <!-- Add Patient Form -->
    <h3>Add Patient</h3>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Gender:</label>
        <input type="text" name="gender" required>
        <label>Contact:</label>
        <input type="text" name="contact" required>
        <label>Address:</label>
        <input type="text" name="address" required>
        <button type="submit" name="add">Add Patient</button>
    </form>

    <?php
    if(isset($_POST['add'])){
        $name=$_POST['name'];
        $gender=$_POST['gender'];
        $contact=$_POST['contact'];
        $address=$_POST['address'];
        $sql="INSERT INTO patients(name, gender, contact, address)
              VALUES('$name','$gender','$contact','$address')";
        if(mysqli_query($conn,$sql)){
            echo "<p style='color:green;'>Patient added successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: ".mysqli_error($conn)."</p>";
        }
    }
    ?>

    <!-- Display Patients -->
    <h3>Patient List</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Contact</th>
            <th>Address</th>
        </tr>
        <?php
        $result=mysqli_query($conn,"SELECT * FROM patients");
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                echo "<tr>
                        <td>{$row['patient_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['gender']}</td>
                        <td>{$row['contact']}</td>
                        <td>{$row['address']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No patients found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
