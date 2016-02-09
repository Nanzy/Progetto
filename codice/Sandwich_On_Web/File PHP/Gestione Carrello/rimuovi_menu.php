<?php
	require_once("Gestore_Carrello_Control.php");
	$gestore = new Gestore_Carrello_Control();

	$id_menu = $_GET['nome_menu'];
	
	$risultato = $gestore->eliminaMenù($id_menu);

	echo $risultato;
?>