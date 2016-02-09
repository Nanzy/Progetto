<?php
	require_once("Gestore_Account_Control.php");
	
        $gestore = new Gestore_Account_Control();
	$account = $_COOKIE['Account_Accesso'];
	if($account != null || $account != "")
		echo $account;
	else echo null;
?>