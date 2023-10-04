<?php

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

/** 
 * This string of conditionals is responsible for handling all of the requests
 * from the frontend. The POST request is responsible for (C)reating a contact,
 * the GET request is responsible for (R)eading contacts, the PUT request is
 * responsible for (U)pdating a contact, and the DELETE request is responsible
 * for (D)eleting contact
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Parsing JSON data from frontend
    $data = parseJsonData();
    $user_id = $data['user_id'];
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $email = $data['email'];
    $phone = $data['phone'];

    // We exit if the contact is not valid or there is a duplicate
    validateContact($first_name, $email, $phone);
    checkForDuplicate($user_id, $first_name, $last_name);

    // Attempting to add contact with given information to the user with user_id
    $newContactID = addContact($user_id, $first_name, $last_name, $email, $phone);

    header('Content-Type: application/json');
    echo json_encode($newContactID);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Retrieve query parameters
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
    $contact_id = isset($_GET['contact_id']) ? $_GET['contact_id'] : null;

    if (is_null($contact_id) || $contact_id == "null") {
        // Attempting to read all contacts of user with user_id
        $contacts = getAllContacts($user_id);
    } else {
        // Attempting to read a specific contact with contact_id
        $contacts = getContact($user_id, $contact_id);
    }

    header('Content-Type: application/json');
    echo json_encode($contacts);


    // // Parsing JSON data from frontend
    // $data = parseJsonData();
    // $user_id = $data['user_id'];
    // $contact_id = $data['contact_id'];


    // if ($contact_id == "null") {
    //     // Attempting to read all contacts of user with user_id
    //     $contacts = getAllContacts($user_id);
    // } else {
    //     // Attempting to read a specific contact with contact_id
    //     $contacts = getContact($user_id, $contact_id);
    // }

    // header('Content-Type: application/json');
    // echo json_encode($contacts);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    // Parsing JSON data from frontend
    $data = parseJsonData();
    $contact_id = $data['contact_id'];
    $newFirstName = $data['first_name'];
    $newLastName = $data['last_name'];
    $newEmail = $data['email'];
    $newPhone = $data['phone'];

    // Attempting to edit the contact of contact with contact_id
    $updated = editContact($contact_id, $newFirstName, $newLastName, $newEmail, $newPhone);

    header('Content-Type: application/json');
    echo json_encode($updated);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

    // Parsing JSON data from frontend
    $data = parseJsonData();
    $contact_id = $data['contact_id'];

    // Attempting to delete the contact with contact_id
    // EDIT FOR WARNING/ERROR
    deleteContact($contact_id);
    // Had to Add to ensure json response
    echo json_encode(["status" => "success", "message" => "Contact deleted successfully"]);

} else {

    // Handling for any other request, will not perform any database operations
    $error = "This request type is not supported";
    returnWithError($error, 400);
}

// Function to add a contact to the database
function addContact($user_id, $firstName, $lastName, $email, $phone)
{
    global $conn;

    // Getting current date to set date_created column for contact
    $date = date('Y-m-d');

    // Using SQL query to insert contact information outlined in database schema
    $sql = "INSERT INTO contacts (user_id, first_name, last_name, email, phone, date_created)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $firstName, $lastName, $email, $phone, $date);
    $success = $stmt->execute();
    $stmt->close();

    if (!$success) {
        $error = "Failed to add contact to database";
        returnWithError($error, 400);
    }

    // Returning response code 201 to indicate a successful creation
    http_response_code(201);

    // Getting contact_id of this contact to return to frontend
    $lastInsertId = $conn->insert_id;
    $conn->close();

    return array('contact_id' => $lastInsertId);
}

// Function to get a specific contact when given a user_id and contact_id
function getContact($user_id, $contact_id)
{
    global $conn;

    // Using SQL query to get contact outlined in database schema
    $sql = "SELECT * FROM contacts WHERE user_id = ? AND contact_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $contact_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Check if this contact_id doesn't exist in which case we exit with error
    if ($row === null) {
        $error = "Error retrieving contact";
        returnWithError($error, 400);
    }

    $stmt->close();
    $conn->close();

    // Return the row with the specific contact information
    return $row;
}


// Function to get all contacts for a user with user_id
function getAllContacts($user_id)
{
    global $conn;

    // Using SQL query to get contacts outlined in database schema
    $sql = "SELECT * FROM contacts WHERE user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();

    // Iterate through rows and add contacts information to an array
    $contacts = array();
    while ($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }

    // Return array with all contacts for user_id
    return array('contacts' => $contacts);
}

// This function calls the helper edit functions to edit subfields of the contact
function editContact($contact_id, $newFirstName, $newLastName, $newEmail, $newPhone)
{
    // Updating each field of the contact to the new value if it is not "null"
    $success = true;
    if ($newFirstName != "null") {
        $success = $success & editFirstName($contact_id, $newFirstName);
    }

    if ($newLastName != "null") {
        $success = $success & editLastName($contact_id, $newLastName);
    }

    if ($newEmail != "null") {
        $success = $success & editEmail($contact_id, $newEmail);
    }

    if ($newPhone != "null") {
        $success = $success & editPhone($contact_id, $newPhone);
    }

    // Setting status code to 200 to indicate success
    http_response_code(200);

    // returning newly updated contact_id
    return array('contact_id' => $contact_id);
}

// Helper function of editContact() to edit the first name
function editFirstName($contact_id, $newFirstName)
{
    global $conn;

    // SQL query to set the first_name to the new value
    $sql = "UPDATE contacts SET first_name = ? WHERE contact_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newFirstName, $contact_id);
    $stmt->execute();

    if (!$stmt->execute()) {
        $error = "Error updating first name: " . $stmt->error;
        $stmt->close();
        returnWithError($error, 400);
    }

    $stmt->close();
    return true;
}

// Helper function of editContact() to edit the last name
function editLastName($contact_id, $newLastName)
{
    global $conn;

    // SQL query to set the last_name to the new value
    $sql = "UPDATE contacts SET last_name = ? WHERE contact_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newLastName, $contact_id);
    $stmt->execute();

    if (!$stmt->execute()) {
        $error = "Error updating last name: " . $stmt->error;
        $stmt->close();
        returnWithError($error, 400);
    }

    $stmt->close();
    return true;
}

// Helper function of editContact() to edit the email
function editEmail($contact_id, $newEmail)
{
    global $conn;

    // SQL query to set the email to the new value
    $sql = "UPDATE contacts SET email = ? WHERE contact_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newEmail, $contact_id);
    $stmt->execute();

    if (!$stmt->execute()) {
        $error = "Error updating email: " . $stmt->error;
        $stmt->close();
        returnWithError($error, 400);
    }

    $stmt->close();
    return true;
}

// Helper function of editContact() to edit the phone number
function editPhone($contact_id, $newPhone)
{
    global $conn;

    // SQL query to set the phone number to the new value
    $sql = "UPDATE contacts SET phone = ? WHERE contact_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newPhone, $contact_id);
    $stmt->execute();

    if (!$stmt->execute()) {
        $error = "Error updating phone number: " . $stmt->error;
        $stmt->close();
        returnWithError($error, 400);
    }

    $stmt->close();
    return true;
}

// Function to delete the contact with contact_id from database
function deleteContact($contact_id)
{
    global $conn;

    // SQL query to delete the contact
    $sql = "DELETE FROM contacts WHERE contact_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $contact_id);
    $stmt->execute();

    // Check for failed execution of deletion
    if (!$stmt->execute()) {
        $error = "Error deleting records: " . $stmt->error;
        $stmt->close();
        returnWithError($error, 400);
    }

    $stmt->close();

    // Using code 204 to designate that there is no content to return
    // CHANGE TO 200 
    // http_response_code(204);
}

/**
 * My definition of a valid contact is one that has some valid name associated
 * with either an email or phone number. Returns true if the contact is valid,
 * returns an error if not.
 */
