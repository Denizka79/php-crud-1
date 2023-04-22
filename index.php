<?php

include "config/database.php";

$products = [];

$sql_vend = "SELECT vendor FROM products GROUP BY vendor";
$result_vend = mysqli_query($conn, $sql_vend);
$vendors = mysqli_fetch_all($result_vend, MYSQLI_ASSOC);

$sql_type = "SELECT type FROM products GROUP BY type";
$result_type = mysqli_query($conn, $sql_type);
$types = mysqli_fetch_all($result_type, MYSQLI_ASSOC);

$fields = [];
$sql_order = "";

$sql_prod = "SELECT * FROM products";

if (isset($_POST["submit"])) {
    if (isset($_POST["prodtype"]) && $_POST["prodtype"] != '') {
        $prodtype_value = [" type = ", "'" . $_POST["prodtype"] .  "'"];
        array_push($fields, $prodtype_value);
    }
    
    if (isset($_POST["prodvendor"]) && $_POST["prodvendor"] != '') {
        $prodvendor_value = $_POST["prodvendor"];
        array_push($fields, [" vendor = ", "'" . $prodvendor_value . "'"]);
    }
    
    if (isset($_POST["pricefrom"]) && $_POST["pricefrom"] != '') {
        $pricefrom_value = $_POST["pricefrom"];
        array_push($fields, [" price >= ", $pricefrom_value]);
    }
    
    if (isset($_POST["pricetill"]) && $_POST["pricetill"] != '') {
        $pricetill_value = $_POST["pricetill"];
        array_push($fields, [" price <= ", $pricetill_value]);
    }

    if (isset($_POST["sort"]) && $_POST["sort"] != '') {
        $sql_order = " ORDER BY " . $_POST["sort"];
    }
    
    if (count($fields) > 0) {
        $sql_prod = $sql_prod . " WHERE ";
        if (count($fields) == 1) {
            $sql_prod = $sql_prod . $fields[0][0] . $fields[0][1];
        } elseif (count($fields) > 1) {
            $sql_second = "";
            for ($i = 0; $i < count($fields); $i++) {
                if ($i < (count($fields) - 1)) {
                    $sql_and = " AND ";
                } else {
                    $sql_and = "";
                }
                $sql_second = $sql_second . $fields[$i][0] . $fields[$i][1] . $sql_and;
            }
            $sql_prod = $sql_prod . $sql_second;
        }
    }
    $sql_prod = $sql_prod . $sql_order;
}

if (isset($_POST["clear"])) {
    unset($_POST["prodtype"]);
    unset($_POST["prodvendor"]);
    unset($_POST["pricefrom"]);
    unset($_POST["pricetill"]);
    unset($_POST["sort"]);
}

//echo $sql_prod;

$result_prod = mysqli_query($conn, $sql_prod);
$products = mysqli_fetch_all($result_prod, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<!-- <html lang="en"> -->
<head>
    <!-- <meta charset="UTF-8"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 1</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">ТОВАРНЫЕ ПОЗИЦИИ</div>
        <div class="nav">
            <button type="submit">Войти</button>
        </div>
    </header>
    <main>
        <div class="filter">
            <h3>Отфильтровать</h3>
            <form class="search-filter" action="index.php" method="post">
                <p>По производителю:</p>
                <select name="prodvendor" id="">
                    <option selected disabled>Выберите произовдителя</option>
                    <?php foreach($vendors as $vendor) : ?>
                    <option value="<?php echo $vendor["vendor"]; ?>"><?php echo $vendor["vendor"]; ?></option>
                    <?php endforeach; ?>
                </select>
                <p>По типу:</p>
                <select name="prodtype" id="">
                    <option selected disabled>Выберите тип</option>
                    <?php foreach($types as $type) : ?>
                    <option value="<?php echo $type["type"]; ?>"><?php echo $type["type"]; ?></option>
                    <?php endforeach; ?>
                </select>
                <p>По цене:</p>
                <label for="pricefrom">
                    От:
                    <input type="number" name="pricefrom">
                </label>
                <label for="pricetill">
                    До:
                    <input type="number" name="pricetill">
                </label>
                <br>
                <p>Сортировать:</p>
                <select name="sort">
                    <option selected disabled>Выберите вид сортировки</option>
                    <option value="price ASC">По возрастанию цены</option>
                    <option value="price DESC">По убыванию цены</option>
                    <option value="type">По типу</option>
                    <option value="title">По алфавиту</option>
                </select>
                <br>
                <button type="submit" name="submit">Искать</button>
                <button type="submit" name="clear">Очистить</button>
            </form>
        </div>
        <div class="items">
            <div class="items-header">
                <a class="add-new-item" href="new.php">Создать новый</a>
            </div>
            <table>
                <th>ТОВАР</th>
                <th>ОПИСАНИЕ</th>
                <th>ЦЕНА</th>
                <?php foreach($products as $prod) : ?>
                <tr>
                    <td class="prodname"><?php echo $prod["title"] ?></td>
                    <td><?php echo $prod["description"] ?></td>
                    <td><?php echo $prod["price"] ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($products)) :  ?>
                    <tr>
                        <td colspan="3">Нет товаров для отображения</td>
                    </tr>
                <?php endif; ?>
            </table>
    </main>
    <footer>&#169; Denis Meshcheryakov</footer>
</body>
</html>