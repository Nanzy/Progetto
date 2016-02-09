<?php
	require_once("Gestore_Recensione_Control.php");
	$gestore = new Gestore_Recensione_Control();
	
	$email = $_GET['email'];
	$titolo = $_GET['titolo'];
	$testo = $_GET['testo'];
	$nickname = $_GET['nickname'];
	$valutazione = $_GET['valutazione'];
	
	if(!preg_match("/^([a-zA-Z\xE0\xE8\xE9\xF9\xF2\xEC\x27]\s?)+$/",$titolo))
	{
		die('Puoi inserire solo caratteri alfabetici nel titolo');
	}
	else if(!preg_match("/^([a-zA-Z\xE0\xE8\xE9\xF9\xF2\xEC\x27]\s?)+$/",$nickname))
	{
		die('Puoi inserire solo caratteri alfabetici nel nickname');
	}
	else
	{
		$risultato = $gestore->creaRecensione($email, $titolo, $nickname, $testo, $valutazione);
		echo $risultato;
	}
	
	


?>