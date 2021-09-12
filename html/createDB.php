<?php

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
$dsn = 'mysql:dbname=test;host=mysql';
$username = 'dev';
$userpassword = 'dev';


try {

    $db = new PDO($dsn, $username, $userpassword, $options);

    $query = "CREATE TABLE IF NOT EXISTS contacts (
                      id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      email VARCHAR(50) NOT NULL,
                      phone VARCHAR(50) NOT NULL,
                      message VARCHAR(255)
                    )";

    if ($db->query($query)) {

        echo 'New table "contacts" created';
    }

} catch (\Exception $e) {

    echo 'ERROR: ' . $e->getMessage();

} finally {

    $db = null;
}

