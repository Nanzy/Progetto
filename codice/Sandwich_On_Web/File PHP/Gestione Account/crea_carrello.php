<?php
	require_once("Gestore_Account_Control.php");
	
        $gestore = new Gestore_Account_Control();
	$email = $_GET['email'];
	
	$risultato = $gestore->creaCarrello($email);

	echo $risultato;
?>