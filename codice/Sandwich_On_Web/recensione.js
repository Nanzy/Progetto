		function listaRecensioni()
		{
		
		if (window.XMLHttpRequest) 
		{   
			var xhr = new XMLHttpRequest();   
			xhr.onreadystatechange = gestoreRichiesta;  
			xhr.open("GET", "File%20PHP/Gestione%20Recensione/lista_recensioni.php", true);   
			xhr.send("");
		} 
		
		function gestoreRichiesta() 
		{   
			
			if (xhr.readyState == 4 && xhr.status==200) 
			{
				str = xhr.responseText;	
				recensioni = str.split("-");
			
			if(recensioni == undefined || recensioni == "" || recensioni== null)
			{
				paragrafo = document.createElement("p");
				paragrafo.setAttribute("id", "vuoto");
				paragrafo.innerHTML = "Nessuna recensione presente! Per inserire una recensione devi essere registrato!";
				document.body.appendChild(paragrafo);
			}
			else
			{
				div_lista= document.createElement("div");
				div_lista.setAttribute("id", "div_lista_rec");
				valore = recensioni.length - 1;
				stringa ="";
				for(j=0; j<valore; j++)
				{
					recensioni_car = recensioni[j].split("/");
					
					stringa +="<div class='div_recensione'> <div class='intestazione_rec'> Scritta da: "+recensioni_car[2]+" </div> <br> <p class='titolo'> "+recensioni_car[0]+"  </p> <p> "+recensioni_car[1]+"</p> <br> <div class='dx'>Valutazione: ";
					for(i=0; i<recensioni_car[3]; i++)
					{
						stringa +="<img src='Immagini/stella_piena.png' height='50' width='50'>";
					}
					for(i=0; i<(5-recensioni_car[3]); i++)
					{
						stringa +="<img src='Immagini/stella_vuota.png' height='50' width='50'>";
					}
					
					stringa +="</div></div>";
					
					
				}
			div_lista.innerHTML = stringa;
			document.body.appendChild(div_lista);
			}
			} 
			
		} 
			
		}
		
		function inserisciRecensione()
		{
			location.href = "Insert_Recensione.html"
		}
		
		function stellaPiena(id_stella)
		{
			if(flag == false)
			{
				for(i=2; i<=id_stella; i++)
					document.getElementById(i).src = "Immagini/stella_piena.png";
			}
		}
		
		function stellaVuota(id_stella)
		{
			if(flag == false)
			{
				for(i=2; i<=id_stella; i++)
					document.getElementById(i).src = "Immagini/stella_vuota.png";
			}
		}
		
		function confermaStella(id_stella)
		{
			votazione = id_stella;
			flag = true;
		}
		
		function resetStelle()
		{
			votazione = 1;
			for(i=2; i<=5; i++)
					document.getElementById(i).src = "Immagini/stella_vuota.png";
			flag = false;
		}
	
		function submitRecensione()
		{
			titolo = document.getElementById("text_titolo").value;
			testo = document.getElementById("text_testo").value;
			nickname = document.getElementById("text_nickname").value;
			
			if(titolo == null || testo == null || nickname == null || titolo == "" || testo == "" || nickname == "")
			{
				alert("Inserisci tutti i campi richiesti!");
				exit();
			}
			
				
			if (window.XMLHttpRequest) 
			{   
				str = "?email="+a[2]+"&titolo="+titolo+"&nickname="+nickname+"&testo="+testo+"&valutazione="+votazione;
				var xhr = new XMLHttpRequest();   
				xhr.onreadystatechange = gestoreRichiesta;  
				xhr.open("GET", "File%20PHP/Gestione%20Recensione/inserisci_recensione.php"+str, true);   
				xhr.send("");
			} 
		
			function gestoreRichiesta() 
			{
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					str = xhr.responseText;
					if(str == null || str=="")
					{
						alert("Recensione inserita!"); 
						location.href = "Recensioni_Account.html";
					}
					else
					{
						alert(""+str); 
					}
				} 
				
			} 
		}