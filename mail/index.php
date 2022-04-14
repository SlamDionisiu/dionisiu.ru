<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/HEADER.php");?>
<!--НАЧАЛО СТРАНИЦЫ-->

<?php
if (isset($_POST) && !empty($_POST['mailto']) && !empty($_POST['latter'])){
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    $mail_res = mail($_POST['mailto'],$_POST['topic'],$_POST['latter'], implode("\r\n", $headers));
}
?>

<?php if ($mail_res==true && !empty($mail_res)):?>
    <div class="alert alert-success" role="alert">
        Ваше письмо отправлено
    </div>
<?endif;?>

    <form action="" method="post">
        <div class="form-group">
            <label for="">Кому:</label>
            <input class="form-control" type="email" name="mailto" placeholder="exzample@gmail.com" required>
        </div>
        <div class="form-group">
            <label for="">Тема:</label>
            <input class="form-control" type="text" name="topic" placeholder="Ваша тема">
        </div>
        <div class="form-group">
            <label for="">Текст письма:</label>
            <textarea class="form-control" name="latter"></textarea>
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit">
        </div>
    </form>


    <!--КОНЕЦ СТРАНИЦЫ-->
<?include($_SERVER['DOCUMENT_ROOT']."/src/templates/FOOTER.php");?>