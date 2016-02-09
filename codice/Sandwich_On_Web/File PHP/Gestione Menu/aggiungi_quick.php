<?php
	require_once("Gestore_Menu_Control.php");
	
	$gestore = new Gestore_Menu_Control();
	$nome = $_GET['nome_menu'];
	$email = $_GET['email'];

	$risultato = $gestore->aggiungiAQuickMenù($nome,$email);

	echo $risultato;
?>