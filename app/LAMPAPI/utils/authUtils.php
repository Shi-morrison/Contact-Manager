<?php

function userExists($username)
{
    global $conn;

    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM creds WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $stmt->close();

    $row = $result->fetch_assoc();
    $occurences = $row['count'];

    return $occurences >= 1;
}

function getUserID($username)
{
    global $conn;

    $sql = "SELECT user_id FROM creds WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if (!$user_id) {
        $error = "Failed to retrieve user id";
        returnWithError($error, 400);
    }

    return $user_id;
}

function getHashedPassword($username)
{
    global $conn;

    $sql = "SELECT password FROM creds WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (!$hashedPassword) {
        $error = "Username not found";
        returnWithError($error, 400);
    }

    return $hashedPassword;
}