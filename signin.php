<?php

include "include/header.php";

?>

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
    </main>

<?php include "include/footer.php"; ?>