<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/HEADER.php");?>
<!--НАЧАЛО СТРАНИЦЫ-->

<?php

$validationErrors = array();

if (!empty($_POST)){
    $isFormValid = true;
    $isPost = true;
}else{
    $isFormValid = false;
    $isPost = false;
}

$taskDataArray = array(
    '1' => 'Системный администратор',
    '2' => 'Программист PHP',
    '3' => 'Веб дизайнер',
    '4' => 'Контент менеджер',
    '5' => 'SEO специалист',
    '6' => 'Мимо-крокодил',
);

function load_file($filesArr){
    $funcResult = array();

    // Путь для загрузки
    $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/upload/';

    // Получаем расширение загруженного файла
    $extension = substr(strrchr($filesArr['name'], '.'), 1);

    // Собираем адрес файла назначения uniqid()-- случайное имя
    $target = $uploadDir . '/' . uniqid() . '.' . $extension;

    // получаем тип файла
    $fileType=$filesArr['type'];

    if ($filesArr["size"] < 5242880){
        if ( $fileType == "application/octet-stream" || $fileType == "application/pdf"){
            if (move_uploaded_file($filesArr['tmp_name'], $target)) {
                $funcResult += ['resualtBool' => true, 'path' => $target];
                return $funcResult;
            } else {
                $funcResult += ['resualtBool' => false, 'error' => "Технические шоколадки, файл не был отправлен"];
                return $funcResult;
            }
        }else {
            $funcResult += ['resualtBool' => false, 'error' => "Тип загружаемого файла не подходит"];
            return $funcResult;
        }
    }else{
        $funcResult += ['resualtBool' => false, 'error' => "Размер загружаемого файла превышает 5мб"];
        return $funcResult;
    }

    $funcResult += ['resualtBool' => false, 'error' => "Технические шоколадки, файл не был отправлен"];
    return $funcResult;
}

