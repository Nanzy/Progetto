Informazioni:
Nome Database: "sandwich_on_web".
Pagina Principale: "Home_Page.html".
Software per il db: "MySql Workbench version 6.3.5"

Set-up:
Prima di iniziare bisogna:
1) Cambiare le credenziale del database nel file "connection.php" (Path: "File PHP/connection.php").
2) Eseguire lo script "Script_SOW_v2.sql" per creare il database "sandwich_on_web" (Path: "Script Database/Script_SOW_v2.sql").
3) Eseguire lo script "Popalemento - Test.sql" per popolare il databse "sandwich_on_web" (Path: "Script Database/Popolamento - Test.sql").
4) Spostare la cartella "Sandwich_On_Web" nel localhost.

Nota: Una volta che un metodo di una classe test viene eseguito i passi sopra elencati vengono eseguiti "automaticamente".
Importante: Dopo aver effettuato i test per precauzione si consiglia di rieseguire gli script con MySql Workbench.

Testing:
Per effettuare il test delle classi, sia singolarmente che in maniera generale, bisogna:
1) Rieseguire lo script "Script_SOW_v2.sql" per creare il database "sandwich_on_web" (Path: "Script Database/Script_SOW_v2.sql").
2) Eseguire lo script "Popalemento - Test.sql" per popolare il databse "sandwich_on_web" (Path: "Script Database/Popolamento - Test.sql").

Testing Selenium:
Prima di eseguire i test in maniera sequenziale bisogna rieseguire gli script "Script_SOW_v2.sql" e "Popalemento - Test.sql".
La suite dei test è "Test suite completa". 
N.B. : non spostare i file dalle cartelle.
