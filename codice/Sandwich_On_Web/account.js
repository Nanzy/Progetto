function logout()
{
	if (window.XMLHttpRequest) 
	{   
		var xhr = new XMLHttpRequest();   
				
		xhr.open("GET", "File%20PHP/Gestione%20Account/logout.php");   
		xhr.send("");
	} 
		cancellaCookie("Account_Accesso");
		location.href = "Home_Page.html";
}

function logIn()
{
	
	location.href = "logIn.html"
}
		
function registrazione()
{
	location.href = "Registrazione.html"
}

function accesso()
{
	email = document.getElementById("text_email").value;
	pass = document.getElementById("text_pass").value;
	if (document.getElementById('radio_cliente').checked) 
		tipo = document.getElementById('radio_cliente').value;	
	if (document.getElementById('radio_amministratore').checked) 
		tipo = document.getElementById('radio_amministratore').value;
			
		if (window.XMLHttpRequest) 
			{   
				var xhr = new XMLHttpRequest();   
				xhr.onreadystatechange = gestoreRichiesta;  
				xhr.open("GET", "cookie.php?email="+email+"&pass="+pass+"&tipo="+tipo, true);   
				xhr.send("");
			} 
		
		function gestoreRichiesta() 
		{
			if (xhr.readyState == 4 && xhr.status==200) 
			{ 
				str = xhr.responseText;
				if(str == null || str=="")
					alert("Errore - Account non presente, effettutare registrazione"); 
				else
				{
					alert("Benvenuto "+str); 
					location.href = "Home_Account.html";
				}
			} 
				
		} 
}

function registrazione_utente()
{
			
			nome = document.getElementById("text_nome").value;
			cognome = document.getElementById("text_cognome").value;
			email = document.getElementById("text_email").value;
			pass = document.getElementById("text_pass").value;
			citta = document.getElementById("text_citta").value;
			indirizzo = document.getElementById("text_indirizzo").value;
			cap = document.getElementById("text_cap").value;
			telefono = document.getElementById("text_telefono").value;
			
			if(nome == null || cognome == null || email == null || pass == null || citta == null || indirizzo == null || cap == null || telefono == null || nome == "" || cognome  == ""  || email  == ""  || pass  == ""  || citta  == ""  || indirizzo  == ""  || cap  == ""  || telefono == "" )
			{
				alert("Inserisci tutti i campi richiesti!");
			}
			else
			{
				if (window.XMLHttpRequest) 
				{   
					str = "?nome="+nome+"&cognome="+cognome+"&email="+email+"&pass="+pass+"&citta="+citta+"&indirizzo="+indirizzo+"&cap="+cap+"&telefono="+telefono;
					var xhr = new XMLHttpRequest();   
					xhr.onreadystatechange = gestoreRichiesta;  
					xhr.open("GET", "File%20PHP/Gestione%20Account/registrazione.php"+str, true);   
					xhr.send("");
				} 
			}
		
			function gestoreRichiesta() 
			{   
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					str = xhr.responseText;
					if(str == null || str=="")
					{
						creaCarrello(email);
					}
					else
					{
						alert(""+str); 
					}
				} 
			} 
}
		
function creaCarrello(email)
{
			if (window.XMLHttpRequest) 
				{   
					str = "?email="+email;
					var xhr = new XMLHttpRequest();   
					xhr.onreadystatechange = gestoreRichiesta;  
					xhr.open("GET", "File%20PHP/Gestione%20Account/crea_carrello.php"+str, true);   
					xhr.send("");
				} 
				
				function gestoreRichiesta() 
			{   
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					str = xhr.responseText;
					if(str == null || str=="")
					{
						alert("Registazione effettuata!"); 
						location.href = "logIn.html";
					}
					else
					{
						alert(""+str); 
					}
				} 
			} 
}

function modifica()
{
	location.href = "Modifica_Account.html";
}


function modificaDati()
{
	pass = document.getElementById("text_pass").value;
	email = document.getElementById("text_email").value;
	citta = document.getElementById("text_citta").value;
	indirizzo = document.getElementById("text_indirizzo").value;
	cap = document.getElementById("text_cap").value;
	telefono = document.getElementById("text_telefono").value;
	
	if (window.XMLHttpRequest) 
	{   
		str = "?&email="+email+"&pass="+pass+"&citta="+citta+"&indirizzo="+indirizzo+"&cap="+cap+"&telefono="+telefono;
		var xhr = new XMLHttpRequest();   
		xhr.onreadystatechange = gestoreRichiesta;  
		xhr.open("GET", "File%20PHP/Gestione%20Account/modifica_dati.php"+str, true);   
		xhr.send("");
				
	}
		
	function gestoreRichiesta() 
	{   
		if (xhr.readyState == 4 && xhr.status==200) 
		{ 
			str = xhr.responseText;
			if(str == null || str=="")
			{
				alert("Modifica Effettuata! Rieffettua il Login con i nuovi dati");
				location.href = "LogIn.html";
			}
			else
			{
				alert(""+str); 
			}
		} 		
	} 
}