<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/db.inc.php";

	$ask = clearInt($_GET['id']);
	if($ask){
		deleteItemFromBasket($ask);
		header('Location: basket.php');
	}
?>