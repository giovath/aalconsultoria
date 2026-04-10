<?php
define('DB_HOST', 'sql311.infinityfree.com');
define('DB_USER', 'if0_37794199');
define('DB_PASS', 'UkD5gDkTCAnfejp');
define('DB_NAME', 'if0_37794199_aalconsultoria');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
