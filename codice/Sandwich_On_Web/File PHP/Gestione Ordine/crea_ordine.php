<?php
	require_once("Gestore_Ordine_Control.php");
	$gestore = new Gestore_Ordine_Control();
	
	$email = $_GET['email'];
	$nome = $_GET['nome'];
	$indirizzo = $_GET['indirizzo'];
	$orario = $_GET['orario'];
	$menu_scelti = $_GET['menu_scelti'];
	

	
	$menu = explode("," , $menu_scelti[0]);

	
	$risultato_ordine = $gestore->checkout($email, $nome, $indirizzo, $orario);
	if(strpos($risultato_ordine, 'Error') !== TRUE)
	{
		for($i=0; $i<count($menu); $i++)
		{
			$risultato_possiede = $gestore->creaPossiede($risultato_ordine , $menu[$i]);
			echo $risultato_possiede;
		}
	}
	else echo $risultato_ordine;
	
	


?>