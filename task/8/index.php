<?php
    function redirect($url, $statusCode = 303)
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }

    session_start();

    $auth = array(
        'admin'=>'Qd45tAAs',
        'VasyaKill'=>'qwerty1999',
        'user098'=>'kot0hlepa',
        'user007'=>'bond8knopkou',
        'kitttty_'=>'1234',
    );

    if ($_SESSION['isAuth'] == true){
        redirect('/task/8/user_page');
    }

    if ((!empty($_POST['login']))&&(!empty($_POST['password']))){

        if (array_key_exists($_POST['login'],$auth)){
            if ($auth[$_POST['login']] == $_POST['password'] ){
                $_SESSION['isAuth'] = true;
                $_SESSION['login'] = $_POST['login'];
                $_SESSION['password'] = $_POST['password'];

                redirect('/task/8/user_page');
            }else{
                $auth_error = 'Неверный пароль';
            }
        }else{
            $auth_error = 'Логина нет в системе';
        }
    }else{
        $content = "authPage.php";
    }

    $content = "authPage.php";


include($_SERVER['DOCUMENT_ROOT']."/template.php");
