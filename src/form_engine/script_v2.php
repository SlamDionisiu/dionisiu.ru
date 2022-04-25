<?php

    session_start();

    include($_SERVER['DOCUMENT_ROOT']."/src/form_engine/form_conf.php");
    include($_SERVER['DOCUMENT_ROOT']."/src/form_engine/form_engine_conf.php");

    if (!$_POST && !$_GET){
        $_SESSION['id'] = session_id();
    }

    //-------------------------------------------ФУНКЦИЯ-ДЛЯ-ОТЛАДКИ----------------------------------------------------
    function console_log($msg, $console_data){
        echo("<script>console.log('".$msg."');</script>");
        if(is_array($console_data) || is_object($console_data)){
            echo("<script>dgdata=" . json_encode($console_data) ."; console.log(dgdata);</script>");
        } else {
            echo("<script>console.log('".$console_data."');</script>");
        }
    }

    //-------------------------------------------ФУНКЦИЯ-ДЛЯ-ПОЧТЫ------------------------------------------------------
    function mailer($data, $fields){
        $EOL = "\r\n";
        $postDataString = "<ul>";
        foreach ($data as $field){
            switch ($field['type']) {
                case 'text':
                case 'email':
                case 'tel':
                case 'url':
                case 'search':
                case 'password':
                case 'textarea':
                case 'number':
                    $postDataString .= "<li><b>" . $field['label'] . "</b> - " . $_POST[$field['name']] . "</li>";
                    break;
                case 'email':
                    $postDataString .= "<li><b> email </b> - <a href='mailto:" . $_POST[$field['name']] . "'>" . $_POST[$field['name']] . " </a></li>";
                    break;
                case 'select':
                    $postDataString .= "<li><b>" . $field['label'] . "</b> :</li> <ul>";
                        foreach ($_POST[$field['name']] as $item){
                            $postDataString .= "<li>". $item ."</li>";
                        }
                    $postDataString .= "</ul>";
            }
        }

        $appendixToMessage = "";

        $postDataString .= "<li><b> Файлы : </b></li><ul>";
        foreach ($fields as $field){
            if ($field[2]){
                foreach ($field[1] as $file){
                    $filePathArray = explode("/",$file);
                    $fileURL = "http://" . $filePathArray[4] . "/" . $filePathArray[5] . "/" . $filePathArray[6];
                    $fileName = $filePathArray[6];

                    $postDataString .= "<li> <a href=\"" . $fileURL . "\"> файл (" . $fileName . ") </a></li>";
                    $f = fopen($file, "r");
                    $fileData = fread($f, filesize($file));
                    fclose($f);
                    $appendixToMessage .= $EOL."------------";
                    $appendixToMessage .= $EOL."Content-Type: application/octet-stream;name=\"$fileName\"\r\nContent-Transfer-Encoding:base64".$EOL;
                    $appendixToMessage .= "Content-Disposition:attachment;filename=".$fileName.$EOL.$EOL;
                    $appendixToMessage .= chunk_split(base64_encode($fileData)).$EOL;

                }
            }
        }
        $postDataString .= "</ul>";

        $htmlMessage = file_get_contents($_SERVER['DOCUMENT_ROOT']."/src/templates/mail/mail_template.html");
        $finalMessage = str_replace("###INFO###",$postDataString,$htmlMessage);

        $subject = "НОВОЕ РЕЗЮМЕ";
        $headers = "MIME-Version: 1.0".$EOL;
        $headers .= "Content-Type: multipart/mixed; boundary=\"----------\"$EOL";
        $message = "------------".$EOL;
        $message .= "Content-Type: text/html; charset='utf-8'".$EOL;
        $message .= "Content-Transfer-Encoding: 8bit".$EOL.$EOL;

        $message .= $finalMessage;
        $message .= $EOL."------------";
        $message .= $appendixToMessage;
        $message .= "--"."----------"."--".$EOL;


        $success = mail("dionb@slam.by", $subject, $message, $headers);

        foreach ($data as $field){
            if($field['type']=='email') {

                $htmlMessage = file_get_contents($_SERVER['DOCUMENT_ROOT']."/src/templates/mail/anser_template.html");
                $subject = "НОВОЕ РЕЗЮМЕ";
                $headers = "MIME-Version: 1.0".$EOL;
                $headers .= "Content-Type: multipart/mixed; boundary=\"----------\"$EOL";
                $message = "------------".$EOL;
                $message .= "Content-Type: text/html; charset='utf-8'".$EOL;
                $message .= "Content-Transfer-Encoding: 8bit".$EOL.$EOL;

                $message .= $htmlMessage;
                $message .= $EOL."------------";
                $message .= "--"."----------"."--".$EOL;

                mail($_POST[$field['name']], $subject, $message, $headers);
            }
        }
    }

    //-------------------------------------------ФУНКЦИЯ-ВАЛИДАЦИИ-ПОЛЯ-------------------------------------------------
    function fieldValidate($method, $data){
        if (!empty($data) && isset($data['name'])){
            $rawData = $method[$data['name']];
            $isValid = true;
            $isFile = false;

            switch ($data['type']){
                case 'text':
                case 'email':
                case 'tel':
                case 'url':
                case 'search':
                case 'password':
                case 'textarea':
                    if ($data['required'] && empty($rawData)){
                        return [false, 'error' => "Не заполнено обязательное поле \"".$data['label']."\""];
                    }

                    $rawData = trim($rawData);
                    $rawData = htmlspecialchars($rawData);

                    if (!empty($data['pattern'])){
                        $isPatternTrue =  preg_match($data['pattern'],$rawData);
                        if ($isPatternTrue){

                        }else{
                            return [false, 'error' => "\"" . $data['label']."\" проверте правильность введеных данных"];
                        }
                    }

                    if (!empty($data['minLength']) or !empty($data['maxLength'])){
                        if (strlen($rawData) < $data['minLength']) {
                            return [false, 'error' => "Длина  \"". $data['label']."\" меньше ".$data['minLength']." символов" ];
                        }
                        if (strlen($rawData) > $data['maxLength']) {
                            return [false, 'error' => "Длина \"".$data['label']."\" больше ".$data['maxLength']." символов"];
                        }
                    }
                    break;

                case 'number':
                    if ($data['required'] && empty($rawData)){
                        return [false, 'error' => "Не заполнено обязательное поле \"".$data['label']."\""];
                    }

                    if (is_numeric($rawData)){
                        if (!empty($data['min']) or !empty($data['max'])){
                            if ($rawData <= $data['min']) {
                                return [false, 'error' => "Значение \"".$data['label']."\" меньше ".$data['minLength']];
                            }
                            if ($rawData >= $data['max']) {
                                return [false, 'error' => "Значение \"".$data['label']."\" больше ".$data['minLength']];
                            }
                        }
                    }else{
                        return [false, 'error' => ""];
                    }
                    break;

                case 'select':
                    if ($data['required'] && empty($rawData)){
                        return [false, 'error' => "Не заполнено обязательное поле ".$data['title']];
                    }
                    if (gettype($rawData)!="array"){
                        return [false, 'error' => "Ошибка сервера. Попробуйте отправить форму еще раз"];
                    }
                    break;

                case 'file':
                    $isFile = true;
                    $rawData = array();
                    $fileCount = count($_FILES[$data['name']]['name']);

                    $files = $_FILES[$data['name']];


                    if ($data['required'] && $fileCount<=0){
                        return [false, 'error' => "Не выбрано ниодного файла"];
                    }

                    for ($fileNumber = 0; $fileNumber < $fileCount; $fileNumber++){
                        $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/'.$data['uploadDir'];
                        $extension = substr(strrchr($files['name'][$fileNumber], '.'), 1);
                        $target = $uploadDir . uniqid() . '.' . $extension;

                        if ($files['size'][$fileNumber] < $data['fileSize']){
                            if (in_array($files['type'][$fileNumber], $data['fileTypes'])){
                                if (move_uploaded_file($files['tmp_name'][$fileNumber], $target)) {
                                    $rawData[] = $target;
                                } else {
                                    return [false,$rawData, 'error' => "Ошибка сервера. Попробуйте отправить форму еще раз"];
                                }
                            }else{
                                return [false,$rawData, 'error' => "Недопустимый формат файла"];
                            }
                        }else{
                            return [false,$rawData, 'error' => "Размер файла превышает " . $files['size'][$fileNumber]/1000 ." кб" ];
                        }
                    }
                    break;
            }

            return [$isValid, $rawData , $isFile];

        } else {
            return [false, 'error' => ""];
        }
    }

    //-------------------------------------------ФУНКЦИЯ-ВАЛИДАЦИИ-ФОРМЫ------------------------------------------------
    function formValidation($formConfig, $formEngineConfig ){
        $VALID_DATA = array();
        $isAnserStage = false;
        $isFormValid = true;
        $errorsCount = 0;
        $validationErrors = array();

        if (!empty($_POST) || !empty($_GET)){
            if (empty($_POST['age-conf'])){
                $isAnserStage = true;



                foreach ($formConfig as $formFieldKey => $formField){
                    if (!empty($formField['type'])){
                        if (!empty($formField['name'])){
                            if ($formEngineConfig['FORM_HEAD']['method']=='POST'){
                                $VALID_DATA[] = fieldValidate($_POST,$formField);
                            }
                            if ($formEngineConfig['FORM_HEAD']['method']=='GET'){
                                $VALID_DATA[] = fieldValidate($_GET,$formField);
                            }
                        }
                    }
                }

                if ($_SESSION['id'] == $_POST['session_id'] || $_SESSION['id'] == $_GET['session_id']){
                    $VALID_DATA[] = [true, $_SESSION['id']];
                }else{
                    $VALID_DATA[] = [false, 'error' => "ID сессии не совпадает" ];
                }

                if(isset($_POST['g-recaptcha-response'])){
                    $captcha=$_POST['g-recaptcha-response'];

                    $secretKey = "6LfM0pwfAAAAAGStGAPxyOPSh0-90-0ZF5eGrQEA";

                    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
                    $response = file_get_contents($url);
                    $responseKeys = json_decode($response,true);

                    if($responseKeys["success"]) {
                        $VALID_DATA[] = [true, $responseKeys];
                    }else{
                        $VALID_DATA[] = [false, 'error' => "Капча не валидна" ];
                    }

                }else{
                    $VALID_DATA[] = [false, 'error' => "Капча не заполнена." ];
                }

                foreach ($VALID_DATA as $validFields){
                    if (!$validFields[0]){
                        $validationErrors[] = $validFields['error'];
                        $errorsCount++;
                    }
                }

                if ($errorsCount>0){
                    $isFormValid = false;
                }
            }else{
                $VALID_DATA[] = [false, 'error' => "ВЫ РОБОТ" ];

                foreach ($VALID_DATA as $validFields){
                    if (!$validFields[0]){
                        $validationErrors[] = $validFields['error'];
                        $errorsCount++;
                    }
                }

                if ($errorsCount>0){
                    $isFormValid = false;
                }
            }
        }

        return array(
            'VALID_DATA' => $VALID_DATA,
            'isAnserStage' => $isAnserStage,
            'isFormValid' => $isFormValid,
            'errorsCount' => $errorsCount,
            'vilidationErrors' => $validationErrors,
            'FILES' => $_FILES,
        );
    }

    //--------------------------------------------ГЛАВНАЯ-ФУНКЦИЯ-------------------------------------------------------
    function FORM($FORM_CONFIG){
        echo($FORM_ENGINE_CONFIG['DEBUG'] ? console_log("FORM CONFIG  ===>", $FORM_CONFIG) :null);

        //..............................СБОР ОШИБОК КОНФИГУРАЦИОННОГО МАССИВА...........................................
        foreach ($FORM_CONFIG as $formFieldKey => $formField){
            if (!empty($formField['name'])){
                if (!empty($formField['type'])){

                }else{
                    $FORM_ENGINE_CONFIG['ERRORS'][] = "Ошибка генерации формы: Поле [".$formField['name']."] не содержит обязательного поля 'type'.";
                    echo($FORM_ENGINE_CONFIG['DEBUG'] ? console_log("FIELD WITH ERROR  ===>", $formField) :null);
                }
            }else{
                $FORM_ENGINE_CONFIG['ERRORS'][] = "Ошибка генерации формы: Поле не содержит обязательного поля 'name'.";
                echo($FORM_ENGINE_CONFIG['DEBUG'] ? console_log("FIELD WITH ERROR  ===>", $formField) :null);
            }
        }

        //.......................................СОЗДАНИЕ ВАЛИДАЦИИ.....................................................
        $VALIDATION = formValidation($FORM_CONFIG,$FORM_ENGINE_CONFIG);

        //.......................................СОЗДАНИЕ ПОЧТЫ.........................................................

?>
<!--=================================================  СКРИПТЫ ФОРМЫ  ================================================-->
    <script>
        window.addEventListener("DOMContentLoaded", function() {
            [].forEach.call( document.querySelectorAll('.tel'), function(input) {
                var keyCode;
                function mask(event) {
                    event.keyCode && (keyCode = event.keyCode);
                    var pos = this.selectionStart;
                    if (pos < 3) event.preventDefault();
                    var matrix = "+375 (__) ___ ____",
                        i = 0,
                        def = matrix.replace(/\D/g, ""),
                        val = this.value.replace(/\D/g, ""),
                        new_value = matrix.replace(/[_\d]/g, function(a) {
                            return i < val.length ? val.charAt(i++) || def.charAt(i) : a
                        });
                    i = new_value.indexOf("_");
                    if (i != -1) {
                        i < 5 && (i = 3);
                        new_value = new_value.slice(0, i)
                    }
                    var reg = matrix.substr(0, this.value.length).replace(/_+/g,
                        function(a) {
                            return "\\d{1," + a.length + "}"
                        }).replace(/[+()]/g, "\\$&");
                    reg = new RegExp("^" + reg + "$");
                    if (!reg.test(this.value) || this.value.length < 5 || keyCode > 47 && keyCode < 58) this.value = new_value;
                    if (event.type == "blur" && this.value.length < 5)  this.value = ""
                }

                input.addEventListener("input", mask, false);
                input.addEventListener("focus", mask, false);
                input.addEventListener("blur", mask, false);
                input.addEventListener("keydown", mask, false)

            });

        });

        $(document).ready(function (){
            //исправить селектор
            $('form').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'index.php',
                    data:  new FormData(this),
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {'X-Requested-With': 'XMLHttpRequest'},
                    success: function (res){
                        serverResponse = JSON.parse(res);
                        console.log(serverResponse);
                        console.log(serverResponse['isFormValid']);

                        setTimeout(() => $('#form-submit-btn').removeAttr('disabled'), 1000);
                        setTimeout(() => $('#form-submit-btn-loader').addClass('d-none'), 1000);
                        $('form').trigger('reset');
                        grecaptcha.reset();


                        if (serverResponse['isFormValid']==true){
                            $('#myModal').modal('toggle');
                            $('#anser-modal-head').text('Ваше резюме успешно отправленно');
                            $('#anser-modal-body').text('Мы рассмотрим его в ближайшее время');

                        }else{
                            $('#myModal').modal('toggle');
                            $('#anser-modal-head').text('Ваше резюме не было отправленно');
                            $('#anser-modal-body').text('');
                            for (var i=0; i<serverResponse['vilidationErrors'].length; i++){
                                $("#anser-modal-errors").append('<li>'+serverResponse['vilidationErrors'][i]+'</li>');
                            }
                        }

                    },
                    beforeSend: function (data){

                        $('#form-submit-btn').prop("disabled", true);
                        $('#form-submit-btn-loader').removeClass('d-none');
                    },
                });
            });
        })

    </script>
