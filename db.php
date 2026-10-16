<?php
// Database connection (MySQL) + session start
session_start();

$host = 'localhost';
$user = 'root';        // change if your MySQL user is different
$pass = '';            // your MySQL password (XAMPP default is empty)
$dbname = 'gayatriaws';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

function e($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
