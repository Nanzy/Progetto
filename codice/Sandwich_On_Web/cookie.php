<?php
	require("File PHP\Gestione Account\Gestore_Account_Control.php");
	
	
	$email = $_GET['email'];
	$pass = $_GET['pass'];
	$tipo = $_GET['tipo'];
	$account = Gestore_Account_Control::accediAccount($email , $pass, $tipo);

	
	if($account != null)
	{
		setcookie("Account_Accesso", $account);
		echo $account->_nome;
	}
	else echo null;
?>