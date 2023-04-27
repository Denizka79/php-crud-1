<?php

include "include/header.php";

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

if (isset($_POST["newitemsubmit"])) {
    if (empty($_POST["newitemname"])) {
        $itemnameErr = "Item name is required";
    } else {
        $itemname = filter_input(INPUT_POST, "newitemname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["newitemdesc"])) {
        $itemdescErr = "Item description is required";
    } else {
        $itemdesc = filter_input(INPUT_POST, "newitemdesc", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["newitemprice"])) {
        $itempriceErr = "Item price is required";
    } else {
        $itemprice = filter_input(INPUT_POST, "newitemprice", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["newitemvendor"])) {
        $itemvendorErr = "Item vendor is required";
    } else {
        $itemvendor = filter_input(INPUT_POST, "newitemvendor", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["newitemtype"])) {
        $itemtypeErr = "Item type is required";
    } else {
        $itemtype = filter_input(INPUT_POST, "newitemtype", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($itemnameErr) && empty($itemdescErr) && empty($itempriceErr) && empty($itemvendorErr) && empty($itemtypeErr)) {
        $sql = "INSERT INTO products (title, description, price, vendor, type) VALUES ('$itemname', '$itemdesc', '$itemprice', '$itemvendor', '$itemtype')";

        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo "Error" . mysqli_error($conn);
        }
    } else {
        echo $itemnameErr . " " . $itemdescErr . " " . $itempriceErr . " " . $itemvendorErr . " " . $itemtypeErr;
    }
}

?>

    <main class="main-new-item">
        <form class="new-item" action="new.php" method="POST">
            <h2>Новая товарная позиция</h2>
            <div class="new-item-name">
                <p>Название:</p>
                <input class="new-item-input" type="text" name="newitemname">
            </div>
            <div class="new-item-description">
                <p>Описание:</p>
                <input class="new-item-input" type="text" name="newitemdesc">
            </div>
            <div class="new-item-price">
                <p> Цена:</p>
                <input class="new-item-input" type="number" name="newitemprice">
            </div>
            <div class="new-item-type">
                <p>Тип:</p>
                <input class="new-item-input" type="text" name="newitemtype">
            </div>
            <div class="new-item-vendor">
                <p>Производитель:</p>
                <input class="new-item-input" type="text" name="newitemvendor">
            </div>
            <div class="new-item-submit">
                <input type="submit" name="newitemsubmit" value="Создать">
            </div>
        </form>
        <a class="to-main-page" href="index.php">На главную</a>
    </main>
    
<?php include "include/footer.php"; ?>