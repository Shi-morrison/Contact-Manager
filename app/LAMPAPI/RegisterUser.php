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

    // Parsing JSON data from frontend
    $data = parseJsonData();
    $username = $data['username'];
    $newPassword = $data['new_password'];
    $confirmPassword = $data['confirm_password'];

    // Attempting to register a new user with info
    $newUserID = register($username, $newPassword, $confirmPassword);

    header('Content-Type: application/json');
    echo json_encode($newUserID);

} else {

    // Handling for any other request, will not perform any database operations
    $error = "This request type is not supported";
    returnWithError($error, 400);

}

/**
 * The register function is responsible for signing up a new user and setting
 * session variables to be used in the contact CRUD operations.
 */
function register($username, $newPassword, $confirmPassword)
{
    // Only allowing for one user per username
    if (userExists($username))
    {
        $error = "Username already exists";
        returnWithError($error, 400);
    }

    // Ensuring that passwords were match
    if ($newPassword !== $confirmPassword)
    {
        $error = "Passwords must match";
        returnWithError($error, 400);
    }

    global $conn;

    // Hashing password for security
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Using SQL query to insert username and hashed password into creds table
    $sql = "INSERT INTO creds (username, password) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashedPassword);
    $success = $stmt->execute();
    $stmt->close();

    // Getting user_id of this user to return to frontend
    $user_id = $conn->insert_id;
    $conn->close();

    // Setting session variables to use later on
    $_SESSION["user_id"] = $user_id;
    $_SESSION["username"] = $username;

    return array('user_id' => $user_id);
}
