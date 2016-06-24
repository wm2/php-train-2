<?php
	require "inc/lib.inc.php";
	require "inc/db.inc.php";
global $basket;
		$name = clearStr($_POST['name']);
		$email = clearStr($_POST['email']);
		$phone = clearStr($_POST['phone']);
		$address = clearStr($_POST['address']);
		$orderid = $basket['orderid'];
		$dt = time();

			$order = "$name|$email|$phone|$address|$orderid|$dt\n";
//			echo $order;
			print_r($basket);

			file_put_contents(ORDER_LOG, $order, FILE_APPEND);
		saveOrder($dt);
?>
<html>
<head>
	<title>Сохранение данных заказа</title>
</head>
<body>
	<p>Ваш заказ принят.</p>
	<p><a href="catalog.php">Вернуться в каталог товаров</a></p>
</body>
</html>