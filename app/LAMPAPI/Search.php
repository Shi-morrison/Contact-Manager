<?php

// Starting a session to store variables to use later on
session_start();

// Making sure that util functions are included
require_once('utils/utils.php');

// Setting global variable to use database connection for different operations
global $conn;

$dbServer = getenv('DB_SERVER');
$dbUsername = getenv('DB_USERNAME');
$dbPassword = getenv('DB_PASSWORD');
$dbName = getenv('DB_NAME');

// Attempting to establish MySQL database connection
$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

// Unable to connect to MySQL database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // Parsing JSON data from frontend
    $data = parseJsonData();
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $singularName = $data['singularSearchName'];
    $onlyOneName = $data['onlyOneName'];

    $matchingContacts = search($firstName, $lastName, $singularName, $onlyOneName);

    header('Content-Type: application/json');
    echo json_encode($matchingContacts);
} else {

    // Handling for any other request, will not perform any database operations
    $error = 'This request type is not supported';
    returnWithError($error, 400);
}

// Function to search for contacts by first and/or last name
function search($firstName, $lastName, $singularName, $onlyOneName)
{
    global $conn;

    // Getting user_id from session to ensure that we only get contacts from this user
    $user_id = $_SESSION["user_id"];

    // Checking if we should use AND or OR
    if ($onlyOneName) {
        $sql = "SELECT * FROM contacts WHERE user_id = ? AND first_name LIKE ?
                OR user_id = ? AND last_name LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isis", $user_id, $singularName, $user_id, $singularName);
    } else {
        $sql = "SELECT contact_id FROM contacts WHERE user_id = ? AND first_name LIKE ?
                AND user_id = ? AND last_name LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isis", $user_id, $firstName, $user_id, $lastName);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $searchCount = 0;
    $searchResults = array();
    while($row = $result->fetch_assoc())
    {
        $searchCount++;
        array_push($searchResults, $row['contact_id']);
    }

    if( $searchCount == 0 ) {
        returnWithError("No Records Found", 400);
    }

    return array('contact_id' => $searchResults);
}