<?php
	require_once("Gestore_Ordine_Control.php");
	$gestore = new Gestore_Ordine_Control();
	$email = $_GET['email'];
	$ordine = $gestore->creaVisualizzaOrdiniLista($email);
	echo $ordine;
	
?>