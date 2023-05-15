<?php
session_start();
session_regenerate_id();
$mysqli = require __DIR__ . "/database.php";

// Retrieve user input data
$code = $_POST['code'];
$survey_name = $_POST['name'];
$description = $_POST['description'];
$start_datetime = $_POST['start_time'];
$end_datetime = $_POST['end_time'];

date_default_timezone_set('America/Los_Angeles');
$currentDate = date("Y-m-d H:i:s");
$end_time = new DateTime($end_datetime, new DatetimeZone('UTC'));
$end_time->setTimezone(new DateTimeZone('America/Los_Angeles'));
$end_time_string = $end_time->format('Y-m-d H:i:s');
$new_end_time = date("Y-m-d H-i-s", strtotime($end_time_string));

// Sanitize and validate input data
$code = mysqli_real_escape_string($mysqli, $code);
$survey_name = mysqli_real_escape_string($mysqli, $survey_name);
$description = mysqli_real_escape_string($mysqli, $description);
$start_datetime = mysqli_real_escape_string($mysqli, $start_datetime);
$end_datetime = mysqli_real_escape_string($mysqli, $end_datetime);

$sql = "SELECT survey_id FROM surveys WHERE code = '$code'";
$result = mysqli_query($mysqli, $sql);

$error = false;
if ($new_end_time < $currentDate) {
    echo "Error: The end time need to be in the future.<br>";
    $error = true;
}
if (mysqli_num_rows($result) > 0) {
    echo "Error: Survey code already exit.";
    $error = true;
}
if ($error) {
    exit();
}

$user_id = $_SESSION["user_id"];

// Construct an SQL query
$sql = "INSERT INTO surveys (code, name, description, start_datetime, end_datetime, user_id)
        VALUES ('$code', '$survey_name', '$description', '$start_datetime', '$end_datetime', '$user_id')";

// Construct an SQL query
if (mysqli_query($mysqli, $sql)) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . mysqli_error($mysqli);
}

$sql = "SELECT survey_id FROM surveys WHERE code = $code AND user_id = $user_id";
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();
$_SESSION["survey_id"] = $user["survey_id"];
header("Location: create-question.html");
exit;
?>