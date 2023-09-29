<?php

// Starting a session to store variables to use later on
session_start();

// Making sure that util functions are included
require_once('utils/utils.php');
require_once('utils/authUtils.php');

// Setting global variable to use database connection for different operations
global $conn;

$dbServer = getenv('DB_SERVER');
$dbUsername = getenv('DB_USERNAME');
$dbPassword = getenv('DB_PASSWORD');
$dbName = getenv('DB_NAME');

// Attempting to establish MySQL database connection
$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

// Unable to connect to MySQL database
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Attempting to logout
    $result = logout();

    header('Content-Type: application/json');
    echo json_encode($result);

}

// Logout function to ensure that user info is removed after logging out
function logout()
{
    // Clearing session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Check for any session variables
    if (isset($_SESSION['username']) || isset($_SESSION['user_id'])) {
        $error = "Failed to log out";
        returnWithError($error, 400);
    }

    return array('msg' => "Logout was successful");
}