function validateContact($firstName, $email, $phone)
{
    global $conn;

    // Checking that first name is valid
    if (!is_string($firstName) || (trim($firstName) === "")) {
        $error = "Please provide a valid First Name";
        returnWithError($error, 400);
    }

    $emailExists = trim($email) !== "";
    $phoneExists = trim($phone) !== "";

    // Ensuring that there is an email or a phone number to use with the contact
    if (!$emailExists && !$phoneExists) {
        $error = "Contacts require either a valid Email or Phone Number";
        returnWithError($error, 400);
    }

    // Checking that email has email doesn't have xxx@xxx.xxx format
    $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$validEmail && $emailExists) {
        $error = "Invalid Email Address";
        returnWithError($error, 400);
    }

    // Checking that phone only has numbers and dashes
    $filteredPhone = str_replace('-', '', $phone);
    $validPhone = is_numeric($filteredPhone);
    if (!$validPhone && $phoneExists) {
        $error = "Invalid Phone Number";
        returnWithError($error, 400);
        exit;
    }

    return true;
}

/**
 * Function to make sure that a contact has not already been added with the
 * first and last name under a user_id. Returns an error if contact already exits
 */
function checkForDuplicate($user_id, $first_name, $last_name)
{
    global $conn;

    // Using SQL query to count how many rows exist with a user_id and the same
    // first and last name
    $sql = "SELECT COUNT(*) AS count FROM contacts WHERE user_id = ? AND first_name = ? AND last_name = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $first_name, $last_name);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $stmt->close();

    // If the count is greater than 0, data already exists with this first and last name
    if ($row['count'] > 0) {
        $error = "A contact already exists with this first and last name";
        returnWithError($error, 400);
    }

    return true;
}