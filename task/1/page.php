<?php

$validate = true;

if (!empty($_POST['numInput'])) {
    if (!($_POST['numInput'] >= -10 && $_POST['numInput'] <= 10)) {
        $validate = false;
        $validate_errors[] = "Числа выходят за диапозон ";
    }
}

if (!empty($_POST['rangeInput'])) {
    if (!($_POST['rangeInput'] >= 0 && $_POST['rangeInput'] <= 100 && $_POST['rangeInput'] % 5 == 0)) {
        $validate = false;
        $validate_errors[] = "Числа выходят за диапозон или не кратны 5 ";
    }
}

if (!empty($_POST['passwordInput'])){
    if (!(strlen($_POST['passwordInput'] >= 8))){
        $validate = false;
        $validate_errors[] = "Длина пароля меньше 8 символов";
    }
}

if (!empty($_POST['emailInput'])){
    if (!(filter_var($_POST['emailInput'], FILTER_VALIDATE_EMAIL))){
        $validate = false;
        $validate_errors[] = "Неверный емаил";
    }
}

if (!empty($_POST['telInput'])){
    if(!preg_match("/^[0-9]{9,9}+$/", $_POST['userPhone'])){
        $validate = false;
        $validate_errors[] = "Телефон задан в неверном формате";
    }
}

if (!empty($_POST['dateInput'])){
    if (($timestamp = strtotime($_POST['dateInput'])) === false) {
        $validate = false;
        $validate_errors[] = "дата задана в неверном формате";
    }
}

if (!empty($_POST['dateTimeInput'])){
    if (($timestamp = strtotime($_POST['dateTimeInputInput'])) === false) {
        $validate = false;
        $validate_errors[] = "дата задана в неверном формате";
    }
}

if (!empty($_POST['timeInput'])){
    if (($timestamp = strtotime($_POST['timeInputInput'])) === false) {
        $validate = false;
        $validate_errors[] = "дата задана в неверном формате";
    }
}

if (!empty($_POST['weekInput'])){
    if (($timestamp = strtotime($_POST['weekInputInput'])) === false) {
        $validate = false;
        $validate_errors[] = "дата задана в неверном формате";
    }
}

if (!empty($_POST['monthInput'])){
    if (($timestamp = strtotime($_POST['monthInputInput'])) === false) {
        $validate = false;
        $validate_errors[] = "дата задана в неверном формате";
    }
}

if (!empty($_POST['urlInput'])){
    if (filter_var($_POST['urlInput'], FILTER_VALIDATE_URL) === false) {
        $validate = false;
        $validate_errors[] = "URL задан неправильно";
    }
}

?>

<h2>Задание №1</h2>
<p>Вывести веб-форму со всеми возможными полями. При отправке под формой должен распечатываться массив отправленных данных.</p>
<hr>

<?php if ($validate && !empty($_POST)):?>
    <div class="alert alert-success" role="alert">
        Данные успешно отправлены !!!
    </div>

    <ul class="list-group">
        <?php foreach ( $_POST as $k => $item):?>
            <li class="list-group-item list-group-item-dark"><b><?=$k?></b> --> <?= print_r($item)?></li>
        <?endforeach;?>
    </ul>

    <hr>

<?else:
    if(isset($validate_errors)):?>
    <div class="alert alert-danger" role="alert">
        Что то не так, где то ошибка: <br>
        <ul>
            <?php foreach ($validate_errors as $error):?>
                <li><?= $error;?></li>
            <?endforeach;?>
        </ul>
    </div>
<?endif;endif;?>


