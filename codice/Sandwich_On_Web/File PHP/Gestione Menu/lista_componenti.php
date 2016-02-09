<?php
	require_once("Gestore_Menu_Control.php");
	$gestore = new Gestore_Menu_Control();
	$nome_menu = $_GET['menu'];
	$componente = $gestore->creaSelezioneComponentiMenùForm($nome_menu);
	echo $componente;
?>