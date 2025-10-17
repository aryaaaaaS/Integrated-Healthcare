<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Medicines</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Medicine Management</h2>
    <a href="index.php">← Back to Home</a>
    <hr>

    <!-- Add Medicine Form -->
    <h3>Add Medicine</h3>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Quantity:</label>
        <input type="number" name="quantity" required>
        <label>Price:</label>
        <input type="number" name="price" step="0.01" required>
        <label>Expiry Date:</label>
        <input type="date" name="expiry_date" required>
        <button type="submit" name="add">Add Medicine</button>
    </form>

    <?php
    if(isset($_POST['add'])){
        $name=$_POST['name'];
        $quantity=$_POST['quantity'];
        $price=$_POST['price'];
        $expiry=$_POST['expiry_date'];
        $sql="INSERT INTO medicines(name, quantity, price, expiry_date)
              VALUES('$name','$quantity','$price','$expiry')";
        if(mysqli_query($conn,$sql)){
            echo "<p style='color:green;'>Medicine added successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: ".mysqli_error($conn)."</p>";
        }
    }
    ?>

    <!-- Display Medicines -->
    <h3>Medicine List</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Expiry Date</th>
        </tr>
        <?php
        $result=mysqli_query($conn,"SELECT * FROM medicines");
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_assoc($result)){
                echo "<tr>
                        <td>{$row['medicine_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['expiry_date']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No medicines found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
