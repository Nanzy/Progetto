<?php
	require_once("Gestore_Carrello_Control.php");
	$gestore = new Gestore_Carrello_Control();
	$panino = $_GET['panino'];
	$nome = $_GET['nome_menu'];
	$email = $_GET['email'];
	$prezzo = $_GET['prezzo'];
	$quantita = $_GET['quant'];
	
	if(!(is_numeric($quantita)))
	{
		die('Errore Quantità');
	}
	
	$contorno = $_GET['contorno'];
	$bibita = $_GET['bibita'];
	$aggiuntivo = $_GET['aggiuntivo'];
	
	$componenti = explode("," , $aggiuntivo[0]);
	
	$risultato_menu = $gestore->creaMenuScelto($nome, $prezzo, $quantita);
	
	
	if(strpos($risultato_menu, 'Error') !== TRUE)
	{
		$risultato_panino = $gestore->creaCompostoDa($risultato_menu, $panino);
		$risultato_contorno = $gestore->creaCompostoDa($risultato_menu, $contorno);
		$risultato_bibita = $gestore->creaCompostoDa($risultato_menu, $bibita);

		echo $risultato_panino;
		echo $risultato_contorno;
		echo $risultato_bibita;
	
		if(!isset($aggiuntivo))
		{
		for($i=0; $i<count($componenti); $i++)
		{
			$riusltato_aggiuntivo = $gestore->creaCompostoDa($risultato_menu, $componenti[$i]);
			echo $riusltato_aggiuntivo;
		}
		}

	$risultato = $gestore->aggiungiAlCarrello($risultato_menu,$email);
	echo $risultato;
	} 
	else echo $risultato_menu;
	
	
	
	
	


	
?>