<?php

define("DB_HOST", "localhost");
define("DB_NAME", "php_dev");
define("DB_USER", "denis");
define("DB_PASS", "123456");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed" . $conn->connect_error); //die обрывает все соединения с базой и выводит сообщение об ошибке
}

//echo "Connected!";

?>