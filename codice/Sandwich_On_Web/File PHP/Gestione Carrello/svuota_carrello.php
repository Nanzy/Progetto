<?php
	require_once("Gestore_Carrello_Control.php");
	$gestore = new Gestore_Carrello_Control();
	$codici = $_GET['codici'];
	
	$menu_codici = explode("," , $codici[0]);
	
	$riusltato_menu = $gestore->svuotaCarrello($menu_codici);
	echo $riusltato_menu;
	
		

	
	
	
	
	
	


	
?>