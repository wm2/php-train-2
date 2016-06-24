<!-- Основные настройки -->
<?php
error_reporting(0);
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', 'admin');
define('DB_NAME', 'gbook');
$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);

//<!-- Основные настройки -->

//<!-- Сохранение записи в БД -->
if (!empty($_POST)) {
    $name = $_POST['name'] = strip_tags(trim($_POST['name']));
    $email = $_POST['email'] = strip_tags(trim($_POST['email']));
    $msg = $_POST['msg'] = strip_tags(trim($_POST['msg']));
    $query = "INSERT INTO msgs (name, email, msg) VALUES ('$name', '$email', '$msg')";
    $result = mysqli_query($link, "SET NAMES 'cp1251'");
    $result = mysqli_query($link, $query);
    header('Location: ' .$_SERVER['REQUEST_URI']);

}

//<!-- Сохранение записи в БД -->

//<!-- Удаление записи из БД -->
$delid = $_GET['del'];
if ($delid){
    $query = "DELETE FROM msgs WHERE id = $delid";
        mysqli_query($link, $query);
    header('Location: ' .$_SERVER['SCRIPT_NAME']. '?id=gbook');
    exit;
}

//<!-- Удаление записи из БД -->

?>
<h3>Оставьте запись в нашей Гостевой книге</h3>

<form method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
        Имя: <br/><input type="text" name="name" value="<?=$_POST['name']?>"/><br/>
        Email: <br/><input type="text" name="email" value="<?=$_POST['email']?>"/><br/>
        Сообщение: <br/><textarea name="msg"><?=$_POST['msg']?></textarea><br/>

    <br/>

        <input type="submit" value="Отправить!"/>

</form>
<!-- Вывод записей из БД -->
<?php
    $query = "SELECT id, name, email, msg, UNIX_TIMESTAMP(datetime) as dt FROM msgs ORDER BY id DESC";
    $result = mysqli_query($link, "SET NAMES 'cp1251'");
    $result = mysqli_query($link, $query);
    mysqli_close($link);
    $count = 0;
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    ?>
        <p>
            <a href="mailto:<?=$row['email']?>"><?=$row['name']?></a> <?=date('d-m-Y',$row['dt'])?> в <?=date('H-i-s',$row['dt'])?> написал <br/><?=$row['msg']?>
        </p>
        <p align="right">
            <a href="http://192.168.56.101/php.train/index.php?id=gbook&del=<?=$row['id']?>">Удалить</a>
        </p>
    <?php
    $count++;
}
?>
<!-- Вывод записей из БД -->
<p>Всего записей в гостевой книге: <?= $count ?></p>