<?php

// Function to parse the JSON from the frontend, return an array containing the JSON data
function parseJsonData()
{
    $jsonData = file_get_contents('php://input');

    // Check if getting the contents failed
    if ($jsonData === false) {
        $error = "Failed to read JSON data from the request body.";
        returnWithError($error, 400);
    }

    $data = json_decode($jsonData, true);

    // Check if decoding JSON failed
    if ($data === null) {
        $error = "Failed to parse JSON data.";
        returnWithError($error, 400);
    }

    // Returning the JSON data as an array if parsing was successful
    return $data;
}

// Function to format error with error string and response code
function returnWithError($err, $responseCode)
{
    global $conn;

    http_response_code($responseCode);

    // Make the response a JSON
    $obj = array('error' => $err);
    header('Content-Type: application/json');
    echo json_encode($obj);

    // Close global SQL connection
    $conn->close();

    exit;
}