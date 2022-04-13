<h2>Задание №5</h2>
<p>Пользователь вводит email. Осуществить проверку на корректность (длина больше восьми, присутствует символ @, после которого присутствует символ '.', между этими двумя символами есть хотя бы две буквы, оканчивается на 'ru', 'com', 'net' или 'by', символ '_' может встречаться только один раз, до символа @ могут быть только цифры, буквы и символ '_').</p>
<hr>

<form action="" method="get">
    <div class="form-group">
        <label for="">Мыло:</label>
        <input type="text" class="form-control" name="text" id="" rows="10" value="<?=$_GET['text']?>">
    </div>

    <div class="form-group">
        <input type="submit"  class="btn btn-primary" name="" id="">
        <input type="reset"  class="btn btn-dark" name="" id="">
    </div>
</form>

<?php
if (isset($_GET['text'])){
    $arr = array();
    $ptrn = '~^(?=.{8,})(?:[a-z0-9]*_?[a-z0-9]+|[a-z0-9]+_?[a-z0-9]*)@[a-z]{2,}\\.(?:ru|com|net|by)$~';
    $matches = preg_match($ptrn,$_GET['text'],$arr);

    echo "<hr><h2>Результат:</h2>";
    if (!empty($arr)):?>
        <div class="alert alert-success" role="alert">
            Email хорош
        </div>
    <?else:?>
        <div class="alert alert-danger" role="alert">
            Что то не так ! :(
        </div>
    <?php
    endif;
}
?>