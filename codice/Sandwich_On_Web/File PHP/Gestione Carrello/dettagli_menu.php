<?php
	require("Gestore_Carrello_Control.php");
	$gestore = new Gestore_Carrello_Control();
	$id_menu = $_GET['id_menu'];
	$componente = $gestore->dettagliMenù($id_menu);
	echo $componente;
			
			
			
			
	
?>