<h2>Задание №4</h2>
<p>Дан текст. Заменить все email в этом тексте на '[email]'. Например, 'пишите мне на itmathrepetitor@gmail.ru по любому вопросу' преобразуется в 'пишите мне на [email] по любому вопросу'.</p>
<hr>

<form action="" method="get">
    <div class="form-group">
        <label for="">Текст:</label>
        <textarea class="form-control" name="text" id="" rows="10" ><?=$_GET['text']?></textarea>
    </div>

    <div class="form-group">
        <input type="submit"  class="btn btn-primary" name="" id="">
        <input type="reset"  class="btn btn-dark" name="" id="">
    </div>
</form>

<?php
    if (isset($_GET['text'])){
        $arr = array();
        $ptrn = '/\b([a-z0-9._-]+@[a-z0-9.-]+)\b/';
        $matches = preg_match_all($ptrn,$_GET['text'],$arr);

        $new_text = str_replace($arr[0], "[email]", $_GET['text']);

        echo "<hr><h2>Результат:</h2>";
        echo "<p>";
        echo $new_text;
        echo "</p>";
    }
?>