<form action="" method="post">
    <div class="form-group">
        <label>Текст</label>
        <input type="text" class="form-control" aria-describedby="" name="textInput" placeholder="Можно написать все что думаешь">
    </div>

    <div class="form-group">
        <label>Числа</label>
        <input type="number" class="form-control" aria-describedby="" name="numInput" min="-10" max="10" placeholder="числа от -10 до 10">
    </div>

    <div class="form-group">
        <label>Выбор из промежутка чисел</label>
        <input type="range" class="form-control-range" aria-describedby="" name="rangeInput" list="tickmarks" min="0" max="100" step="5">

        <datalist id="tickmarks">
            <option value="0" label="0">
            <option value="10">
            <option value="20">
            <option value="30">
            <option value="40">
            <option value="50" label="50">
            <option value="60">
            <option value="70">
            <option value="80">
            <option value="90">
            <option value="100" label="100">
        </datalist>
    </div>

    <div class="form-group">
        <label>Пароль</label>
        <input type="password" class="form-control" aria-describedby="" name="passwordInput" placeholder="и его лучше никому не рассказывать">
    </div>

    <div class="form-group">
        <label>Мыло )</label>
        <div class="input-group mb-2 mr-sm-2">
            <div class="input-group-prepend">
                <div class="input-group-text">@</div>
            </div>
            <input type="email" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Введите email" name="emailInput">
        </div>
    </div>

    <div class="form-group">
        <label>Телефон</label>
        <input type="tel" class="form-control" aria-describedby="" name="telInput" placeholder="+375 ( _ _ )  _ _ _   _ _ _ _">
    </div>

    <div class="form-group">
        <label>Выбор даты</label>
        <input type="date" class="form-control" aria-describedby="" name="dateInput" placeholder="">
    </div>

    <div class="form-group">
        <label>Выбор даты с временем</label>
        <input type="datetime-local" class="form-control" aria-describedby="" name="dateTimeInput" placeholder="">
    </div>

    <div class="form-group">
        <label>Выбор времени</label>
        <input type="time" class="form-control" aria-describedby="" name="timeInput" placeholder="">
    </div>

    <div class="form-group">
        <label>Выбор недели</label>
        <input type="week" class="form-control" aria-describedby="" name="weekInput" placeholder="">
    </div>

    <div class="form-group">
        <label>Выбор месяца</label>
        <input type="month" class="form-control" aria-describedby="" name="monthInput" placeholder="">
    </div>

    <div class="form-group">
        <label>Цвет</label>
        <div class="row">
            <div class="col-2">
                <input type="color" class="form-control form-control-inline" aria-describedby="" name="colorInput" placeholder="">

            </div>
        </div>
    </div>

    <div class="form-group">
        <label>URL адресс</label>
        <input type="url" class="form-control" aria-describedby="" name="urlInput" placeholder="к примеру http://milliondollarhomepage.com/">
    </div>

    <div class="form-group">
        <label>Выбор файла</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="fileInput">
            <label class="custom-file-label" for="customFile">Выберите файл</label>
        </div>
    </div>

    <div class="form-group">
        <label>Выбор опции</label>
        <select class="custom-select" name="selectInput">
            <option selected>Выберите опцию</option>
            <option value="1">Мак комбо</option>
            <option value="2">Картошечка с макфлурри</option>
            <option value="3">Хеппи-мил</option>
        </select>
    </div>

    <div class="form-group">
        <label>Выбор в окошке</label>
        <select multiple class="form-control" name="selectMultiInput[]">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>

    <div class="form-group">
        <label>Текстовое поле</label>
        <textarea class="form-control" rows="5" placeholder="Сюда можно написать еще больше текста ..." name="textAreaInput"></textarea>
    </div>

    <div class="form-group">
        <label>тут спрятаны данные</label>
        <input type="hidden" class="form-control" aria-describedby="" name="hideInput" value="СЕКРЕТЫ ДОКУМЕТЫ НКВД">
    </div>

    <div class="form-group">
        <label for="">Check кнопки</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="" name="chBtn[]" value="option1">
            <label class="form-check-label" for="inlineCheckbox1">1</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="" name="chBtn[]" value="option2">
            <label class="form-check-label" for="inlineCheckbox2">2</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="" name="chBtn[]" value="option3" disabled>
            <label class="form-check-label" for="inlineCheckbox3">3 (недоступно)</label>
        </div>
    </div>

    <div class="form-group">
        <label for="">Radio кнопки</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="radioBtn" id="" value="option1">
            <label class="form-check-label" for="inlineRadio1">1</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="radioBtn" id="" value="option2">
            <label class="form-check-label" for="inlineRadio2">2</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="radioBtn" id="" value="option4" disabled>
            <label class="form-check-label" for="inlineRadio3">4 (недоступно)</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="radioBtn" id="" value="option3">
            <label class="form-check-label" for="inlineRadio2">3</label>
        </div>
    </div>

    <label for="">Нажми на жирного кота что бы оправить данные</label>
    <div class="form-group d-flex justify-content-center">
        <input type="image" class="" src="https://sib.fm/storage/article/April2021/Kb1KiTYol9I62IHiyBgV.jpeg" width="2000" height="350">
    </div>
    <hr>

    <label for="">Кнопки сбросить и отправить</label>
        <div class="form-group float-right"><br>
        <input type="reset"  class="btn btn-dark" name="" id="">
        <input type="submit"  class="btn btn-primary" name="" id="">
    </div>
</form>