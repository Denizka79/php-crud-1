<?php

include "include/header.php";

$products = [];

//Получаем список производителей из базы и сохраняем в массив vendors
$sql_vend = "SELECT vendor FROM products GROUP BY vendor";
$result_vend = mysqli_query($conn, $sql_vend);
$vendors = mysqli_fetch_all($result_vend, MYSQLI_ASSOC);

//Получаем список типов (TV, smartphone и т.п.) и сохраняем в массив types
$sql_type = "SELECT type FROM products GROUP BY type";
$result_type = mysqli_query($conn, $sql_type);
$types = mysqli_fetch_all($result_type, MYSQLI_ASSOC);

//Инициализируем массив fields, в который будем записывать части SQL-запроса, что бы потом сформировать при необходимости запрос с нужными полями
$fields = [];
//Инициализируем переменную sql_order, в которую будем записывать часть SQL-запроса ORDER BY для случаев когда пользователь захочет отсортировать результат запроса данных
$sql_order = "";

//Записываем в переменную sql_prod базовую часть SQL-запроса, который будет возвращать всё содержимое таблицы products
$sql_prod = "SELECT * FROM products";

//Проверяем была ли нажата кнопка submit
if (isset($_POST["submit"])) {
    //Проверяем есть ли фильтрация по типу продукта
    if (isset($_POST["prodtype"]) && $_POST["prodtype"] != '') {
        //И если есть - создаем часть SQL-запроса, которая будет фильтровать данные по значению поля type
        $prodtype_value = [" type = ", "'" . $_POST["prodtype"] .  "'"];
        //А затем записываем в массив fields
        array_push($fields, $prodtype_value);
    }
    
    //То же самое, что и выше, но для поля vendor (производитель)
    if (isset($_POST["prodvendor"]) && $_POST["prodvendor"] != '') {
        $prodvendor_value = $_POST["prodvendor"];
        array_push($fields, [" vendor = ", "'" . $prodvendor_value . "'"]);
    }
    
    //то же самое если выбрана фильтрация по цене не ниже какого-то значения
    if (isset($_POST["pricefrom"]) && $_POST["pricefrom"] != '') {
        $pricefrom_value = $_POST["pricefrom"];
        array_push($fields, [" price >= ", $pricefrom_value]);
    }
    
    //то же самое если выбрана фильтрация по цене не выше какого-то значения
    if (isset($_POST["pricetill"]) && $_POST["pricetill"] != '') {
        $pricetill_value = $_POST["pricetill"];
        array_push($fields, [" price <= ", $pricetill_value]);
    }

    //сортировка: здесь в переменную sql_oreder помимо ORDER BY вносим значения из тэгов option-select ниже
    if (isset($_POST["sort"]) && $_POST["sort"] != '') {
        $sql_order = " ORDER BY " . $_POST["sort"];
    }
    
    //Проверяем: если в массиве fields что-то есть - в любом случае добавляем WHERE в строку SQL-запроса (переменная sql_prod)
    if (count($fields) > 0) {
        $sql_prod = $sql_prod . " WHERE ";
        //далее смотрим: если в массиве fields только одно значение (то есть фильтрация только под одному полю), то добавляем соответствующее условие фильтрации после WHERE и оставляем SQL-запрос как есть
        if (count($fields) == 1) {
            $sql_prod = $sql_prod . $fields[0][0] . $fields[0][1];
        //если же длина массива fields больше 1, то значит фильтрация в SQL-запросе будет по нескольким полям и мы наращиваем переменную sql_second (вторая часть строки SQL-запроса) полями и AND
        } elseif (count($fields) > 1) {
            $sql_second = "";
            for ($i = 0; $i < count($fields); $i++) {
                //здесь на каждой итерации цикла проверяем: если счетчик ($i) равен длине массива fields минус один - мы обнуляем значение sql_and, чтобы в конец SQL-запроса не подставилось лишнее AND
                if ($i < (count($fields) - 1)) {
                    $sql_and = " AND ";
                } else {
                    $sql_and = "";
                }
                $sql_second = $sql_second . $fields[$i][0] . $fields[$i][1] . $sql_and;
            }
            //склеиваем базовую часть sql-запроса (sql_prod) со второй частью sql-запроса (sql_second)
            $sql_prod = $sql_prod . $sql_second;
        }
    }
    //Приклеиваем к SQL-запросу ORDER BY если в переменной sql_order что-то есть
    $sql_prod = $sql_prod . $sql_order;
}

//При нажатии кнопки "Очистить" обнуляем $_POST
if (isset($_POST["clear"])) {
    unset($_POST["prodtype"]);
    unset($_POST["prodvendor"]);
    unset($_POST["pricefrom"]);
    unset($_POST["pricetill"]);
    unset($_POST["sort"]);
}

//Собственно отправляем получившийся SQL-запрос в базу
$result_prod = mysqli_query($conn, $sql_prod);
$products = mysqli_fetch_all($result_prod, MYSQLI_ASSOC);

?>
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
                    <input class="filter-input" type="number" name="pricefrom">
                </label>
                <label for="pricetill">
                    До:
                    <input class="filter-input" type="number" name="pricetill">
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
                <th>ДЕЙСТВИЕ</th>
                <?php
                //Выводим в таблицу содержимое массива $prod с данными о товарах, полученными из базы
                foreach($products as $prod) : ?>
                <tr>
                    <td class="prodname"><?php echo $prod["title"] ?></td>
                    <td><?php echo $prod["description"] ?></td>
                    <td><?php echo $prod["price"] ?></td>
                    <td><a class="action edit" href="update.php?id=<?php echo $prod["id"]; ?>">Редактировать</a><a class="action delete" href="delete.php?id=<?php echo $prod["id"]; ?>">Удалить</a></td>
                </tr>
                <?php endforeach; ?>
                <?php
                //если в массиве products ничего нет (то есть из базы никаких данных не получено) - выводим в табицу соответствующее сообщение
                if (empty($products)) :  ?>
                    <tr>
                        <td colspan="3">Нет товаров для отображения</td>
                    </tr>
                <?php endif; ?>
            </table>
    </main>

    <?php include "include/footer.php"; ?>