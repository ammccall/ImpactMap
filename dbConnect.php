<?php
if (session_status() == PHP_SESSION_NONE) {
    session_name("EEC Map");
    session_start();
}

// Set the error reporting level
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Include site constants
require_once "constants.inc.php";
require_once "class.user.php";

// Create a database object
try {
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
    $db = new PDO($dsn, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

$user = new User($db);

?>