<h2>Задание №8</h2>
<p>Реализовать на чистом PHP и HTML/css механизм авторизации и простого личного кабинета.
    Написать простой скрипт на php, который будет авторизовывать только пользователей из php-массива (логин => пароль)
    Для этого объявить ассоциативный массив на php вида (логин => пароль). Вывести форму авторизации (Логин + пароль + кнопка ""Войти"").
    Написать скрипт авторизации пользователя. Выводить ошибки авторизации (""Логина нет в системе"", ""Неверный пароль"").
    Если пользователь авторизован -- вывести страницу с открытым логином и паролем из массива и кнопку/ссылку ""Выйти"", которая завершает сессию.
    Убедиться что открытая страница недоступна по прямой ссылке до авторизации и после завершения сессии.
</p>
<hr>


<div class="form-wrapper">
    <div class="form-head">
        <p>Вход в личный кабинет</p>
    </div>
    <div id="form-content">
        <form method="post">
            <div class="form-group">
                <input type="text" id="login" class="form-control" name="login" placeholder="Логин" value="<?=$_POST['login']?>" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" class="form-control" name="password" placeholder="Пароль" required>
            </div>

            <?php if(!empty($auth_error)):?>
            <div class="form-group">
                <div class="alert alert-danger" role="alert">
                    <?=$auth_error?>
                </div>
            </div>
            <?endif;?>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Войти">
            </div>
        </form>
    </div>
</div>