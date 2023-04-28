<?php

session_start();

if(isset($_SESSION["user"])) {
    header('Location: index.php');
}

include "config/database.php";

$errors = [];
$login = '';
$pass = '';

if (isset($_POST["submit"])) {
    if ($_POST["login"] != '') {
        $login = $_POST["login"];
    } else {
        $loginErr = 'Необходимо ввести имя пользователя';
        array_push($errors, $loginErr);
        $_SESSION["errors"] = $errors;
    }
    
    if ($_POST["password"] != '') {
        $pass = $_POST["password"];
    } else {
        $passErr = 'Необходимо ввести пароль';
        array_push($errors, $passErr);
        $_SESSION["errors"] = $errors;
    }

    $sql_user_check = "SELECT * FROM users WHERE `name` = '$login' AND `password` = '$pass'";
    $user_check = mysqli_query($conn, $sql_user_check);

    if (mysqli_num_rows($user_check) == 1) {
        $user = mysqli_fetch_assoc($user_check);
        $_SESSION["user"] = [
            "id" => $user["id"],
            "name" => $user["name"]
        ];
        header('Location: index.php');
    } else {
        $authErr = "Неверный логин или пароль";
        array_push($errors, $authErr);
        $_SESSION["errors"] = $errors;
    }
}

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
            <a class="login-button" href="#">Выйти</a>
            <!-- <button type="submit">Войти</button> -->
        </div>
    </header>
    <main class="main-signin">
        <form class="signin" action="signin.php" method="POST">
            <div class="login-input">
                <p>Имя пользователя:</p>
                <input class="login" type="text" name="login">
            </div>
            <div class="password-input">
                <p>Пароль</p>
                <input class="password" type="password" name="password">
            </div>
            <div class="login-send">
                <input class="login-submit" type="submit" name="submit" value="Войти">
            </div>
        </form>
        <?php
        
        if (isset($_SESSION["errors"])) {
            foreach($_SESSION["errors"] as $err) {
                echo "<p>" . $err . "</p>";
            }
            unset($_SESSION["errors"]);
        }

        ?>
    </main>

<?php include "include/footer.php"; ?>