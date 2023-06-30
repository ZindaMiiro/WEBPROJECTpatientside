?<?php
session_start(); // Start the session

require_once("connect.php"); // Assuming "connect.php" contains the database connection code

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Username = $_POST['Username'];

    // Prepare and execute the SQL query to check if the username exists in the patient table
    $sql = "SELECT * FROM patients WHERE Username = '$Username'";
    $result = $conn->query($sql);

    // Check if the query returned any rows
    if ($result->num_rows > 0) {
        // Username exists, retrieve the patient's name
        $row = $result->fetch_assoc();
        $patientName = $row['Name'];

        // Store the patient's name in the session
        $_SESSION['PatientName'] = $patientName;

        // Redirect to the prescription page
        header("Location: PersonalPrescriptions.php");
        exit(); // Stop further execution of the script
    } else {
        // Username does not exist, display an error message
        echo "Invalid Username.";
    }
}

// Check if the PatientName session variable is set
if (isset($_SESSION['PatientName'])) {
    // Retrieve the patient's name from the session
    $patientName = $_SESSION['PatientName'];

    // Prepare and execute the SQL query to retrieve prescriptions for the specific patient
    $sql = "SELECT * FROM patient_prescription WHERE Patient_Name = '$patientName'";
    $result = $conn->query($sql);

    // Display the prescriptions in a table
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Patient Name</th><th>Drug Name</th><th>Doctor Name</th><th>Dosage</th><th>Start Date</th><th>End Date</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Patient_Name'] . "</td>";
            echo "<td>" . $row['Drug_Name'] . "</td>";
            echo "<td>" . $row['Doctor_name'] . "</td>";
            echo "<td>" . $row['Dosage'] . "</td>";
            echo "<td>" . $row['Start_date'] . "</td>";
            echo "<td>" . $row['End_date'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No prescriptions found for this patient.";
    }
} else {
    echo "Patient information not found. Please log in again.";
}

// Reset the session variable back to the username
$_SESSION['PatientName'] = $_SESSION['Username'];

// Close the database connection
$conn->close();
?>

