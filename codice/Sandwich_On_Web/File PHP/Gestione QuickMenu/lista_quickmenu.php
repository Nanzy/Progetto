<?php
	require_once("Gestore_QuickMenu_Control.php");
	
	$gestore = new Gestore_QuickMenu_Control();
	$email = $_GET['email'];
	$menu = $gestore->creaListaQuckMenù($email);
	echo $menu;
?>