<?php

$db = new mysqli("localhost", "simple_php_app", "password", "simple_php_app_db");

if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}

?>
