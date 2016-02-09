<?php
	require_once("Gestore_QuickMenu_Control.php");
	
	$gestore = new Gestore_QuickMenu_Control();
	$nome = $_GET['nome_menu'];
	$email = $_GET['email'];

	$risultato = $gestore->eliminaQuickMenù($nome,$email);

	echo $risultato;
?>