<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    session_regenerate_id();
    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];
    } else {
        echo "Error: Can't delete survey if you're an Anonymous. Please login in<br>";
        exit();
    }

    $mysqli = require __DIR__ ."/database.php";
    $survey_code = $_POST["code"];

    $sql = "SELECT survey_id FROM surveys WHERE code = '$survey_code'";
    if (!mysqli_query($mysqli, $sql)) {
        echo "Error: Survey does not exit.<br>";
        exit();
    }

    $sql = "SELECT user_id FROM surveys WHERE code = '$survey_code'";
    $result = mysqli_query($mysqli, $sql);
    $row = $result->fetch_assoc();
    if ($user_id != $row["user_id"]) {
        echo "Error: Can't delete a survey that you didn't create.<br>";
        exit();
    }
    
    #get Admin user_id:
    $sql = "SELECT user_id FROM users WHERE email = '000@gmail.com'";
    $result = mysqli_query($mysqli, $sql);
    $row = $result->fetch_assoc();
    $admin_id = $row["user_id"];

    $sql = "UPDATE surveys SET is_active = 0, user_id = '$admin_id', is_deleted = 1 WHERE code = '$survey_code'";
    if (mysqli_query($mysqli, $sql)) {
        echo "Delete successfully<br>";
    }
    else {
        echo "Error updating survey: " . $mysqli->error;
    }
    header("Location: homepage.html");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Survey</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Delete Survey</h1>
    <form method="post" novalidate>
        <label for="deleteSurvey">Enter survey code:</label>
        <input type="text" name="code" id="Code">
        <button type="submit">Submit</button>
    </form>

</body>
</html>