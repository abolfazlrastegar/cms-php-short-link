<?php
$config = require('./config/database.php');
$servername = $config['SERVERNAME'];
$username = $config['USERNAME'];
$password = $config['PASSWORD'];
$dbname = $config['DBNAME'];

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql_database = "CREATE DATABASE $dbname";

    if ($conn->exec($sql_database)) {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql_user = "CREATE TABLE users (
          id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          username  VARCHAR(50) UNIQUE NOT NULL,
          password TEXT UNIQUE NOT NULL,
          email VARCHAR(50),
          token TEXT UNIQUE NULL,
          end_time_token TIMESTAMP,
          status BOOLEAN DEFAULT 1,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          )";
        $conn->exec($sql_user);

        $sql_links = "CREATE TABLE links (
          id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          user_id BIGINT UNIQUE,
          url  TEXT NOT NULL,
          short VARCHAR(255)  NOT NULL,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          )";
        $conn->exec($sql_links);
    }
    echo "Database created and Table successfully";
} catch(PDOException $e) {
    echo $e->getMessage();
}

$conn = null;
?>
