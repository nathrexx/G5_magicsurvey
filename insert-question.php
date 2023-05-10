<?php
session_start();
$mysqli = require __DIR__ . "/database.php";

//Retrieve user input data
$question_name = $_POST['name'];
$question_description = $_POST['description'];
$question_type = $_POST['type'];
$question_option = $_POST['option'];

// Sanitize and validate input data
$question_name = mysqli_real_escape_string($mysqli, $question_name);
$question_description = mysqli_real_escape_string($mysqli, $question_description);
$question_type = mysqli_real_escape_string($mysqli, $question_type);
$question_option = mysqli_real_escape_string($mysqli, $question_option);
$survey_id = $_SESSION["survey_id"];

$sql = "INSERT INTO questions (survey_id, name, description, type, options)
        VALUES ('$survey_id', '$question_name', '$question_description', '$question_type', '$question_option')";
 
// Construct an SQL query
if (mysqli_query($mysqli, $sql)) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . mysqli_error($mysqli);
}
exit;
?>