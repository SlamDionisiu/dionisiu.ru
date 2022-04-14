<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/HEADER.php");?>
<!--НАЧАЛО СТРАНИЦЫ-->

<?php
//указание пути сессии
session_save_path();
//старт сесии
session_start();

//если генирируем новые значение:
if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["rows"]) && isset($_POST["cols"]) && $_POST["act"]=="new_arr"){

    //значение строк и колонок для инпутов
    $rows = (int)$_POST["rows"];
    $cols = (int)$_POST["cols"];
    $arr = array();

    //генирация массива
    for($i=0;$i<$rows;$i++){
        $newarray = array();
        for($j=0;$j<$cols;$j++){
            $newarray[] = mt_rand(1,100);
        }
        $arr[] = $newarray;
    }

    $_SESSION['array'] = $arr;

    //sessia col row
}

//если ищем наибольшее:
if ($_SERVER["REQUEST_METHOD"]=="POST" && $_POST["act"]=="max_arr"){

    $arrNumbers = $_SESSION['array'];

    //поиск наибольшего
    $biggerNumber = 0;
    if (!empty($arrNumbers)){
        foreach ($arrNumbers as $arrNumbersRow ){
            if(!empty($arrNumbersRow)){
                foreach ($arrNumbersRow as $numberVal ){
                    if ($numberVal > $biggerNumber){
                        $biggerNumber = $numberVal;
                    }
                }
            }
        }
    }
}
?>

<h2>Задание №2 </h2>
<p>Подготовить форму для ввода размерности двумерного массива. После ввода по нажатию на кнопку “Найти”: <br>
<ul>
    <li>Создать двумерный массив, заданной размерности;</li>
    <li>Заполнить созданный массив рандомными числами от 1 до 1000. Значения в массиве не должны повторяться </li>
    <li>Найти наименьший элемент и “подсветить” его стилями. </li>
</ul>

Все действия должны выполняться в один шаг. Массив должен выглядеть аккуратно.
</p>
<hr>

<form method="post" action="index.php" id="test">
    <div class="form-group">
        <label for="rows-count" class="col-form-label">Число строк </label>
        <input name="rows" type="number" min="1" max="25" class="form-control" id="rows-count" placeholder="от 1 до 25" value="<?=$rows?>" required>
    </div>
    <div class="form-group">
        <label for="cols-count" class="col-form-label">Число столбцов </label>
        <input name="cols" type="number" min="1" max="25" class="form-control" id="cols-count" placeholder="от 1 до 25" value="<?=$cols?>" required>
    </div>
    <!-- тип запроса -->
    <input type="hidden" name="act" value="new_arr">
    <button type="submit" class="btn btn-primary mb-2">Выполнить</button>
</form>

<hr>
<h2>Результат:</h2>

<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <?if($cols!=0):?>
                <th scope="col">#</th>
            <?else:?>
                <p>Пока тут ничего нет ...</p>
            <?endif;?>

            <?for($i=1;$i<=$cols;$i++):?>
                <th scope="col"><?=$i?></th>
            <?endfor;?>
        </tr>
        </thead>
        <tbody>
        <?php for($i=1;$i<=$rows;$i++):?>
            <tr>
                <?= "<th scope='row'>$i</th>" ?>
                <?php for($j=1;$j<=$cols;$j++):?>
                    <?php if($arr[$i-1][$j-1]==$biggerNumber):?>
                        <!-- если число наибольшее -->
                        <td><span class="badge badge-danger"><?=$arr[$i-1][$j-1]?></span></td>
                    <?php else:?>
                        <!-- если просто число -->
                        <td><?=$arr[$i-1][$j-1]?></td>
                    <?php endif;?>

                <?php endfor;?>
            </tr>
        <?php endfor;?>
        </tbody>
    </table>
</div>

<?php if(isset($rows) && isset($cols)):?>
    <form method="POST" action="">
        <!-- строки  -->
        <input type="hidden" name="rows" value="<?=$rows?>">
        <!-- колонки -->
        <input type="hidden" name="cols" value="<?=$cols?>">
        <!-- тип запроса -->
        <input type="hidden" name="act" value="max_arr">
        <button type="submit" class="btn btn-primary mb-2">Найти наибольшее</button>
    </form>
<?php endif;?>

<!--КОНЕЦ СТРАНИЦЫ-->
<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/FOOTER.php");?>