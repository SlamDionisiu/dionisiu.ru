<?php
if (isset($_POST) && !empty($_POST['mailto']) && !empty($_POST['latter'])){
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    $mail_res = mail($_POST['mailto'],$_POST['topic'],$_POST['latter'], implode("\r\n", $headers));
}
?>

<h2>Тест почты</h2>
<p>Попробуем отправить почту</p>
<hr>

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
        <textarea id="input-cle" name="latter"></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit">
    </div>
</form>
