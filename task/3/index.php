<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/HEADER.php");?>
<!--НАЧАЛО СТРАНИЦЫ-->

    <h2>Задание №3</h2>
    <p>Подготовить форму для ввода числа и отправки ее на сервер, где PHP скрипт проверяет, входит ли данное число в диапазон от 1000 до 2000 и затем возвращает его пользователю в таком виде (число, разбитое на разряды + расшифровка словами):
        "2 853 - две тысячи восемьсот пятьдесят три - входит в диапазон"
        "4 654 187 - четыре миллиона шестьсот пятьдесят четыре тысячи сто восемьдесят семь - не входит в диапазон".
    </p>
    <hr>
    <form action="" method="get">
        <div class="form-group">
            <label for="">Число:</label>
            <input class="form-control" type="number" name="number" min="-999999999999" max="999999999999" placeholder="Введите любое число" value="<?=$_GET['number']?>">
        </div>

        <div class="form-group">
            <input type="submit"  class="btn btn-primary" name="" id="">
            <input type="reset"  class="btn btn-dark" name="" id="">
        </div>
    </form>

<?php
function num2word($n,$words) {
    return ($words[($n=($n=$n%100)>19?($n%10):$n)==1 ? 0 : (($n>1&&$n<=4)?1:2)]);
}

function sum2words($n) {
    $nn = $n;
    $n = abs($n);
    $words=array(
        900=>'девятьсот',
        800=>'восемьсот',
        700=>'семьсот',
        600=>'шестьсот',
        500=>'пятьсот',
        400=>'четыреста',
        300=>'триста',
        200=>'двести',
        100=>'сто',
        90=>'девяносто',
        80=>'восемьдесят',
        70=>'семьдесят',
        60=>'шестьдесят',
        50=>'пятьдесят',
        40=>'сорок',
        30=>'тридцать',
        20=>'двадцать',
        19=>'девятнадцать',
        18=>'восемнадцать',
        17=>'семнадцать',
        16=>'шестнадцать',
        15=>'пятнадцать',
        14=>'четырнадцать',
        13=>'тринадцать',
        12=>'двенадцать',
        11=>'одиннадцать',
        10=>'десять',
        9=>'девять',
        8=>'восемь',
        7=>'семь',
        6=>'шесть',
        5=>'пять',
        4=>'четыре',
        3=>'три',
        2=>'два',
        1=>'один',
    );

    $level=array(
        4=>array('миллиард', 'миллиарда', 'миллиардов'),
        3=>array('миллион', 'миллиона', 'миллионов'),
        2=>array('тысяча', 'тысячи', 'тысяч'),
    );

    list($rub,$kop)=explode('.',number_format($n,2));
    $parts=explode(',',$rub);

    for($str='', $l=count($parts), $i=0; $i<count($parts); $i++, $l--) {
        if (intval($num=$parts[$i])) {
            foreach($words as $key=>$value) {
                if ($num>=$key) {
                    // Fix для одной тысячи
                    if ($l==2 && $key==1) {
                        $value='одна';
                    }
                    // Fix для двух тысяч
                    if ($l==2 && $key==2) {
                        $value='две';
                    }
                    $str.=($str!=''?' ':'').$value;
                    $num-=$key;
                }
            }
            if (isset($level[$l])) {
                $str.=' '.num2word($parts[$i],$level[$l]);
            }
        }
    }

    if($nn < 0){
        $str = 'Минус '.$str;
    }

    return mb_strtoupper(mb_substr($str,0,1,'utf-8'),'utf-8').
        mb_substr($str,1,mb_strlen($str,'utf-8'),'utf-8');
}

if (isset($_GET['number'])){
    echo "<hr><h2>Результат:</h2>";
    if ($_GET['number'] >= 1000 && $_GET['number'] <= 2000){
        echo "<p>" . number_format($_GET['number'], 0, '', ' ') . " - " . sum2words($_GET['number']) . " входит в диапозон </p>" ;
    }else{
        echo "<p>" . number_format($_GET['number'], 0, '', ' ') . " - " . sum2words($_GET['number']) . " не входит в диапозон </p>" ;
    }
}
?>

<!--КОНЕЦ СТРАНИЦЫ-->
<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/FOOTER.php");?>