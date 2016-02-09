function checkValidità(id)
{
	if(document.getElementById('no_aggiuntivo').checked == true)
	{
		if (arguments[0] != null) alert("Deseleziona la voce 'nessun aggiuntivo' per selezionare le componenti");
		var inputElements = document.getElementsByClassName('aggiuntivo');
		for(var i=0; inputElements[i]; ++i)
		{
			inputElements[i].checked = false;
		}
	}
}

function visualizza()
{
	location.href = "Lista_Menu_Account.html";
}
function listaMenu()
{
		
		if (window.XMLHttpRequest) 
		{   
			var xhr = new XMLHttpRequest();   
			xhr.onreadystatechange = gestoreRichiesta;  
			xhr.open("GET", "File%20PHP/Gestione%20Menu/lista_menu.php", true);   
			xhr.send("");
		} 
		
		function gestoreRichiesta() 
		{   
			
			if (xhr.readyState == 4 && xhr.status==200) 
			{
				
				str = xhr.responseText;	
				menu = str.split("-");
			
			if(menu == undefined || menu == "" || menu == null)
			{
				paragrafo = document.createElement("p");
				paragrafo.setAttribute("id", "vuoto");
				paragrafo.innerHTML = "Nessun men&ugrave; presente!";
				document.body.appendChild(paragrafo);
			}
			else
			{
				div_lista = document.createElement("div");
				div_lista.setAttribute("id", "div_lista");
				
				for(i=0; i<menu.length-1; i++)
				{
					menu_car = menu[i].split("  ");
					div_lista.innerHTML += "<div class='div_menu' onclick='errore_utente()'> <img class='icona' src='Immagini//content.jpg' height='100' width='100'> NOME: <span>"+menu_car[0]+ "</span> PREZZO: <span>"+menu_car[1]+ "</span> DISPONIBILITA': <span>"+menu_car[2]+ "</span> <img class='etichetta' src='Immagini//lista_etichetta.bmp'> </div> <br>";
				}
				
				document.body.appendChild(div_lista);
			}
			} 
			
		} 
			
}
		
	function errore_utente()
	{
		alert("Devi essere registrato per selezionare un menu!");
	}
	
		
	function aggiungiQuick(id_bottone)
	{
			
			menu_scelto = document.getElementById("menu["+id_bottone+"]").value;
			menu_car = menu_scelto.split("  ");
			
				if (window.XMLHttpRequest) 
				{   
					str = "?nome_menu="+menu_car[0]+"&email="+a[2];
					var xhr = new XMLHttpRequest();   
					xhr.onreadystatechange = gest;  
					xhr.open("GET", "File%20PHP/Gestione%20Menu/aggiungi_quick.php"+str, true);   
					xhr.send("");
				} 
			
		
			function gest() 
			{   
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					str = xhr.responseText;
					if(str == null || str=="")
					{
						alert("Menu "+menu_car[0]+" aggiunto a quickmenu!"); 
					}
					else
					{
						alert(""+str); 
					}
				} 
			} 
	}
		
