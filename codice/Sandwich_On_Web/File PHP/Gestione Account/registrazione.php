<?php
	require_once("Gestore_Account_Control.php");
	
    $gestore = new Gestore_Account_Control();
	$nome = $_GET['nome'];
	$cognome = $_GET['cognome'];
	$email = $_GET['email'];
	$pass = $_GET['pass'];
	$citta = $_GET['citta'];
	$indirizzo = $_GET['indirizzo'];
	$cap = (int) $_GET['cap'];
	$telefono = $_GET['telefono'];
	
	if(!preg_match("/^[a-zA-Z ]*$/",$nome))
	{
		die('Puoi inserire solo spazi e lettere nel nome');
	}
	else if(!preg_match("/^[a-zA-Z ]*$/",$cognome))
	{
		die('Puoi inserire solo spazi e lettere nel cognome');
		
	}
	else if(!(is_numeric($telefono)))
	{
		die('Puoi inserire solo numeri nel campo Telefono');
	}
	else
	{
	$risultato = $gestore->creaAccount($nome, $cognome, $email, $pass, $citta, $indirizzo, $cap, $telefono);

	echo $risultato;

	}
	
?>