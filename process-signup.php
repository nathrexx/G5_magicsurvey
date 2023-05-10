<?php
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

// Retrieve user input data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];

// Sanitize and validate input data
$first_name = mysqli_real_escape_string($mysqli, $first_name);
$last_name = mysqli_real_escape_string($mysqli, $last_name);
$email = mysqli_real_escape_string($mysqli, $email);
$phone_number = mysqli_real_escape_string($mysqli, $phone_number);

// Construct an SQL query
$sql = "INSERT INTO users (first_name, last_name, email, phone_number, password_hash)
        VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$password_hash')";

// Construct an SQL query
if (mysqli_query($mysqli, $sql)) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . mysqli_error($mysqli);
}

// Close the database connection
$mysqli->close();
?>