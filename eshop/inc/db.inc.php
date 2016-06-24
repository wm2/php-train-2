<?php
//header('Content-Type:
//        text/html;charset=utf-8');
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', 'admin');
define('DB_NAME', 'eshop');
define('ORDERS_LOG', 'orders.log');

//Корзина покупателя
$basket = array();
//Колличество товаров покупателя
$count = 0;
//Коннектимся к базе
$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());

basketInit();

?>

