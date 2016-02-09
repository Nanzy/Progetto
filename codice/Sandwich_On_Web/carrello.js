		function listaCarrelloCheckOut()
		{
		
		if (window.XMLHttpRequest) 
		{   
			var xhr = new XMLHttpRequest();   
			xhr.onreadystatechange = gestoreRichiesta;  
			xhr.open("GET", "File%20PHP/Gestione%20Carrello/lista_carrello.php?email="+a[2], false);   
			xhr.send("");
		} 
		
		function gestoreRichiesta() 
		{   
			
			if (xhr.readyState == 4 && xhr.status==200) 
			{
				str = xhr.responseText;	
				document.getElementById("data").value = str;
				menu = str.split("-");
			
			if(menu == undefined || menu == "" || menu == null)
			{
				paragrafo = document.createElement("p");
				paragrafo.setAttribute("id", "vuoto");
				paragrafo.innerHTML = "Nessun men&ugrave; aggiunto al carrello! <br> Vai nella lista men&ugrave;, componi a tua scelta il men&ugrave; e aggiungilo!";
				document.body.appendChild(paragrafo);
				
			}
			else
			{
				div_lista = document.createElement("div");
				div_lista.setAttribute("id", "div_lista");
				stringa="";
				for(i=0; i<menu.length-1; i++)
				{
					menu_car = menu[i].split("  ");
					stringa +="<div class='div_menu'> <img class='icona' src='Immagini//content.jpg' height='100' width='100'> NOME: <span>"+menu_car[0]+ "</span> PREZZO: <span>"+menu_car[1]+ "</span> QUANTITA': <span>"+menu_car[2]+ "</span> <img class='etichetta' src='Immagini//lista_etichetta.bmp'> </div> <br>";
				}
				div_lista.innerHTML = stringa;
				document.body.appendChild(div_lista);
			}
				
			} 
			
		} 
			
		}
		
	function listaCarrello()
		{
		flag=false;
		if (window.XMLHttpRequest) 
		{   
			var xhr = new XMLHttpRequest();   
			xhr.onreadystatechange = gestoreRichiesta;  
			xhr.open("GET", "File%20PHP/Gestione%20Carrello/lista_carrello.php?email="+a[2], false);   
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
				paragrafo.innerHTML = "Nessun men&ugrave; aggiunto al carrello! <br> Vai nella lista men&ugrave;, componi a tua scelta il men&ugrave; e aggiungilo!";
				document.body.appendChild(paragrafo);
				flag = false;
				
				
			}
			else
			{
				div_lista = document.createElement("div");
				div_lista.setAttribute("id", "div_lista");
				stringa="";
				for(i=0; i<menu.length-1; i++)
				{
					menu_car = menu[i].split("  ");
					stringa +="<input type='hidden' id='menu["+i+"]' name='menu_scelto' value='"+menu[i]+"'> <input class='button_quick' type='button' id='dettagli "+i+"' value='Dettagli' onclick='apriDettagliMenu(this.id)'> <input class='button_quick' type='button' id='"+i+"' value='Rimuovi dal carrello' onclick='rimuoviMenu(this.id)'>";
					stringa +="<div class='div_menu'> <input type='hidden' class='codici_menu' value='"+menu_car[3]+"'> <img class='icona' src='Immagini//content.jpg' height='100' width='100'> NOME: <span>"+menu_car[0]+ "</span> PREZZO: <span>"+menu_car[1]+ "</span> QUANTITA': <span>"+menu_car[2]+ "</span> <img class='etichetta' src='Immagini//lista_etichetta.bmp'> </div> <br>";
				}
				div_lista.innerHTML = stringa;
				document.body.appendChild(div_lista);
				flag = true;
			}
				
			} 
			
		} 
			return flag;
		}
		
		function aggiungiCarrello()
		{	
				function getRadioCheckedValue(radio_name)
			{
				var oRadio = document.getElementById("componenti_form").elements[radio_name];
 
				for(var i = 0; i < oRadio.length; i++)
				{
					if(oRadio[i].checked)
					{
						return oRadio[i].value;
					}
				}
 
				return '';
			}	
			
			quantita = document.getElementById('quant').value;
			var componenti_aggiuntive = new Array(); 
			j=0;
		
			if(document.getElementById("no_aggiuntivo").checked == false)
			{
				var inputElements = document.getElementsByClassName('aggiuntivo');
			for(var i=0; inputElements[i]; ++i)
			{
				if(inputElements[i].checked)
				{
					componenti_aggiuntive[j] = inputElements[i].value;
					j++;
				}
			}
			}
			
		
				panino = getRadioCheckedValue('panino');
				bibita = getRadioCheckedValue('bibita');
				contorno = getRadioCheckedValue('contorno');
		
				if (window.XMLHttpRequest) 
				{   
	
					str = "?nome_menu="+menu_car[0]+"&email="+a[2]+"&prezzo="+menu_car[1]+"&quant="+quantita+"&panino="+panino+"&contorno="+contorno+"&bibita="+bibita+"&aggiuntivo[]="+componenti_aggiuntive;
					var xhr = new XMLHttpRequest();   
					xhr.onreadystatechange = gest;  
					xhr.open("GET", "File%20PHP/Gestione%20Carrello/aggiungi_carrello.php"+str, true);   
					xhr.send("");
				} 
			
		
			function gest() 
			{   
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					str = xhr.responseText;
					if(str == null || str=="")
					{
						alert("Menu "+menu_car[0]+" aggiunto al carrello!"); 
						location.href = "Lista_Menu_Account.html";
					}
					else
					{
						alert(""+str); 
					}
				} 
			} 
		}
		
		function checkOut()
		{
			location.href = "Check-out.html";
		}
		
		function rimuoviMenu(id_bottone)
		{
			menu_scelto = document.getElementById("menu["+id_bottone+"]").value;
			menu_car = menu_scelto.split("  ");
		
				if (window.XMLHttpRequest) 
				{   
					str = "?nome_menu="+menu_car[3];
					var xhr = new XMLHttpRequest();   
					xhr.onreadystatechange = gest;  
					xhr.open("GET", "File%20PHP/Gestione%20Carrello/rimuovi_menu.php"+str, true);   
					xhr.send("");
				} 
			
		
			function gest() 
			{   
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					
					str = xhr.responseText;
					if(str == null || str=="" || str=='1' || str==' ')
					{
						alert("Menu "+menu_car[0]+" rimosso dal carrello!"); 
						location.reload();
					}
					else
					{
						alert(""+str); 
					}
				} 
			} 
		}
		
		
		function getInfoCarrello()
		{
			
		
			if (window.XMLHttpRequest) 
				{   
					str = "?email="+a[2];
					var xhr = new XMLHttpRequest();   
					xhr.onreadystatechange = gest;  
					xhr.open("GET", "File%20PHP/Gestione%20Carrello/carrello_info.php"+str, false);   
					xhr.send("");
			
				} 
			
		
			function gest() 
			{   
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					
						str = xhr.responseText;	
						info_carrello = str.split("  ");
						stringa="";
						div_lista = document.createElement("div");
						stringa += "<p id='totale'> PREZZO TOTALE: <span>"+info_carrello[0] + "</span> <br> QUANTITA' TOTALE: <span>"+info_carrello[1]+"</span></p>";
						div_lista.innerHTML = stringa;
						document.body.appendChild(div_lista);
				} 
			} 
		}
		
		function apriDettagliMenu(id_bottone)
		{
			newWindow = null;
			
			if (newWindow && !newWindow.closed)
			{
				newWindow.focus();
			}
			else
			{
				car = "width=1500,height=400,left=0,top=0";   
				newWindow = window.open("Ordine_Dettagli.html", "Menu - Dettagli", car);
			}
			
			id = id_bottone.split(" ");
			menu = document.getElementById("menu["+id[1]+"]").value;
			menu_car = menu.split("  ");
		
				if (window.XMLHttpRequest) 
				{   
					str = "?id_menu="+menu_car[3];
					var xhr = new XMLHttpRequest();   
					xhr.onreadystatechange = gest;  
					xhr.open("GET",  "File%20PHP/Gestione%20Carrello/dettagli_menu.php"+str, true);   
					xhr.send("");
				} 
			
		
			function gest() 
			{   
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					newWindow.document.write("<p> DETTAGLI MENU : Codice &nbsp;"+menu_car[3]+"</p>");
					str = xhr.responseText;
					lista_comp = str.split("-");
					
					newWindow.document.write("<div class='div_menu'>");
						newWindow.document.write("<p> MENU</p>");
						newWindow.document.write("<P> Nome: <span>"+menu_car[0]+ "</span> Prezzo: <span>"+menu_car[1]+ "</span> Quantit&agrave;: <span>"+menu_car[2]+ "</span> </p>");
						newWindow.document.write("<p> COMPONENTI </p>");
					
					for(k=0; k<lista_comp.length-1; k++)
					{
						
						
							comp_car = lista_comp[k].split("/");
							if(comp_car[1].indexOf("PANINO") > -1)
							{
								newWindow.document.write("Tipo: <span>"+comp_car[1]+"</span> Nome: <span>"+comp_car[0]+ " </span>Descrizione: <span>"+comp_car[2]+"</span><br>");
								
							}
				
							if(comp_car[1].indexOf("AGGIUNTIVO") > -1)
							{
								newWindow.document.write("Tipo: <span>"+comp_car[1]+"</span> Nome: <span>"+comp_car[0]+ "</span> Prezzo: <span>"+comp_car[3]+"</span><br>");
								
							}
				
				
						if(comp_car[1].indexOf("BIBITA") > -1)
						{
							newWindow.document.write("Tipo: <span>"+comp_car[1]+"</span> Nome: <span>"+comp_car[0]+ "</span><br>");
					
						}
				
						if(comp_car[1].indexOf("CONTORNO") > -1)
						{
							newWindow.document.write("Tipo: <span>"+comp_car[1]+"</span>  Nome: <span>"+comp_car[0]+ "</span> <br>");
						}
					}
					
					newWindow.document.write("</div>");
					newWindow.document.body.style.backgroundColor = "lightgrey";
					elements = newWindow.document.getElementsByClassName("div_menu");
					tags= newWindow.document.getElementsByTagName("span");
					
					for(el=0; el<elements.length; el++)
					{
						elements[el].style.backgroundColor = "#FACC2E";
						
						
					}
					
					for(el=0; el<tags.length; el++)
					{
						tags[el].style.color = "grey";
						
						
					}
				
				} 
			} 
		}
		
		function svuotaCarrello()
		{
			elementi = document.getElementsByClassName("codici_menu");
			var codici = new Array();
		
			for(i=0; i<elementi.length; i++)
			{
				codici[i] = elementi[i].value; 
			}
			
			if (window.XMLHttpRequest) 
				{   
					str = "?codici[]="+codici;
					var xhr = new XMLHttpRequest();   
					xhr.onreadystatechange = gest;  
					xhr.open("GET", "File%20PHP/Gestione%20Carrello/svuota_carrello.php"+str, true);   
					xhr.send("");
				} 
			
		
			function gest() 
			{   
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					
					str = xhr.responseText;
					if(str == null || str=="")
					{
						alert("Carrello svuotato!"); 
						location.reload();
					}
					else
					{
						alert(""+str); 
					}
				} 
			} 
			
		}
		