<?php

include "config/database.php";

$products = [];

$sql_vend = "SELECT vendor FROM products GROUP BY vendor";
$result_vend = mysqli_query($conn, $sql_vend);
$vendors = mysqli_fetch_all($result_vend, MYSQLI_ASSOC);

$sql_type = "SELECT type FROM products GROUP BY type";
$result_type = mysqli_query($conn, $sql_type);
$types = mysqli_fetch_all($result_type, MYSQLI_ASSOC);

$sql_prod = "SELECT * FROM products";
$sql_and = '';
$sql_where = '';
$fields = [];

if (!empty($_POST["prodtype"])) {
    $filter_prodtype = $_POST["prodtype"];
    $sql_prodtype = " type = " . $filter_prodtype;
    array_push($fields, $filter_prodtype);
    //$sql_prod = $sql_prod . $sql_prodtype;
}

if (!empty($_POST["prodvendor"])) {
    $filter_vendor = $_POST["prodvendor"];
    $sql_prodvendor = " vendor = " . $filter_vendor;
    array_push($fields, $filter_vendor);
    //$sql_prod = $sql_prod . $sql_prodvendor;
}

if (!empty($_POST["pricefrom"])) {
    $filter_pricefrom = $_POST["pricefrom"];
    array_push($fields, $filter_pricefrom);
    //$sql_prod = $sql_prod . $sql_pricefrom;
}

if (!empty($_POST["pricetill"])) {
    $filter_pricetill = $_POST["pricetill"];
    array_push($fields, $filter_pricetill);
    //$sql_prod = $sql_prod . $sql_pricetill;
}

if (count($fields) > 0) {
    $sql_where = " WHERE ";
    if (!empty($filter_pricetill)) {
        $sql_pricetill = " price <= " . $filter_pricefrom;
    } elseif (!empty($filter_pricefrom)) {
        $sql_pricefrom = " price >= " . $filter_pricefrom;
    }
}

//echo $sql_prod;
//var_dump($fields);
//echo count($fields);

/* $result_prod = mysqli_query($conn, $sql_prod);
$products = mysqli_fetch_all($result_prod, MYSQLI_ASSOC); */

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
                    <option value=""></option>
                    <?php foreach($vendors as $vendor) : ?>
                    <option value="<?php echo $vendor["vendor"]; ?>"><?php echo $vendor["vendor"]; ?></option>
                    <?php endforeach; ?>
                </select>
                <p>По типу:</p>
                <select name="prodtype" id="">
                    <option value=""></option>
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
                <button type="submit">Искать</button>
            </form>
        </div>
        <div class="items">
            <table>
                <th>ТОВАР</th>
                <th>ОПИСАНИЕ</th>
                <th>ЦЕНА</th>
                <?php foreach($products as $prod) : ?>
                <tr>
                    <td><?php echo $prod["title"] ?></td>
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