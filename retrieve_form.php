<?php
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

// Get customer name from the query string
$customerName = $_GET['customerName'];

// Retrieve form details from the database
$sql = "SELECT * FROM forms WHERE customer_name = '$customerName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Format form details as an HTML table
    $formDetails = '<table border="1"><tr><th>Form ID</th><th>Question Name</th><th>Answer</th></tr>';

    while ($row = $result->fetch_assoc()) {
        $formDetails .= "<tr><td>{$row['form_id']}</td><td>{$row['question_name']}</td><td>{$row['answer']}</td></tr>";
    }

    $formDetails .= '</table>';

    // Return form details as JSON response
    echo json_encode(['formDetails' => $formDetails]);
} else {
    // Return an error if no forms are found
    echo json_encode(['error' => 'No forms found for the given customer name.']);
}

$conn->close();
?>
