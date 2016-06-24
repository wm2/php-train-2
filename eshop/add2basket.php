<?php
// ����������� ���������
require "inc/lib.inc.php";
require "inc/db.inc.php";
//echo $_GET['id'];
$id = clearInt($_GET['id']);
$q = 1;
add2Basket ($id, $q);
exit;
//header('Location: catalo')
//add2Basket($_GET['id'], $q);

?>