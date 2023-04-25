<?php

include "config/database.php";

if (isset($_GET["id"]) && $_GET["id"] != "") {
    $id = $_GET["id"];
    $sql_del = "DELETE FROM products WHERE `products`.`id` = '$id'";
    if (mysqli_query($conn, $sql_del)) {
        header('Location: index.php');
    } else {
        echo "Error" . mysqli_error($conn);
    }
} else {
    echo 'Отсутствует ID товара';
}

?>