//-----------------------------------------------------------------------------------------------
if (!empty($_POST)){
// ФИО -------------------------
    $nameInputValue = validate_str($_POST['nameInput']);

// ТЕЛЕФОН -------------------------
    $telInputValue = validate_int($_POST['telInput']);

// EMAIL -------------------------
    if (filter_var($_POST['emailInput'], FILTER_VALIDATE_EMAIL)) {
        $emailInputValue = $_POST['emailInput'];
    } else {
        $isFormValid = false;
        $validationErrors[] = "Неправильно введен email";
    }

// ДОЛЖНОСТЬ -------------------------
    if (array_key_exists($_POST['taskInput'], $taskDataArray)){
        $taskInputValue = $taskDataArray[ $_POST['taskInput']];
    }else{
        $isFormValid = false;
        $validationErrors[] = "Проверте правильно ли выбрана форма";
    }

// О СЕБЕ -------------------------
    $aboutInputValue = validate_str($_POST['aboutInput']);

// ФАЙЛ РЕЗЮМЕ -------------------------
    $loadFileResponse = load_file($_FILES['userFile']);
    if ($loadFileResponse['resualtBool']){
        $filepathArray = explode('/',$loadFileResponse['path']);
        unset($filepathArray[0]);
        unset($filepathArray[1]);
        unset($filepathArray[2]);
        $filepathArray[3] = 'http:/';
        $filepath = implode('/',$filepathArray);
    }else{
        $isFormValid = false;
        $validationErrors[] = $loadFileResponse['error'];
    }

//---------------------------------------------------------------------------------------------
    if ($isFormValid){
        $flagRefArray = array(
                '##FIO##' => $nameInputValue,
                '##PHONE##' => $telInputValue,
                '##EMAIL##' => $emailInputValue,
                '##TASK##' => $taskInputValue,
                '##ABOUT##' => $aboutInputValue,
                '##FILEURL##' => $filepath,
        );

        $mailHeaders = "Content-type:text/html;charset=utf-8";
        $mailTemplate = file_get_contents($_SERVER['DOCUMENT_ROOT']."/src/templates/mail/mail_template.html");
        $bakeMailTemplate = strtr($mailTemplate, $flagRefArray);
        $anserMailTemplate = file_get_contents($_SERVER['DOCUMENT_ROOT']."/src/templates/mail/anser_template.html");

        mail('dionb@slam.by','Новое резюме', $bakeMailTemplate , $mailHeaders);
        mail($emailInputValue,'Ответ от DIONISIU.RU', $anserMailTemplate  , $mailHeaders);
    }
}
?>
<div class="anser-form">
    <div class="anser-form-head">

    </div>
    <form enctype="multipart/form-data" action="" method="POST">
        <h2>Форма обратной связи</h2>
        <p>
            Компания ООО «DIONISIU.RU» предлагает Вам рассмотреть вакансии на широкий спектр должностей. Мы внимательно ознакомимся с Вашим резюме и считаем, что Ваши знания будут полезны нам. Пойсле рассмотренияс вашего резюме, мы пригласим вас пройти собеседование с HR-менеджером. Для отправки резюме заполните форму ниже.
        </p>
        <hr>
        <?if ($isFormValid): ?>
            <div class="alert alert-success" role="alert">
                Ваше рюзюме успешно отправлено. Вы рассмотрим его в ближайшем времени.
            </div>
        <?else:?>
            <?if ($isPost):?>
                <div class="alert alert-danger" role="alert">
                    Что то пошло не так :
                    <ul>
                        <?foreach ($validationErrors as $error):?>
                            <li><?=$error?></li>
                        <?endforeach;?>
                    </ul>
                </div>
            <?endif;?>
        <?endif;?>
        <div class="form-row">
            <div class="form-group col">
                <label for="">Ф.И.О. <span class="required">*</span></label>
                <input class="form-control" type="text" placeholder="Иванов Иван Иванович" name="nameInput" required>
            </div>
            <div class="form-group col">
                <label for="">Контактный номер телефона: <span class="required">*</span></label>
                <input class="form-control" type="tel" placeholder="+375( _ _ ) _ _ _ _ _ _ _" minlength="9" maxlength="9" name="telInput" required>
                <small class="form-text text-muted">двухзначный код и семь цифр</small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col">
                <label for="">Email для связи: <span class="required">*</span></label>
                <input class="form-control" type="email" placeholder="ezample@mail.ru" name="emailInput" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col">
                <label for="">Интерисующая должность: <span class="required">*</span></label>
                <select class="form-control" name="taskInput" id="" required>
                    <option value="" selected disabled>--- Выберите должность ---</option>
                    <option value="1">Системный администратор</option>
                    <option value="2">Программист PHP</option>
                    <option value="3">Веб дизайнер</option>
                    <option value="4">Контент менеджер</option>
                    <option value="5">SEO специалист</option>
                    <option value="6">Мимо-крокодил</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col">
                <label for="">О себе:</label>
                <textarea name="aboutInput" id="" cols="30" rows="5" class="form-control"></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col">
                <label for="">Файл резюме: <span class="required">*</span></label>
                <div class="custom-file">
                    <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
                    <input type="file" class="custom-file-input" name="userFile" id="customFile" required>
                    <label class="custom-file-label" for="customFile">Choose file</label>
                    <small class="form-text text-muted">.docx .pdf формат, до 5мб </small>
                </div>
            </div>
        </div>

        <div class="form-group">
            <small class="form-text text-muted"><span class="required">*</span> - обязательные даные</small>
            <button type="submit" class="btn btn-primary float-right">Отправить</button>
        </div>
    </form>
    <div class="anser-form-footer">
        <p>Нажимая отправить вы соглашаетесь на обработку ваших данных</p>
    </div>
</div>
<!--КОНЕЦ СТРАНИЦЫ-->
<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/FOOTER.php");?>