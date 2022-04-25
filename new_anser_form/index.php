<?
//ПОДКЛЮЧЕНИЕ КОНФИГУРАЦИОНОГО МАССИВА

include($_SERVER['DOCUMENT_ROOT']."/src/form_engine/script_v2.php");
?>

<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/HEADER.php");?>
<!--НАЧАЛО СТРАНИЦЫ-->

<!--ГЕНИРАЦИЯ ФОРМ-->
<? FORM($FORM_CONFIG); ?>

<!--КОНЕЦ СТРАНИЦЫ-->
<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/FOOTER.php");?>