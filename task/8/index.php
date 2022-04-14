<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/HEADER.php");?>
<!--НАЧАЛО СТРАНИЦЫ-->

<?php
    session_start();

    $authDataArr = array(
        'admin'=>'Qd45tAAs',
        'VasyaKill'=>'qwerty1999',
        'user098'=>'kot0hlepa',
        'user007'=>'bond8knopkou',
        'kitttty_'=>'1234',
    );

    $isAuth = $_SESSION['isAuth'];
    $isShowAuthPage = true;
    if(isset($_POST['logout'])){
        session_destroy();
    }
    if ($isAuth == true){
        $isShowAuthPage = false;
    }else{
        if (!empty($_POST)){
            $login = validate_str($_POST['login']);
            $password= validate_str($_POST['password']);

            if ((!empty($login))&&(!empty($password))) {

                if (array_key_exists($login, $authDataArr)) {
                    if ($authDataArr[$login] == $password) {
                        $_SESSION['isAuth'] = true;
                        $_SESSION['login'] = $login;
                        $_SESSION['password'] = $password;

                        $isShowAuthPage = false;
                    } else {
                        $authError = 'Неверный пароль';
                    }
                } else {
                    $authError = 'Логина нет в системе';
                }
            }
        }
    }
?>

<?if($isShowAuthPage):?>
<!--СТРАНИЦА АВТОРИЗАЦИИ -->
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

                <?php if(!empty($authError)):?>
                    <div class="form-group">
                        <div class="alert alert-danger" role="alert">
                            <?=$authError?>
                        </div>
                    </div>
                <?endif;?>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Войти">
                </div>
            </form>
        </div>
    </div>
<?else:?>
<!--СТРАНИЦА ЛИЧНОГО КАБИНЕТА-->
    <div class="pp-wrapper">
        <div class="pp-head">
            <div class=""><p> 😁 <?=$_SESSION['login']?></p></div>
            <div ><p class="info">Личный кабинет</p></div>
            <div class="">
                <form action="" method="post">
                    <input type="hidden" name="logout" id="">
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
<?endif;?>

<!--КОНЕЦ СТРАНИЦЫ-->
<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/FOOTER.php");?>