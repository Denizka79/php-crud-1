<?php

include "include/header.php";

$update_id = '';
$products = [];
$prod_name = '';
$prod_desc = '';
$prod_price = '';
$prod_type = '';
$prod_vend = '';

$upd_id = '';
$upd_prod_name = '';
$upd_prod_desc = '';
$upd_prod_price = '';
$upd_prod_type = '';
$upd_prod_vend = '';
$upd_prod_name_err = '';
$upd_prod_desc_err = '';
$upd_prod_price_err = '';
$upd_prod_type_err = '';
$upd_prod_vend_err = '';
$upd_id_err = '';

if (isset($_GET["id"]) && $_GET["id"] != "") {
    $update_id = $_GET["id"];
    $sql_prod = "SELECT * FROM products WHERE id = '$update_id'";
    $result_prod = mysqli_query($conn, $sql_prod);
    $products = mysqli_fetch_assoc($result_prod);
    $prod_name = $products["title"];
    $prod_desc = $products["description"];
    $prod_price = $products["price"];
    $prod_type = $products["type"];
    $prod_vend = $products["vendor"];
}

if (isset($_POST["upditemsubmit"])) {
    if (empty($_POST["updid"])) {
        $upd_id_err = "Item ID is required";
    } else {
        $upd_id = filter_input(INPUT_POST, "updid", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["upditemname"])) {
        $upd_prod_name_err = "Item name is required";
    } else {
        $upd_prod_name = filter_input(INPUT_POST, "upditemname", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["upditemdesc"])) {
        $upd_prod_desc_err = "Item description is required";
    } else {
        $upd_prod_desc = filter_input(INPUT_POST, "upditemdesc", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["upditemprice"])) {
        $upd_prod_price_err = "Item price is required";
    } else {
        $upd_prod_price = filter_input(INPUT_POST, "upditemprice", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["upditemvendor"])) {
        $upd_prod_vend_err = "Item vendor is required";
    } else {
        $upd_prod_vend = filter_input(INPUT_POST, "upditemvendor", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($_POST["upditemtype"])) {
        $upd_prod_type_err = "Item type is required";
    } else {
        $upd_prod_type = filter_input(INPUT_POST, "upditemtype", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    if (empty($upd_id_err) && empty($upd_prod_name_err) && empty($upd_prod_desc_err) && empty($upd_prod_price_err) && empty($upd_prod_type_err) && empty($upd_prod_vend_err)) {
        $sql_upd = "UPDATE `products` SET `title` = '$upd_prod_name', `description` = '$upd_prod_desc', `price` = '$upd_prod_price', `vendor` = '$upd_prod_vend', `type` = '$upd_prod_type' WHERE `products`.`id` = '$upd_id'";

        echo $sql_upd;

        if (mysqli_query($conn, $sql_upd)) {
            header('Location: index.php');
        } else {
            echo "Error" . mysqli_error($conn);
        }
    } else {
        echo $upd_id_err . " " . $upd_prod_name_err . " " . $upd_prod_desc_err . " " . $upd_prod_price_err . " " . $upd_prod_type_err . " " . $upd_prod_vend_err;
    }
}

?>

    <main class="main-upd-item">
        <form class="upd-item" action="update.php" method="POST">
            <input type="hidden" value="<?php echo $update_id; ?>" name="updid">
            <h2>Редактировать товарную позицию</h2>
            <div class="upd-item-name">
                <p>Название:</p>
                <input class="upd-item-input" type="text" name="upditemname" value="<?php echo $prod_name; ?>">
            </div>
            <div class="upd-item-description">
                <p>Описание:</p>
                <input class="upd-item-input" type="text" name="upditemdesc" value="<?php echo $prod_desc; ?>">
            </div>
            <div class="upd-item-price">
                <p> Цена:</p>
                <input class="upd-item-input" type="number" name="upditemprice" value="<?php echo $prod_price; ?>">
            </div>
            <div class="upd-item-type">
                <p>Тип:</p>
                <input class="upd-item-input" type="text" name="upditemtype" value="<?php echo $prod_type; ?>">
            </div>
            <div class="upd-item-vendor">
                <p>Производитель:</p>
                <input class="upd-item-input" type="text" name="upditemvendor" value="<?php echo $prod_vend; ?>">
            </div>
            <div class="upd-item-submit">
                <input type="submit" name="upditemsubmit" value="Обновить">
            </div>
        </form>
        <a class="to-main-page" href="index.php">На главную</a>
    </main>
    
    <?php include "include/footer.php"; ?>