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

    <link rel="stylesheet" href="/cle/jquery.cleditor.css" />
    <script src="/cle/jquery.min.js"></script>
    <script src="/cle/jquery.cleditor.min.js"></script>
    <script>
        $(document).ready(function () { $("#input-cle").cleditor(); });
    </script>

    <link rel="stylesheet" href="/mainstyle.css">
    <link rel="stylesheet" href="/loginFormStyle.css">
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
                    <?php include_once($content) ?>
                </div>
            </div>
        </div>

        <div class="container" id="footer">
            <div class="row">
                <div class="col">
                    <p>Copyright © <?=date("Y")?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>