<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/HEADER.php");?>
<!--НАЧАЛО СТРАНИЦЫ-->

    <h2>Задание №6</h2>
    <p>Создайте функцию, которая принимает строку на русском языке, а возвращает ее транслит.</p>
    <hr>
    <h3>Тестовые строки:</h3>
    <ul>
        <li><p>съешь ещё этих мягких французских булок, да выпей чаю</p></li>
        <li><p>Аэрофотосъёмка ландшафта уже выявила земли богачей и процветающих крестьян</p></li>
        <li><p>Широкая электрификация южных губерний даст мощный толчок подъёму сельского хозяйства</p></li>
        <li><p>В чащах юга жил бы цитрус? Да, но фальшивый экземпляр!</p></li>
    </ul>
    <hr>

    <form action="" method="get">
        <div class="form-group">
            <label for="">Строка:</label>
            <input type="text" class="form-control" name="text" id="" rows="10" value="<?=$_GET['text']?>">
        </div>

        <div class="form-group">
            <input type="submit"  class="btn btn-primary" name="" id="">
            <input type="reset"  class="btn btn-dark" name="" id="">
        </div>
    </form>


<?php
function rus2translit($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}

if (isset($_GET['text'])){
    echo "<hr><h2>Результат:</h2>";
    echo rus2translit($_GET['text']);
}
?>

<!--КОНЕЦ СТРАНИЦЫ-->
<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/FOOTER.php");?>