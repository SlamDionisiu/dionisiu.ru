<?php
$link = $_SERVER['PHP_SELF'];
$link_array = explode('/',$link);
$cur_menu=  $link_array[1];

if ($cur_menu == 'mail'){

}


$task_list = count(glob(__DIR__."/task/*", GLOB_ONLYDIR));

$link = $_SERVER['PHP_SELF'];
$link_array = explode('/',$link);
$cur_task_num =  $link_array[2];
?>

<div class="row">
    <div class="col sb-group">
        <div class="btn-group-vertical side-menu" role="group" aria-label="меню">
            <?php if($cur_task_num == NULL):?>
                <a class="btn btn-secondary active" href="/" role="button">Главная</a>
            <?else:?>
                <a class="btn btn-secondary" href="/" role="button">Главная</a>
            <?endif;?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col sb-group">
        <div class="btn-group-vertical side-menu" role="group" aria-label="меню">
            <?php for ($i=1;$i<=$task_list;$i++):?>
                <a class="btn btn-secondary <?php if($cur_task_num == $i):?> active <?endif;?>" href="/task/<?=$i?> " role="button" >Задание <?=$i?></a>
            <?endfor?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col sb-group">
        <div class="btn-group-vertical side-menu" role="group" aria-label="меню">
                <a class="btn btn-secondary <?php if($cur_menu == 'mail'):?> active <?endif;?>" href="/mail" role="button"> Тест почты </a>
        </div>
    </div>
</div>


