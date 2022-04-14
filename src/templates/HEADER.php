<?php
    //служебные функции
    function validate_str($str) {
        $str = trim($str);
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
        return $str;
    }

    function validate_int($int) {
        $int = (int)$int;
        return $int;
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <link rel="stylesheet" href="/src/css/mainstyle.css?ver=3">
    <link rel="stylesheet" href="/src/css/loginFormStyle.css?ver=3">
    <title>Тестовое задание Бровка Д.С.</title>
</head>
<body>
<div class="container-fluid">
    <div class="container" id="page">
        <div class="row" id="header">
            <div class="col ">
                <h1>Бровка Дионисий Сергеевич</h1>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md">
                <?php include_once("sidebar.php") ?>
            </div>


            <div class="col-lg-9 col-md">
            <!--Главный  контент-->
