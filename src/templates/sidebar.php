<?php
    $menuDataArray = array(
        'Главное меню'              => '',
        'Задание 1'                 => 'task/1',
        'Задание 2'                 => 'task/2',
        'Задание 3'                 => 'task/3',
        'Задание 4'                 => 'task/4',
        'Задание 5'                 => 'task/5',
        'Задание 6'                 => 'task/6',
        'Задание 7'                 => 'task/7',
        'Задание 8'                 => 'task/8',
        'Тест почты'                => 'mail',
        'Форма обратной связи'      => 'anser_form',
        'Новоя форма обратной связи'=> 'new_anser_form',

    );

    $url = $_SERVER['PHP_SELF'];
    $urlArray = explode('/',$url);
    unset($urlArray[0]); // удаляем домен
    unset($urlArray[array_key_last($urlArray)]); // удаляем Index.php
    $urlWithoutDomen = implode('/', $urlArray);
?>

<div class="row">
    <div class="col sb-group">
        <div class="btn-group-vertical side-menu" role="group" aria-label="меню">
            <?foreach ($menuDataArray as $menuPointName => $menuPointURL):?>
                <?if($menuPointURL == $urlWithoutDomen):?>
                    <span class="btn btn-secondary active" role="button"><?=$menuPointName?></span>
                <?else:?>
                    <a class="btn btn-secondary" href="<?='/'.$menuPointURL?>" role="button"><?=$menuPointName?></a>
                <?endif?>
            <?endforeach;?>
        </div>
    </div>
</div>


