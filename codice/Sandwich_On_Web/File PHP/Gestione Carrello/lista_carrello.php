<?php
	require_once("Gestore_Carrello_Control.php");
	$gestore = new Gestore_Carrello_Control();
	$email = $_GET['email'];
	$menu = $gestore->creaVisualizzaCarrelloLista($email);
	echo $menu;
?>