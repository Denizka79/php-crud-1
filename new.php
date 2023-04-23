<?php

include "config/database.php";

$itemname = '';
$itemdesc = '';
$itemprice = '';
$itemvendor = '';
$itemtype = '';
$itemnameErr = '';
$itemdescErr = '';
$itempriceErr = '';
$itemvendorErr = '';
$itemtypeErr = '';

if (isset($_POST["submit"])) {
    if (empty($_POST["itemname"])) {
        $itemnameErr = "Item name is required";
    } else {
        $itemname = filter_input(INPUT_POST, "itemname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["itemdesc"])) {
        $itemdescErr = "Item description is required";
    } else {
        $itemdesc = filter_input(INPUT_POST, "itemdesc", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["itemprice"])) {
        $itempriceErr = "Item price is required";
    } else {
        $itemprice = filter_input(INPUT_POST, "itemprice", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["itemvendor"])) {
        $itemvendorErr = "Item vendor is required";
    } else {
        $itemvendor = filter_input(INPUT_POST, "itemvendor", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["itemtype"])) {
        $itemtypeErr = "Item type is required";
    } else {
        $itemtype = filter_input(INPUT_POST, "itemtype", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($itemnameErr) && empty($itemdescErr) && empty($itempriceErr) && empty($itemvendorErr) && empty($itemtypeErr)) {
        $sql = "INSERT INTO products (title, description, price, vendor, type) VALUES ('$itemname', '$itemdesc', '$itemvendor', '$itemtype')";

        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo "Error" . mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new item</title>
</head>
<body>
    <form class="new-item" action="index.php" method="POST">
        <label for="newitemname">
            Название:
            <input type="text" name="newitemname">
        </label>
        <label for="newitemdesc">
            Описание:
            <input type="text" name="newitemdesc">
        </label>
        <label for="newitemprice">
            Цена:
            <input type="number" name="newitemprice">
        </label>
        <label for="newitemtype">
            Тип:
            <input type="text" name="newitemdesc">
        </label>
        <label for="newitemvendor">
            Описание:
            <input type="text" name="newitemdesc">
        </label>
    </form>
</body>
</html>