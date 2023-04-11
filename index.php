<?php

include "config/database.php";

$sql = "SELECT * FROM crud";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
<?php if (empty($products)) :  ?>
    <p>В каталоге отсутствуют товары</p>
<?php endif; ?>
    <table>
        <tr>
            <th>Товар</th>
            <th>Описание</th>
            <th>Цена</th>
        </tr>
<?php foreach($products as $prod) : ?>
        <tr>
            <td><?php echo $prod["title"] ?></td>
            <td><?php echo $prod["description"] ?></td>
            <td><?php echo $prod["price"] ?></td>
        </tr>
<?php endforeach; ?>
    </table>
</body>
</html>