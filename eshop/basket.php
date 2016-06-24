<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/db.inc.php";
?>
<html>
<head>
	<title>Корзина пользователя</title>
</head>
<body>
	<h1>Ваша корзина</h1>
<?php

?>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N п/п</th>
	<th>Название</th>
	<th>Автор</th>
	<th>Год издания</th>
	<th>Цена, руб.</th>
	<th>Количество</th>
	<th>Удалить</th>
</tr>
<!--	<pre>-->
		<?php
		$i = 1;
		$sum =0;


$goods = myBasket();
	if($goods === false)
	{
		echo "Корзина пуста! Вернитесь в <a href='catalog.php'>каталог</a>";
		exit;
	}
	if($goods){
		echo "Вернуться в <a href='catalog.php'>каталог</a>";
	}
foreach ($goods as $item) {;?>

	<tr>
		<td><?= $i?></td>
		<td><?= $item ['author']?></td>
		<td><?= $item ['title']?></td>
		<td><?= $item ['pubyear']?></td>
		<td><?= $item ['price'] * $item['q']?></td>
		<td><?= $item ['q']?></td>
		<td><a href="delete_from_basket.php?id=<?=$item['id']?>">Удалить</a></td>
	</tr>

		<?php
	$i++;
		$sum = $sum + $item['q'] * $item['price'];
}

		?>
<!--		</pre>-->
	<br/>
</table>

<p>Всего товаров в корзине на сумму: <?=$sum?> руб.</p>

<div align="center">
	<input type="button" value="Оформить заказ!"
                      onClick="location.href='orderform.php'" />
</div>

</body>
</html>







