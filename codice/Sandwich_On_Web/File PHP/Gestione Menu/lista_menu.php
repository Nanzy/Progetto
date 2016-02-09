<?php
	require_once("Gestore_Menu_Control.php");
	$gestore = new Gestore_Menu_Control();
	$menu = $gestore->creaListaMenùForm();
	echo $menu;
?>