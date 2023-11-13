<?php
// Retrieve data from the POST request
$customerName = $_POST['customerName'];
$answers = json_decode($_POST['answers'], true);

// Connect to your MySQL database (replace these with your actual database details)
$host = 'your_database_host';
$username = 'your_database_username';
$password = 'your_database_password';
$database = 'your_database_name';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data into the database
$sql = "INSERT INTO forms (customer_name, form_id, question_name, answer) VALUES ";
$formId = time(); // Timestamp as the form ID

foreach ($answers as $answer) {
    $sql .= "('$customerName', '$formId', '{$answer['name']}', '{$answer['value']}'),";
}

$sql = rtrim($sql, ',');

if ($conn->query($sql) === TRUE) {
    // Return the form ID as JSON response
    echo json_encode(['formId' => $formId]);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
