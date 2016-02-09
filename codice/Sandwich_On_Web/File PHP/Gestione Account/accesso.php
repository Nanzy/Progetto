<?php
	require_once("Gestore_Account_Control.php");
	
	$gestore = new Gestore_Account_Control();
	$email = $_GET['email'];
	$pass = $_GET['pass'];
	$tipo = $_GET['tipo'];
	$account = $gestore->accediAccount($email , $pass, $tipo);

	
	if($account != null)
	{
		setcookie("Account_Accesso", $account);
		echo $account->_nome;
	}
	else echo null;
?>