function parseGetVars()
{
  var args = new Array();
  var query = window.location.search.substring(1);
 
  if (query)
  {
    var strList = query.split('&');
   
    for(str in strList)
    {
    
      var parts = strList[str].split('=');
      args[unescape(parts[0])] = unescape(parts[1]);
    }
  }
  return args;
}

	function listaComponenti()
	{
			
		if (window.XMLHttpRequest) 
		{   
			var xhr = new XMLHttpRequest();   
			xhr.onreadystatechange = gestoreRichiesta;  
			xhr.open("GET", "File%20PHP/Gestione%20Menu/lista_componenti.php?menu="+menu_car[0], true);   
			xhr.send("");
		} 
		
		function gestoreRichiesta() 
		{   
			
			if (xhr.readyState == 4 && xhr.status==200) 
			{
				str = xhr.responseText;	
				componenti = str.split("-");
				div_lista = document.createElement("div");
				div_lista.setAttribute("id", "div_lista");
				stringa="";
				stringa += "<form name='componenti_form' id='componenti_form'>";
				
				flagPanino = false;
			flagAggiuntivo = false;
			flagBibita = false;
			flagContorno = false;
			
			for(i=0; i<componenti.length-1; i++)
			{
				comp_car = componenti[i].split("/");
				if(comp_car[1].indexOf("PANINO") > -1)
				{
					if(flagPanino == false ) 
					{
						stringa +="<h2> PANINO </h2> <br>";
						stringa +="<div id='panino_div'>";
						stringa +="<input type='radio' id='panino"+i+"' name='panino' value='"+comp_car[0]+"'>"+comp_car[0]+"<br>";
						stringa +="<p>"+ comp_car[2] + "</p> </div> <br>";
						flagPanino = true;
					}
					else
					{
					stringa +="<input type='radio' id='panino"+i+"' name='panino' value='"+comp_car[0]+"'>"+comp_car[0]+"<br>";
					stringa +="<p>"+ comp_car[2] + "</p> <br>";
					}
				}
				
				if(comp_car[1].indexOf("AGGIUNTIVO") > -1)
				{
					if(flagAggiuntivo == false ) 
					{
						stringa +="<h2> AGGIUNTIVO </h2> <br>";
						stringa += "<input type='checkbox' id='no_aggiuntivo' value='' onclick='checkValidità()'>  NESSUN AGGIUNTIVO <br>";
						flagAggiuntivo = true;
					}
						stringa +="<input type='checkbox' class='aggiuntivo' id='aggiuntivo"+i+"' name='aggiuntivo"+i+"' value='"+comp_car[0]+"' onclick='checkValidità(this.id)'>"+comp_car[0]+ " ----- " + comp_car[3] +"<br>";
					
				}
				
				if(comp_car[1].indexOf("BIBITA") > -1)
				{
					if(flagBibita == false ) 
					{
						stringa +="<h2> BIBITA </h2> <br>";
						stringa +="<div id='bibita_div'>";
						stringa +="<input type='radio' id='bibita"+i+"' name='bibita' value='"+comp_car[0]+"'>"+comp_car[0]+"</div> <br>";
						flagBibita = true;
					}
					else
					{
					stringa +="<input type='radio' id='bibita"+i+"' name='bibita' value='"+comp_car[0]+"'>"+comp_car[0]+"<br>";
					}
				}
				
				if(comp_car[1].indexOf("CONTORNO") > -1)
				{
					if(flagContorno == false ) 
					{
						stringa +="<h2 id='contorno_header'> CONTORNO </h2> <br>";
						stringa +="<div id='contorno_div'>";
						stringa +="<input type='radio' id='contorno"+i+"' name='contorno' value='"+comp_car[0]+"'>"+comp_car[0]+"<br>";
						flagContorno = true;
					}
					else
					{
					stringa +="<input type='radio' id='contorno"+i+"' name='contorno' value='"+comp_car[0]+"'>"+comp_car[0]+"<br>";
					}
				}
				

				
				
			
			} 
			stringa +=" <h2> QUANTITA' </h2> <input type='number' id='quant' name='quantita' min='1' max='"+menu_car[2]+"'> <br>";
			stringa +="<div id='right'> <input class='button_conferma' type='button' value='Annulla' onclick='visualizza()'> <input class='button_conferma' type='button' value='aggiungi al carrello' onclick='aggiungiCarrello()'>";
			stringa +="</div> </form>";
			div_lista.innerHTML = stringa;
			document.body.appendChild(div_lista);
			document.getElementById('no_aggiuntivo').checked = true;
			document.getElementById('panino_div').firstChild.checked = true;
			document.getElementById('bibita_div').firstChild.checked = true;
			document.getElementById('contorno_div').firstChild.checked = true;
			document.getElementById('quant').value= '1';
			
		} 
			
	}
		
	}
	
function listaMenu_Account()
{
		
		if (window.XMLHttpRequest) 
		{   
			var xhr = new XMLHttpRequest();   
			xhr.onreadystatechange = gestoreRichiesta;  
			xhr.open("GET", "File%20PHP/Gestione%20Menu/lista_menu.php", true);   
			xhr.send("");
		} 
		
		function gestoreRichiesta() 
		{   
			
			if (xhr.readyState == 4 && xhr.status==200) 
			{
				
				str = xhr.responseText;	
				menu = str.split("-");
			
			if(menu == undefined || menu == "" || menu == null)
			{
				paragrafo = document.createElement("p");
				paragrafo.setAttribute("id", "vuoto");
				testo = document.createTextNode("Nessun menu presente!");
				paragrafo.appendChild(testo);
				document.body.appendChild(paragrafo);
			}
			else
			{
				div_lista = document.createElement("div");
				div_lista.setAttribute("id", "div_lista");
				
				for(i=0; i<menu.length-1; i++)
				{
					menu_car = menu[i].split("  ");
					div_lista.innerHTML += "<input class='button_quick' type='button' id='"+i+"' value='Aggiungi a QuickMen&ugrave;' onclick='aggiungiQuick(this.id)'>"
					+"<form method='GET' action='File%20PHP/Gestione%20Menu/FormComponenti.php'> <div class='div_menu' onclick='this.parentNode.submit()'> "
					+"<img class='icona' src='Immagini//content.jpg' height='100' width='100'> <input type='hidden' id='menu["+i+"]' name='menu_scelto' value='"+menu[i]+"'> NOME: <span>"+menu_car[0]+ "</span> PREZZO: <span>"+menu_car[1]+ "</span> DISPONIBILITA': <span>"+menu_car[2]+ "</span> "
					+"<img class='etichetta' src='Immagini//lista_etichetta.bmp'> </div> </form><br>";
				}
				
				document.body.appendChild(div_lista);
			}
			} 
			
		} 
			
}



	