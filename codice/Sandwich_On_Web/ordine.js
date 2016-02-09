	
		function mostraText()
		{
			if(document.getElementById('indirizzo').checked == true)
				document.getElementById('nuovo_indirizzo').style.display = "none";
			
			if(document.getElementById('altro_indirizzo').checked == true)
				document.getElementById('nuovo_indirizzo').style.display = "initial";
			
		}
		
		function listaOrdini()
		{
		
		if (window.XMLHttpRequest) 
		{   
			var xhr = new XMLHttpRequest();   
			xhr.onreadystatechange = gestoreRichiesta;  
			xhr.open("GET", "File%20PHP/Gestione%20Ordine/lista_ordini.php?email="+a[2], true);   
			xhr.send("");
		} 
		
		function gestoreRichiesta() 
		{   
			
			if (xhr.readyState == 4 && xhr.status==200) 
			{
				str = xhr.responseText;	
				ordini = str.split("-");
			
			if(ordini == undefined || ordini == "" || ordini == null)
			{
				paragrafo = document.createElement("p");
				paragrafo.setAttribute("id", "vuoto");
				paragrafo.innerHTML = "Nessuna ordine effettuato! <br> Vai nella sezione carrello e procedi per il check-out! ";
				document.body.appendChild(paragrafo);
			}
			else
			{
				
				div_lista = document.createElement("div");
				div_lista.setAttribute("id", "div_lista");
				stringa ="";
				for(i=0; i<ordini.length-1; i++)
				{
					odine_car = ordini[i].split("  ");
					stringa +="<input type='hidden' id='ordine["+i+"]' name='ordine' value='"+ordini[i]+"'> <input class='bottoni' type='button' id='dettagli "+i+"' value='Dettagli' onclick='apriDettagli(this.id)'> <input class='bottoni' type='button' id='"+i+"' value='Cancella' onclick='cancellaOrdine(this.id)'>";
					stringa +="<div class='div_menu'>"
					+"<img class='icona' src='Immagini//ordine.png' height='100' width='100'> Codice: <span>"+odine_car[0]+ "</span> Utente: <span>"+odine_car[1]+ "</span> Tempo Attesa: <span>"+odine_car[2]+ "</span> Stato: <span>"+odine_car[3]+ "</span> Indirizzo Consegna: <span>"+odine_car[4]+ "</span> Orario Utente: <span>"+odine_car[5]+ "</span> Totale Quantit&agrave;: <span>"+odine_car[6]+ "</span> Totale Prezzo: <span>"+odine_car[7]+ "</span>"
					+"</div> <br>";
						
				}
				div_lista.innerHTML = stringa;
				document.body.appendChild(div_lista);
			}
			} 
			
		} 
			
		}
		
		function creaOrdine()
		{
			email = document.getElementById("text_email").value;
			nome = document.getElementById("text_nome").value;
			if(document.getElementById("indirizzo").checked == true)
				indirizzo = document.getElementById("text_indirizzo").value;
			if(document.getElementById("altro_indirizzo").checked == true)
				indirizzo = document.getElementById("nuovo_indirizzo").value;
			ora = document.getElementById("orario_ora").value;
			minuti = document.getElementById("orario_minuti").value;
			
			if(!Number.isInteger(parseInt(ora)) || !Number.isInteger(parseInt(minuti)))
			{
				alert("Orario invalido");
				exit();
			}
			
			if(parseInt(ora) < 18 || parseInt(ora) > 23)
			{
				alert("Orario invalido! Le consegne si effetuttano dalle 18:00 alle 23:59");
				exit();
			}
			
			if(parseInt(minuti) < 0 || parseInt(minuti) > 59)
			{
				alert("Orario invalido! Le consegne si effetuttano dalle 18:00 alle 23:59");
				exit();
			}
			
			
			
			orario = ora + ":" + minuti;
			
			str = document.getElementById("data").value;
			menu = str.split("-");
			var nome_menu = new Array();
			k=0;
			
			for(i=0; i<menu.length-1; i++)
			{
				temp = menu[i];
				menu_car = temp.split("  ");
				nome_menu[k] = menu_car[3];
				k++;
			}
			
			
			
			if (window.XMLHttpRequest) 
			{   
				str = "?email="+email+"&nome="+nome+"&indirizzo="+indirizzo+"&orario="+orario+"&menu_scelti[]="+nome_menu;
				var xhr = new XMLHttpRequest();   
				xhr.onreadystatechange = gestoreRichiesta;  
				xhr.open("GET", "File%20PHP/Gestione%20Ordine/crea_ordine.php"+str, true);   
				xhr.send("");
			} 
		
			function gestoreRichiesta() 
			{   
			
				if (xhr.readyState == 4 && xhr.status==200) 
				{
					str = xhr.responseText;	
					if(str == null || str == "")
					{
						alert("Ordine confermato");
						location.href = "Ordini.html";
					}
					else 
						alert(""+str);
				} 
			
			} 
		}
		
		function cancellaOrdine(id_bottone)
		{
			ordine = document.getElementById("ordine["+id_bottone+"]").value;
			ordine_car = ordine.split("  ");
		
				if (window.XMLHttpRequest) 
				{   
					str = "?ordine="+ordine_car[0]+"&stato="+ordine_car[3];
					var xhr = new XMLHttpRequest();   
					xhr.onreadystatechange = gest;  
					xhr.open("GET",  "File%20PHP/Gestione%20Ordine/rimuovi_ordine.php"+str, true);   
					xhr.send("");
				} 
			
		
			function gest() 
			{   
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					
					str = xhr.responseText;
					if(str == null || str=="" || str=='1')
					{
						alert("Ordine "+ordine_car[0]+" rimosso!"); 
						location.reload();
					}
					else
					{
						alert(""+str); 
					}
				} 
			} 
		}
		
		
		
		function apriDettagli(id_bottone)
		{
			newWindow = null;
			
			if (newWindow && !newWindow.closed)
			{
				newWindow.focus();
			}
			else
			{
				car = "width=1000,height=1000,left=0,top=0";   
				newWindow = window.open("Ordine_Dettagli.html", "Ordine - Dettagli", car);
			}
			
			id = id_bottone.split(" ");
			ordine = document.getElementById("ordine["+id[1]+"]").value;
			ordine_car = ordine.split("  ");
		
				if (window.XMLHttpRequest) 
				{   
					str = "?ordine="+ordine_car[0];
					var xhr = new XMLHttpRequest();   
					xhr.onreadystatechange = gest;  
					xhr.open("GET", "File%20PHP/Gestione%20Ordine/dettagli_ordine.php"+str, true);   
					xhr.send("");
				} 
			
		
			function gest() 
			{   
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					newWindow.document.write("<p> DETTAGLI ORDINE : Codice &nbsp;"+ordine_car[0]+"&nbsp; &nbsp; Totale Quantit&agrave;: &nbsp; "+ordine_car[6]+" &nbsp; &nbsp; Totale Prezzo: &nbsp; "+ordine_car[7]+"</p>");
					str = xhr.responseText;
					lista_menu = str.split("-");
					newWindow.document.write("<div id='div_lista'>");
					for(k=0; k<lista_menu.length-1; k++)
					{
						menu_dettagli = lista_menu[k].split("<br>");
						
						menu_car = menu_dettagli[0].split("  ");
						
						newWindow.document.write("<div class='div_menu'>");
						newWindow.document.write("<p> MENU</p>");
						newWindow.document.write("<P> Nome: <span>"+menu_car[0]+ "</span> Prezzo: <span>"+menu_car[1]+ "</span> Quantit&agrave;: <span>"+menu_car[2]+ "</span> <br>");
						newWindow.document.write("<p> COMPONENTI </p>");
						for(j=1; j<menu_dettagli.length-1; j++)
						{
							comp_car = menu_dettagli[j].split("/");
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
							newWindow.document.write("Tipo: <span>"+comp_car[1]+"</span> <span> Nome: "+comp_car[0]+ "</span><br>");
						}
				
						}
						newWindow.document.write("</p></div>");
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
		
		
		