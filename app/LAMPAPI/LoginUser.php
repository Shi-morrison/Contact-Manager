<?php

// Starting a session to store variable to use later on
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
    $password = $data['password'];

    // Attempting to login
    $resultArr = login($username, $password);

    header('Content-Type: application/json');
    echo json_encode($resultArr);

} else {

    // Handling for any other request, will not perform any database operations
    $error = "This request type is not supported";
    returnWithError($error, 400);
}

/**
 * The login function is responsible for signing up a new user and setting
 * session variables to be used in the contact CRUD operations.
 */
function login($username, $password)
{
    // Making sure that user has an account
    if (!userExists($username)) {
        $error = "Failed to log in, user {$username} does not exist";
        returnWithError($error, 400);
    }

    // Getting hashed password and user_id
    $passwordFromDB = getHashedPassword($username);

    // Making sure that inputted password matches that of the user
    if (password_verify($password, $passwordFromDB)) {
        // Setting session variables to use for CRUD operations
        $_SESSION["username"] = $username;
        $user_id = getUserID($username);
        $_SESSION["user_id"] = $user_id;

        return array('user_id' => $user_id);
    } else {
        $error = "Incorrect password, please try again";
        returnWithError($error, 400);
    }
}