<!--=================================================  ШАБЛОН ФОРМЫ  ================================================-->
    <form id="" class="form-temp" enctype="<?=$FORM_ENGINE_CONFIG['FORM_HEAD']['enctype']?>" action="" method="<?=$FORM_ENGINE_CONFIG['FORM_HEAD']['method']?>">
        <!-----------------------====----------------отрисовка ошибок формы-------------------------------------------->
        <?if($VALIDATION['isAnserStage']):?>
            <?if($VALIDATION['isFormValid']):?>
                <div class="alert alert-danger" role="alert">
                    Ошибка отправки формы:
                    <ul>
                        <?foreach ($VALIDATION['validationErrors'] as $error):?>
                            <li><?=$error?></li>
                        <?endforeach;?>
                    </ul>
                </div>
            <?else:?>
                <div class="alert alert-success" role="alert">
                    Ваше рюзюме успешно отправлено. Вы рассмотрим его в ближайшем времени.
                </div>
            <?endif;?>
        <?endif;?>
        <!-----------------------------====-------конец отрисовки ошибок формы----------------------------------------->

        <input type="hidden" name="session_id" value="<?=$_SESSION['id']?>">
        <div class="age-conf-wrap">
            <input type='number' name="age-conf" class="age-conf" tabindex="-1">
        </div>

        <? foreach ($FORM_CONFIG as $formFieldKey => $formFields):?>

            <!---------------------------------------отрисовка полей формы--------------------------------------------->
            <? if(in_array($formFields['type'],['text','email','url','search','password'])): ?>
                <div class="form-group">
                    <? if(!empty($formFields['label'])):?> <label><?=$formFields['label']?> <?= !empty($formFields['required']) ? "<span class='required'>*</span>" : null  ?> </label> <?endif;?>
                    <input name="<?=$formFields['name']?>" type="<?=$formFields['type']?>" id="<?=$formFields['id']?>" class="form-control" <?= !empty($formFields['placeholder']) ? "placeholder='".$formFields['placeholder']."'" : null  ?> <?= !empty($formFields['pattern']) ? "pattern='".$formFields['pattern']."'" : null  ?>  <?= !empty($formFields['minLength']) ? "minlength='".$formFields['minLength']."'" : null  ?> <?= !empty($formFields['maxLength']) ? "maxlength='".$formFields['maxLength']."'" : null  ?> <?= !empty($formFields['required']) ? "required" : null  ?> >
                    <? if(!empty($formFields['tip'])):?> <small class='form-text text-muted'> <?=$formFields['tip']?> </small> <?endif;?>
                </div>
            <? endif;?>

            <? if($formFields['type'] == 'tel'): ?>
                <div class="form-group">
                    <? if(!empty($formFields['label'])):?> <label><?=$formFields['label']?> <?= !empty($formFields['required']) ? "<span class='required'>*</span>" : null  ?> </label> <?endif;?>
                    <input name="<?=$formFields['name']?>" type="<?=$formFields['type']?>" id="<?=$formFields['id']?>" class="tel form-control" <?= !empty($formFields['placeholder']) ? "placeholder='".$formFields['placeholder']."'" : null  ?>  <?= !empty($formFields['pattern']) ? "pattern='".$formFields['pattern']."'" : null  ?>  <?= !empty($formFields['minLength']) ? "minlength='".$formFields['minLength']."'" : null  ?> <?= !empty($formFields['maxLength']) ? "maxlength='".$formFields['maxLength']."'" : null  ?> <?= !empty($formFields['required']) ? "required" : null  ?> >
                    <? if(!empty($formFields['tip'])):?> <small class='form-text text-muted'> <?=$formFields['tip']?> </small> <?endif;?>
                </div>
            <? endif;?>

            <? if($formFields['type'] == 'number'): ?>
                <div class="form-group">
                    <? if(!empty($formFields['label'])):?> <label><?=$formFields['label']?> <?= !empty($formFields['required']) ? "<span class='required'>*</span>" : null  ?> </label> <?endif;?>
                    <input name="<?=$formFields['name']?>" type="<?=$formFields['type']?>"  id="<?=$formFields['id']?>" class="form-control" <?= !empty($formFields['placeholder']) ? "placeholder='".$formFields['placeholder']."'" : null  ?> <?= !empty($formFields['min']) ? "min='".$formFields['min']."'" : null  ?> <?= !empty($formFields['max']) ? "max='".$formFields['max']."'" : null  ?> <?= !empty($formFields['required']) ? "required" : null  ?>>
                    <? if(!empty($formFields['tip'])):?> <small class='form-text text-muted'> <?=$formFields['tip']?> </small> <?endif;?>
                </div>
            <? endif;?>

            <? if($formFields['type'] == 'select'): ?>
                <div class="form-group">
                    <? if(!empty($formFields['label'])):?> <label><?=$formFields['label']?> <?= !empty($formFields['required']) ? "<span class='required'>*</span>" : null  ?> </label> <?endif;?>
                    <select name="<?=$formFields['name']?>[]" id="<?=$formFields['id']?>" class="form-control" <?= !empty($formFields['multiple']) ? "multiple" : null  ?> <?= !empty($formFields['required']) ? "required" : null  ?>>
                        <? foreach ($formFields['values'] as $options):?>
                            <option value="<?= $options ?>"><?=$options?></option>
                        <?endforeach;?>
                    </select>
                    <? if(!empty($formFields['tip'])):?> <small class='form-text text-muted'> <?=$formFields['tip']?> </small> <?endif;?>
                </div>
            <? endif;?>

            <? if($formFields['type'] == 'textarea'): ?>
                <div class="form-group">
                    <? if(!empty($formFields['label'])):?> <label><?=$formFields['label']?> <?= !empty($formFields['required']) ? "<span class='required'>*</span>" : null  ?> </label> <?endif;?>
                    <textarea name="<?=$formFields['name']?>" id="<?=$formFields['id']?>" cols="30" rows="5" class="form-control" maxlength="" <?= !empty($formFields['required']) ? "required" : null  ?>></textarea>
                    <? if(!empty($formFields['tip'])):?> <small class='form-text text-muted'> <?=$formFields['tip']?> </small> <?endif;?>
                </div>
            <? endif;?>

            <? if($formFields['type'] == 'file'): ?>
                <div class="form-group">
                    <? if(!empty($formFields['label'])):?> <label><?=$formFields['label']?> <?= !empty($formFields['required']) ? "<span class='required'>*</span>" : null  ?> </label> <?endif;?>
                    <div class="custom-file">
                        <input name="<?=$formFields['name']?>[]" type="file" id="<?=$formFields['id']?>"   class="custom-file-input" id="customFile" <?= !empty($formFields['multiple']) ? "multiple" : null  ?> <?= !empty($formFields['required']) ? "required" : null  ?>>
                        <label class="custom-file-label" for="customFile" data-browse="Загрузить">Выберите файлы</label>
                    </div>
                    <? if(!empty($formFields['tip'])):?> <small class='form-text text-muted'> <?=$formFields['tip']?> </small> <?endif;?>
                </div>
            <? endif;?>


        <?endforeach;?>
        <!---------------------------------------конец отрисовка полей формы------------------------------------------->

        <div class="form-group">
            <div class="g-recaptcha" data-sitekey="6LfM0pwfAAAAAN2fzcLC-XdjZkzxCYFfaKuzxxhA"></div>
        </div>

        <div class="form-group">
            <small class="form-text text-muted"><span class="required">*</span> - обязательные даные</small>
            <button id="form-submit-btn" class="btn btn-primary float-right" type="submit">
                <span id="form-submit-btn-loader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                Отправить
            </button>
        </div>

        <!---------------------------------------отображение-ошибок-генерации-формы------------------------------------>
        <?if(!empty($FORM_ENGINE_CONFIG['ERRORS'])):?>
            <div class="alert alert-danger" role="alert">
                <b>FORM_ENGINE ошибки:</b><br>
                <i>Что бы выключить отображение ошибок, деактивируйте флаг <u>$FORM_ENGINE_CONFIG['DEBUG']</u> в настройках FORM_ENGINE</i>
                <ul>
                    <? foreach ($FORM_ENGINE_CONFIG['ERRORS'] as  $formEngineErrors):?>
                        <li><?=$formEngineErrors?></li>
                    <?endforeach;?>
                </ul>
            </div>
        <?endif;?>
        <!------------------------------------конец-отображение-ошибок-генерации-формы--------------------------------->
        <div class="modal fade" id="myModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <h4 id="anser-modal-head">###</h4>
                        <p id="anser-modal-body">###</p>
                        <ul id="anser-modal-errors">

                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </form>


<!--=================================================  КОНЕЦ ШАБЛОНА ФОРМЫ  =========================================-->
<?php }

    if ($_SERVER['HTTP_X_REQUESTED_WITH']){
        $VALIDATION = formValidation($FORM_CONFIG,$FORM_ENGINE_CONFIG);
        if ($VALIDATION['isFormValid']){

            mailer($FORM_CONFIG, $VALIDATION['VALID_DATA'] );
        }
        echo json_encode( $VALIDATION );
        die();
    }

?>