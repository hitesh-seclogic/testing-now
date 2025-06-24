<?php
// Vulnerable PHP Application - FOR TESTING PURPOSES ONLY
// This file contains intentional vulnerabilities for scanner testing

// SQL Injection Vulnerability
function authenticateUser($username, $password) {
    $conn = new mysqli("localhost", "root", "password", "users_db");
    
    // Vulnerable query - no prepared statements
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);
    
    return $result->num_rows > 0;
}

// Cross-Site Scripting (XSS) Vulnerability
function displayUsername() {
    if (isset($_GET['username'])) {
        // Vulnerable - direct output of user input without sanitization
        echo "Welcome, " . $_GET['username'];
    }
}

// Command Injection Vulnerability
function pingHost() {
    if (isset($_POST['host'])) {
        $host = $_POST['host'];
        // Vulnerable - direct use of user input in system command
        system("ping -c 4 " . $host);
    }
}

// File Inclusion Vulnerability
function loadPage() {
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        // Vulnerable - allows arbitrary file inclusion
        include($page);
    }
}

// Insecure File Operations
function saveData() {
    if (isset($_POST['filename']) && isset($_POST['data'])) {
        $filename = $_POST['filename'];
        $data = $_POST['data'];
        
        // Vulnerable - no path validation
        file_put_contents($filename, $data);
        echo "Data saved to $filename";
    }
}

// Insecure Deserialization
function loadUserProfile() {
    if (isset($_COOKIE['user_profile'])) {
        // Vulnerable - unsafe deserialization of user-controlled data
        $profile = unserialize(base64_decode($_COOKIE['user_profile']));
        return $profile;
    }
    return null;
}

// Outdated Library (fictional, for demonstration)
require_once('vendor/vulnerable-library/v1.0.0/lib.php');

// Insecure Random Number Generation
function generateToken() {
    // Vulnerable - using insecure random number generation
    return md5(rand());
}

// Insecure Password Storage
function createUser($username, $password) {
    // Vulnerable - storing plaintext passwords
    $conn = new mysqli("localhost", "root", "password", "users_db");
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    $conn->query($query);
}

// Main application logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'login':
                authenticateUser($_POST['username'], $_POST['password']);
                break;
            case 'ping':
                pingHost();
                break;
            case 'save':
                saveData();
                break;
            case 'create_user':
                createUser($_POST['username'], $_POST['password']);
                break;
        }
    }
}

displayUsername();
loadPage();
$profile = loadUserProfile();
$token = generateToken();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable PHP Application</title>
</head>
<body>
    <h1>Vulnerable PHP Application</h1>
    <p>This application contains intentional vulnerabilities for testing security scanners. DO NOT USE IN PRODUCTION.</p>
    
    <h2>Login Form (SQL Injection)</h2>
    <form method="POST">
        <input type="hidden" name="action" value="login">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Login">
    </form>
    
    <h2>Ping Host (Command Injection)</h2>
    <form method="POST">
        <input type="hidden" name="action" value="ping">
        Host: <input type="text" name="host"><br>
        <input type="submit" value="Ping">
    </form>
    
    <h2>Save Data (Insecure File Operations)</h2>
    <form method="POST">
        <input type="hidden" name="action" value="save">
        Filename: <input type="text" name="filename"><br>
        Data: <textarea name="data"></textarea><br>
        <input type="submit" value="Save">
    </form>
    
    <h2>Create User (Insecure Password Storage)</h2>
    <form method="POST">
        <input type="hidden" name="action" value="create_user">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="Create User">
    </form>
</body>
</html>
