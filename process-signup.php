<?php
$password_invalid = false;
$phoneNum_invalid = false;
$email_invalid_or_taken = false;
$first_name_empty = false;
$last_name_empty = false;
$uppercase_counter = 0;
$lowercase_counter = 0;
$number_counter = 0;
$special_character_counter = 0;

$mysqli = require __DIR__ . "/database.php";

// Retrieve user input data
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$password = $_POST["password"];

// Sanitize and validate input data
$first_name = mysqli_real_escape_string($mysqli, $first_name);
$last_name = mysqli_real_escape_string($mysqli, $last_name);
$email = mysqli_real_escape_string($mysqli, $email);
$phone_number = mysqli_real_escape_string($mysqli, $phone_number);

// check if user enter first name
if (strlen($first_name) == 0) {
    $first_name_empty = true;
    echo "First name is missing<br>";
}

// check if user enter last name
if (strlen($last_name) == 0) {
    $last_name_empty = true;
    echo "Last name is missing<br>";
}

// check if phone number is valid or not
if (strlen($phone_number) < 10) {
    $phoneNum_invalid = true;
    echo "Invalid phone number<br>";
}

// check if email is valid
$trimmed_email = trim($email);
if (!filter_var($trimmed_email, FILTER_VALIDATE_EMAIL)) {
    $email_invalid_or_taken = true;
    echo "Email is invalid<br>";
}

// check if email is already taken
$sql = sprintf("SELECT * FROM users WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();
if (is_array($user)) {
    $email_invalid_or_taken = true;
    echo "Email is already taken<br>";
}

// check if password is less than 8 characters, if so prompt the user to enter again
if (strlen($password) < 8) {
    $password_invalid = true;
    echo "Invalid password: Password must have at least 8 characters<br>";
}

for ($i = 0; $i < strlen($password); ++$i) {
    if (ctype_lower($password[$i])) {
        ++$lowercase_counter;
    }
    if (ctype_upper($password[$i])) {
        ++$uppercase_counter;
    }
    if (preg_match('/\d/', $password[$i])) {
        ++$number_counter;
    }
    if (ctype_punct($password[$i])) {
        ++$special_character_counter;
    }
}

// check if the password the user signed up follow all the requirements
if ($uppercase_counter == 0) {
    echo "Invalid password: Need at least 1 uppercase letter<br>";
    $password_invalid = true;
}
if ($lowercase_counter == 0) {
    echo "Invalid password: Need at least 1 lowercase letter<br>";
    $password_invalid = true;
}
if ($number_counter == 0) {
    echo "Invalid password: Need at least 1 number<br>";
    $password_invalid = true;
}
if ($special_character_counter == 0) {
    echo "Invalid password: Need at least 1 special character<br>";
    $password_invalid = true;
}

if ($password_invalid == false and $phoneNum_invalid == false and $email_invalid_or_taken == False 
    and $last_name_empty == False and $first_name_empty == False) {

    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Construct an SQL query
    $sql = "INSERT INTO users (first_name, last_name, email, phone_number, password_hash)
            VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$password_hash')";

    // Construct an SQL query
    if (mysqli_query($mysqli, $sql)) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }

    header("Location: login.php");

    // Close the database connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>message</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
    <script src="/js/validation.js" defer></script>
</head>
<body>
    <form action="signup.html" method="post" id="message" novalidate>
        <button>Sign up again</button>
    </form>
    
</body>
</html>
