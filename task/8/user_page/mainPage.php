<?php
function redirect($url, $statusCode = 303)
{
    header('Location: ' . $url, true, $statusCode);
    die();
}

session_start();

if ($_SESSION['isAuth'] == false){
    redirect('/task/8/');
}
?>

<h2>Задание №8</h2>
<p>Реализовать на чистом PHP и HTML/css механизм авторизации и простого личного кабинета.
    Написать простой скрипт на php, который будет авторизовывать только пользователей из php-массива (логин => пароль)
    Для этого объявить ассоциативный массив на php вида (логин => пароль). Вывести форму авторизации (Логин + пароль + кнопка ""Войти"").
    Написать скрипт авторизации пользователя. Выводить ошибки авторизации (""Логина нет в системе"", ""Неверный пароль"").
    Если пользователь авторизован -- вывести страницу с открытым логином и паролем из массива и кнопку/ссылку ""Выйти"", которая завершает сессию.
    Убедиться что открытая страница недоступна по прямой ссылке до авторизации и после завершения сессии.
</p>
<hr>

<?php
    session_start();
?>


<div class="pp-wrapper">
    <div class="pp-head">
        <div class=""><p> 😁 <?=$_SESSION['login']?></p></div>
        <div ><p class="info">Личный кабинет</p></div>
        <div class="">
            <form action="logout.php" method="post">
                <button class="btn btn-primary" >Выйти</button>
            </form>
        </div>

    </div>
    <div id="pp-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <img class="def-img" src="https://picsum.photos/200/200" alt="<?=$_SESSION['login']?>">
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <p><b>Логин пользователя:</b> <?=$_SESSION['login']?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p><b>Логин пользователя:</b> <?=$_SESSION['password']?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
