<?php
require_once("connect.php"); // Assuming "connect.php" contains the database connection code

// Select the database
if (!mysqli_select_db($conn, "drugdispensingtools")) {
    die("Error: " . mysqli_error($conn));
}

// Check if the search form is submitted
if(isset($_GET['search'])) {
    $search = $_GET['search'];

    $sql = "SELECT * FROM doctor WHERE Name LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM doctor";
}

$results = $conn->query($sql);

if ($results === false) {
    die("Error: " . $conn->error);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctors List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Doctors Table</h1>

    <h2>Search Doctor</h2>
    <form method="GET" action="">
        <label for="search">Search by Doctor Name:</label>
        <input type="text" name="search" id="search" placeholder="Enter doctor name">
        <input type="submit" value="Search">
    </form>
    <p>Enter the doctor's name in the search bar above and click "Search" to display the doctor's information.</p>

    <?php if ($results->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
            </tr>
            <?php while ($row = $results->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["Name"]; ?></td>
                    <td><?php echo $row["Email"]; ?></td>
                    <td><?php echo $row["Number"]; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No data found in the Doctors table.</p>
    <?php } ?>
    <!-- Insert this code where you want to display the table -->

</body>
</html>

<?php
$results->close();
$conn->close();
?>
