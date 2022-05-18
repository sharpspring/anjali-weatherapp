<?php
/**
 * This code is only meant to show a working MySQL connection and is therefore
 * not a complete implementation of the weather app project.
 */

define('MYSQL_USERNAME', 'weatherapp');
define('MYSQL_PASSWORD', 'let me in');

function connectToDB() {
    return new PDO('mysql:host=mariadb;dbname=weatherapp', MYSQL_USERNAME, MYSQL_PASSWORD);
}

function getLocation() {
    $pdo = connectToDB();
    $stmt = $pdo->query('select city_name, state_abbreviation from location');
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

print_r(getLocation());

?>
