<?php

include "config/database.php";

$sql_prod = "SELECT * FROM crud";
$result_prod = mysqli_query($conn, $sql_prod);
$products = mysqli_fetch_all($result_prod, MYSQLI_ASSOC);

$sql_vend = "SELECT vendor FROM crud GROUP BY vendor";
$result_vend = mysqli_query($conn, $sql_vend);
$vendors = mysqli_fetch_all($result_vend, MYSQLI_ASSOC);

//var_dump($vendors);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            <form class="search-filter" action="submit.php" method="post">
                <p>По производителю:</p>
                <select name="prodvendor" id="">
                    <?php foreach($vendors as $vendor) : ?>
                    <option value="<?php echo $vendor["vendor"]; ?>"><?php echo $vendor["vendor"]; ?></option>
                    <?php endforeach; ?>
                </select>
                <p>По типу:</p>
                <select name="prodtype" id="">
                    <option value="volvo">Volvo</option>
                    <option value="Saab">Saab</option>
                    <option value="Mercedes">Mercedes</option>
                    <option value="Audi">Audi</option>
                </select>
                <p>По цене:</p>
                <label for="pricefrom">
                    От:
                    <input type="number">
                </label>
                <label for="pricetill">
                    До:
                    <input type="number">
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
                <!-- <tr>
                    <td>Товар 1</td>
                    <td>Хороший товар</td>
                    <td>10000</td>
                </tr>
                <tr>
                    <td>Товар 2</td>
                    <td>Хороший товар</td>
                    <td>10000</td>
                </tr>
                <tr>
                    <td>Товар 3</td>
                    <td>Хороший товар</td>
                    <td>10000</td>
                </tr> -->
            </table>
        <?php if (empty($products)) :  ?>
            <p>В каталоге отсутствуют товары</p>
        <?php endif; ?>
    </main>
    <footer>&#169; Denis Meshcheryakov</footer>
</body>
</html>