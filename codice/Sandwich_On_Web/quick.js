function listaQuick()
		{
		
		if (window.XMLHttpRequest) 
		{   
			var xhr = new XMLHttpRequest();   
			xhr.onreadystatechange = gestoreRichiesta;  
			xhr.open("GET", "File%20PHP/Gestione%20QuickMenu/lista_quickmenu.php?email="+a[2], true);   
			xhr.send("");
		} 
		
		function gestoreRichiesta() 
		{   
			
			if (xhr.readyState == 4 && xhr.status==200) 
			{
				str = xhr.responseText;	
				menu = str.split("-");
			
		
			if(menu == undefined || menu == "" || menu== null)
			{
				paragrafo = document.createElement("p");
				paragrafo.setAttribute("id", "vuoto");
				paragrafo.innerHTML = "Nessun QuickMen&ugrave; presente! Vai alla lista dei men&ugrave;  e seleziona quelli che pi&ugrave;  preferisci!";
				document.body.appendChild(paragrafo);
			}
			else
			{
			
				div_lista= document.createElement("div");
				div_lista.setAttribute("id", "div_lista_rec");
				stringa = "";
				for(i=0; i<menu.length-1; i++)
				{
					
					menu_car = menu[i].split("  ");
					stringa +="<input class='button_quick' type='button' id='"+i+"' value='Rimuovi da QuickMen&ugrave;' onclick='rimuoviQuick(this.id)'>";
					stringa +="<form method='GET' action='File%20PHP/Gestione%20Menu/FormComponenti.php'> <div class='div_menu' onclick='this.parentNode.submit()'> "
					+"<img class='icona' src='Immagini//content.jpg' height='100' width='100'> <input type='hidden' id='menu["+i+"]' name='menu_scelto' value='"+menu[i]+"'> NOME: <span>"+menu_car[0]+ "</span> PREZZO: <span>"+menu_car[1]+ "</span> DISPONIBILITA': <span>"+menu_car[2]+ "</span> "
					+"  <img class='etichetta' src='Immagini//lista_etichetta.bmp'> </div> </form> <br>";
						
				}
				
				div_lista.innerHTML = stringa;
				document.body.appendChild(div_lista);
			}
			} 
			
		} 
			
		}
		
		function rimuoviQuick(id_bottone)
		{
				
			menu_scelto = document.getElementById("menu["+id_bottone+"]").value;
			menu_car = menu_scelto.split("  ");
		
				if (window.XMLHttpRequest) 
				{   
					str = "?nome_menu="+menu_car[0]+"&email="+a[2];
					var xhr = new XMLHttpRequest();   
					xhr.onreadystatechange = gest;  
					xhr.open("GET",  "File%20PHP/Gestione%20QuickMenu/rimuovi_quick.php"+str, true);   
					xhr.send("");
				} 
			
		
			function gest() 
			{   
				if (xhr.readyState == 4 && xhr.status==200) 
				{ 
					
					str = xhr.responseText;
					if(str == null || str=="" || str=='1')
					{
						alert("Menu "+menu_car[0]+" rimosso da quickmenu!"); 
						location.reload();
					}
					else
					{
						alert(""+str); 
					}
				} 
			} 
		}