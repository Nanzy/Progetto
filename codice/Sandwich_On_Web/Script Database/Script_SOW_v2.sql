DROP database IF EXISTS sandwich_on_web;
CREATE database sandwich_on_web CHARACTER SET utf8 COLLATE utf8_general_ci;
USE sandwich_on_web;

		/* TABLE*/

CREATE TABLE Account(
		ID_ACCOUNT		int(10)				NOT NULL	AUTO_INCREMENT,
		NOME			varchar(20)			NOT NULL,
        COGNOME			varchar(20)			NOT NULL,
        EMAIL			varchar(25)			NOT NULL,
        PASS			varchar(15)			NOT NULL,
        CITTÁ			varchar(25),
		INDIRIZZO		varchar(30),
        CAP				int(5),				
        N_TELEFONO		varchar(10)			NOT NULL,			
        TIPO			varchar(30)			NOT NULL,
		unique(email),
        PRIMARY KEY(ID_ACCOUNT)
);



CREATE TABLE Ordine(
        ID_ORDINE 		    	int(10)		    NOT NULL AUTO_INCREMENT,
        NOME_UTENTE   			varchar(20)	    NOT NULL,
        TEMPO_ATTESA    		varchar(5)      ,
        STATO           		varchar(20)     NOT NULL,	
        INDIRIZZO_CONSEGNA  	varchar(30)     NOT NULL,
        ORARIO_CONSEGNA			varchar(5)      NOT NULL,
		TOTALE_QUANTITÀ 		int(7)          NOT NULL default 0,
        TOTALE_PREZZO   		float(7)        NOT NULL default 0,		
		ID_ACCOUNT_UTENTE 		int(10)		    NOT NULL,
        ID_ACCOUNT_FATTORINO	int(10)			,
		PRIMARY KEY(ID_ORDINE, ID_ACCOUNT_UTENTE),
        FOREIGN KEY(ID_ACCOUNT_UTENTE) references Account(ID_ACCOUNT) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY(ID_ACCOUNT_FATTORINO) references Account(ID_ACCOUNT) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Menù(
        ID_MENÙ				int(10)		    NOT NULL AUTO_INCREMENT,
		NOME				varchar(20)     NOT NULL,
        PREZZO   			float      		NOT NULL,
        DISPONIBILITA	  	int(7)          NOT NULL,
		unique(nome),
		PRIMARY KEY(ID_MENÙ)
);

CREATE TABLE Recensione(
		ID_RECENSIONE	int(10)				NOT NULL AUTO_INCREMENT,
		TITOLO			varchar(30)			NOT NULL,
        TESTO			varchar(300)		NOT NULL,
        NICKNAME		varchar(15)			NOT NULL,
        APPREZZAMENTO	float				NOT NULL,
        ID_ACCOUNT		int(10)				NOT NULL,
		unique(NICKNAME),
        PRIMARY KEY(ID_RECENSIONE, ID_ACCOUNT),
        FOREIGN KEY(ID_ACCOUNT) references Account(ID_ACCOUNT) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE Aggiunge_A_Quick(
		ID_ACCOUNT			int(10)				NOT NULL,
		ID_MENÙ				int(10)				NOT NULL,
        PRIMARY KEY(ID_ACCOUNT,ID_MENÙ),
		FOREIGN KEY(ID_ACCOUNT) references Account(ID_ACCOUNT) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY(ID_MENÙ) references Menù(ID_MENÙ) ON DELETE CASCADE ON UPDATE CASCADE
);



CREATE TABLE Carrello(
        ID_CARRELLO 		int(10)		    NOT NULL AUTO_INCREMENT,
        ID_ACCOUNT   		int(10)		    NOT NULL,
        TOTALE_QUANTITÀ 	int(7)          NOT NULL default 0,
        TOTALE_PREZZO   	float(7)        NOT NULL default 0,		
		PRIMARY KEY(ID_CARRELLO, ID_ACCOUNT),
        FOREIGN KEY(ID_ACCOUNT) references Account(ID_ACCOUNT) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Menù_scelto(
		ID_MENÙ_SCELTO	int(10)			NOT NULL	AUTO_INCREMENT,
        NOME			varchar(20)		NOT NULL,
        PREZZO			float(7) 		NOT NULL,
        QUANTITÀ 		int(2)			NOT NULL,
        PRIMARY KEY(ID_MENÙ_SCELTO)
);

CREATE TABLE Componente(
        ID_COMPONENTE 		int(10)		NOT NULL	AUTO_INCREMENT,
		NOME				varchar(30)	NOT NULL,
		TIPO				varchar(15) NOT NULL,
		DESCRIZIONE			varchar(250),
        PREZZO   			float(7),
		unique(nome),
		PRIMARY KEY (ID_COMPONENTE)
);

CREATE TABLE Composto_da(
		ID_MENÙ_SCELTO  int(10)		    NOT NULL,
        ID_COMPONENTE 	int(10)		    NOT NULL,
		PRIMARY KEY (ID_MENÙ_SCELTO, ID_COMPONENTE),
		FOREIGN KEY(ID_COMPONENTE ) references Componente(ID_COMPONENTE) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY(ID_MENÙ_SCELTO) references Menù_scelto(ID_MENÙ_SCELTO) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Costituito_da(
		ID_MENÙ  int(10)		    NOT NULL,
        ID_COMPONENTE 	int(10)		NOT NULL,
		PRIMARY KEY (ID_MENÙ, ID_COMPONENTE),
		FOREIGN KEY(ID_COMPONENTE ) references Componente(ID_COMPONENTE) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY(ID_MENÙ) references Menù(ID_MENÙ) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Possiede (
		ID_ORDINE int(10)		    NOT NULL,
        ID_MENù_SCELTO	int(10)		NOT NULL,
		PRIMARY KEY (ID_ORDINE, ID_MENù_SCELTO),
		FOREIGN KEY(ID_MENù_SCELTO ) references Menù_scelto(ID_MENù_SCELTO) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY(ID_ORDINE) references Ordine(ID_ORDINE) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Contiene(
		ID_CARRELLO 	int(10)		    NOT NULL,
		ID_MENÙ_SCELTO  int(10)		    NOT NULL,
		PRIMARY KEY (ID_CARRELLO, ID_MENÙ_SCELTO),
		FOREIGN KEY(ID_CARRELLO ) references Carrello(ID_CARRELLO) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY(ID_MENÙ_SCELTO) references Menù_scelto(ID_MENÙ_SCELTO) ON DELETE CASCADE ON UPDATE CASCADE
);


			/*TRIGGER */

/*--------------------------------------------------------------/* ACCOUNT */--------------------------------------------------------------------*/
/*TRIGGER INSERT*/
DELIMITER $$  
CREATE TRIGGER Check_Account BEFORE INSERT ON Account FOR EACH ROW  
BEGIN  
    DECLARE errore_email, errore_citta, errore_password, errore_tipo, errore_valori int;
	DECLARE errore_nome, errore_cognome, errore_cap, errore_indirizzo, errore_email_lun, errore_num int;
	
	
	IF (NEW.Tipo not like "Utente") AND (NEW.Tipo not like "Fattorino") AND (NEW.Tipo not like "GESTORE DEGLI ORDINI") AND (NEW.Tipo not like "GESTORE DEI MENÙ")  THEN
        SET errore_tipo = 1;  
    END IF;  
	
	IF( NEW.Tipo like "Utente") THEN
	
		IF (NEW.indirizzo is null) OR (NEW.CAP is null ) OR (NEW.CITTÁ is null)  THEN
			SET errore_valori = 1;  
		END IF;  
		
		IF (length(NEW.nome) < 2)  THEN
			SET errore_nome = 1;  
		END IF;
		
		IF (length(NEW.cognome) < 2)  THEN
			SET errore_cognome = 1;  
		END IF;
		
		
		IF (length(NEW.cap) != 5)  THEN
			SET errore_cap = 1;  
		END IF;
		
		IF (length(NEW.email) < 15)  THEN
			SET errore_email_lun = 1;  
		END IF;
		
		IF (length(NEW.indirizzo) < 7)  THEN
			SET errore_indirizzo = 1;  
		END IF;
		
		IF (length(NEW.N_TELEFONO) != 10)  THEN
			SET errore_num = 1;  
		END IF;
		
		
		IF (NEW.EMAIL not like "%@%.%")  THEN
			SET errore_email = 1;  
		END IF;  
		
		
	
		IF (NEW.CITTÁ not like "Salerno") && (NEW.CITTÁ not like "Fisciano") && (NEW.CITTÁ not like "Lancusi") 
		&& (NEW.CITTÁ not like "Baronissi") THEN
			SET errore_citta = 1;  
		END IF;
		
		IF (length(NEW.Pass) < 6)  THEN
			SET errore_password = 1;  
		END IF; 
	END IF;
	
	
	
	IF (NEW.Tipo like "Fattorino") || (NEW.Tipo like "GESTORE DEGLI ORDINI") || (NEW.Tipo like "GESTORE DEI MENÙ")  THEN
	
		IF (NEW.indirizzo is not null) OR (NEW.CAP is not null ) OR (NEW.CITTÁ is not null)  THEN
			SET errore_valori = 1;  
		END IF; 
		
		IF (length(NEW.Pass) < 6)  THEN
			SET errore_password = 1;  
		END IF; 
		
		IF (length(NEW.nome) < 2)  THEN
			SET errore_nome = 1;  
		END IF;
		
		IF (length(NEW.cognome) < 2)  THEN
			SET errore_cognome = 1;  
		END IF;
		
		IF (length(NEW.email) < 15)  THEN
			SET errore_email_lun = 1;  
		END IF;
		
		
		IF (length(NEW.N_TELEFONO) != 10)  THEN
			SET errore_num = 1;  
		END IF;
	END IF; 
		

	IF errore_valori = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Valore non consentito in un campo')  
        INTO errore_valori FROM information_schema.tables;
    END IF;
	
	  IF errore_tipo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Tipo non valido')  
        INTO errore_tipo FROM information_schema.tables;
    END IF;  
	
    IF errore_email = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Email non valida')  
        INTO errore_email FROM information_schema.tables;
    END IF;  
	
	
	IF errore_citta = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Città non valida')  
        INTO errore_citta FROM information_schema.tables;
    END IF; 
	
	IF errore_password = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Password non valida [deve avere almeno 6 caratteri]')  
        INTO errore_password FROM information_schema.tables;
    END IF; 
	
	
	IF errore_nome = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Nome non valido [deve avere almeno 2 caratteri]')  
        INTO errore_nome FROM information_schema.tables;
    END IF; 
	
	IF errore_cognome = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Cognome non valido [deve avere almeno 2 caratteri]')  
        INTO errore_cognome FROM information_schema.tables;
    END IF; 
	
	IF errore_email_lun = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Email non valida [deve avere almeno 15 caratteri]')  
        INTO errore_email_lun FROM information_schema.tables;
    END IF; 
	
	IF errore_indirizzo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Indirizzo non valido [deve avere almeno 7 caratteri]')  
        INTO errore_indirizzo FROM information_schema.tables;
    END IF; 
	
	IF errore_cap = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Cap non valido [deve avere 5 caratteri numerici]')  
        INTO errore_cap FROM information_schema.tables;
    END IF; 
	
	IF errore_num = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Telefono non valido [deve avere 10 caratteri numerici]')  
        INTO errore_num FROM information_schema.tables;
    END IF; 
	
	
END; $$
	
/*TRIGGER UPDATE*/
DELIMITER $$  
CREATE TRIGGER Check_Account_Update BEFORE UPDATE ON Account FOR EACH ROW  
BEGIN  
    DECLARE errore_email, errore_citta, errore_password, errore_tipo, errore_valori int;  
	DECLARE errore_nome, errore_cognome, errore_cap, errore_indirizzo, errore_email_lun, errore_num int;
	
	
	IF (NEW.Tipo not like "Utente") AND (NEW.Tipo not like "Fattorino") AND (NEW.Tipo not like "GESTORE DEGLI ORDINI") AND (NEW.Tipo not like "GESTORE DEI MENÙ")  THEN
        SET errore_tipo = 1;  
    END IF;  
	
	IF( NEW.Tipo like "Utente") THEN
	
		IF (NEW.indirizzo is null) OR (NEW.CAP is null ) OR (NEW.CITTÁ is null)  THEN
			SET errore_valori = 1;  
		END IF;  
		
		IF (NEW.EMAIL not like "%@%.%")  THEN
			SET errore_email = 1;  
		END IF;  
	
		IF (NEW.CITTÁ not like "Salerno") && (NEW.CITTÁ not like "Fisciano") && (NEW.CITTÁ not like "Lancusi") 
		&& (NEW.CITTÁ not like "Baronissi") THEN
			SET errore_citta = 1;  
		END IF;
		
		IF (length(NEW.Pass) < 6)  THEN
			SET errore_password = 1;  
		END IF; 
		
			IF (length(NEW.nome) < 2)  THEN
			SET errore_nome = 1;  
		END IF;
		
		IF (length(NEW.cognome) < 2)  THEN
			SET errore_cognome = 1;  
		END IF;
		
	
		IF (length(NEW.cap) != 5)  THEN
			SET errore_cap = 1;  
		END IF;
		
		IF (length(NEW.email) < 15)  THEN
			SET errore_email_lun = 1;  
		END IF;
		
		IF (length(NEW.indirizzo) < 7)  THEN
			SET errore_indirizzo = 1;  
		END IF;
		
		IF (length(NEW.N_TELEFONO) < 10)  THEN
			SET errore_num = 1;  
		END IF;
	END IF;
	
	
	
	IF (NEW.Tipo like "Fattorino") || (NEW.Tipo like "GESTORE DEGLI ORDINI") || (NEW.Tipo like "GESTORE DEI MENÙ")  THEN
	
		IF (NEW.indirizzo is not null) OR (NEW.CAP is not null ) OR (NEW.CITTÁ is not null)  THEN
			SET errore_valori = 1;  
		END IF; 
		
		IF (length(NEW.Pass) < 6)  THEN
			SET errore_password = 1;  
		END IF; 
		
			IF (length(NEW.nome) < 2)  THEN
			SET errore_nome = 1;  
		END IF;
		
		IF (length(NEW.cognome) < 2)  THEN
			SET errore_cognome = 1;  
		END IF;
		
		
		IF (length(NEW.email) < 15)  THEN
			SET errore_email_lun = 1;  
		END IF;
		
		IF (length(NEW.N_TELEFONO) != 10)  THEN
			SET errore_num = 1;  
		END IF;
	END IF; 
		

	IF errore_valori = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Valore non consentito in un campo')  
        INTO errore_valori FROM information_schema.tables;
    END IF;
	
	  IF errore_tipo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Tipo non valido')  
        INTO errore_tipo FROM information_schema.tables;
    END IF;  
	
    IF errore_email = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Email non valida')  
        INTO errore_email FROM information_schema.tables;
    END IF;  
	
	
	IF errore_citta = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Città non valida')  
        INTO errore_citta FROM information_schema.tables;
    END IF; 
	
	IF errore_password = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Password non valida [deve avere almeno 6 caratteri]')  
        INTO errore_password FROM information_schema.tables;
    END IF; 
	
	IF errore_nome = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Nome non valido [deve avere almeno 2 caratteri]')  
        INTO errore_nome FROM information_schema.tables;
    END IF; 
	
	IF errore_cognome = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Cognome non valido [deve avere almeno 2 caratteri]')  
        INTO errore_cognome FROM information_schema.tables;
    END IF; 
	
	IF errore_email_lun = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Email non valida [deve avere almeno 15 caratteri]')  
        INTO errore_email_lun FROM information_schema.tables;
    END IF; 
	
	IF errore_indirizzo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Indirizzo non valido [deve avere almeno 7 caratteri]')  
        INTO errore_indirizzo FROM information_schema.tables;
    END IF; 
	
	IF errore_cap = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Cap non valido [deve avere 5 caratteri numerici]')  
        INTO errore_cap FROM information_schema.tables;
    END IF; 
	
	IF errore_num = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Account! Telefono non valido [deve avere 10 caratteri numerici]')  
        INTO errore_num FROM information_schema.tables;
    END IF; 
	
END; $$

/*--------------------------------------------------------------/* ORDINE */--------------------------------------------------------------------*/
/*TRIGGER INSERT*/
DELIMITER $$  
CREATE TRIGGER Check_Ordine BEFORE INSERT ON Ordine FOR EACH ROW  
BEGIN  
    DECLARE errore_indirizzo, errore_stato, errore_tempo_attesa, errore_orario_consegna, errore_nome, errore_fattorino, errore_utente, errore_tempo_nullo, errore_negativo, errore_set int;  
	DECLARE controllo_nome, controllo_fattorino, controllo_utente varchar(20);
	
	SET controllo_nome = (select nome from Account a where new.id_account_utente = a.id_account);
	SET controllo_fattorino = (select tipo from Account a where new.id_account_fattorino = a.id_account);
	SET controllo_utente = (select tipo from Account a where new.id_account_utente = a.id_account);
	
	IF (NEW.nome_utente not like controllo_nome)
	THEN 
        SET errore_nome = 1;  
    END IF;  
	 
	IF (controllo_fattorino not like "Fattorino")
	THEN 
        SET errore_fattorino = 1;  
    END IF; 
	
	IF (controllo_utente not like "Utente")
	THEN 
        SET errore_utente = 1;  
    END IF;
	
    IF (NEW.STATO not like "attesa") 
	THEN 
        SET errore_stato = 1;  
    END IF;  
	
	IF (NEW.stato not like "attesa") && (new.tempo_attesa is not null)
	THEN 
        SET errore_tempo_nullo = 1;  
    END IF; 
	
    IF (NEW.TEMPO_ATTESA not like "__:__")
	THEN 
        SET errore_tempo_attesa = 1;  
    END IF;  
	
	 IF (NEW.ORARIO_CONSEGNA not like "__:__")
	THEN 
        SET errore_orario_consegna = 1;  
    END IF;  
	
	IF (NEW.ORARIO_CONSEGNA not like "__:__")
	THEN 
        SET errore_orario_consegna = 1;  
    END IF; 

	IF(new.TOTALE_QUANTITÀ not like 0 || new.TOTALE_PREZZO not like 0)
	THEN 
        SET errore_set = 1;  
    END IF;
	
	IF (NEW.TOTALE_QUANTITÀ < 0) || (NEW.TOTALE_PREZZO < 0)
	THEN 
        SET errore_negativo = 1;  
    END IF; 
	
	IF (length(NEW.INDIRIZZO_CONSEGNA) < 7)  
	THEN
			SET errore_indirizzo = 1;  
	END IF;
	
	IF errore_indirizzo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Indirizzo non valido [deve avere almeno 7 caratteri]')  
        INTO errore_indirizzo FROM information_schema.tables;
    END IF; 
	
	IF errore_nome = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Nome e ID non corrispondenti')  
        INTO errore_nome FROM information_schema.tables;
    END IF; 
	
	IF errore_fattorino = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Tipo Id_Fattorino non valido')  
        INTO errore_fattorino FROM information_schema.tables;
    END IF;
	
	IF errore_utente = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Tipo Id_Utente non valido')  
        INTO errore_utente FROM information_schema.tables;
    END IF;
	
    IF errore_stato = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Stato non valido')  
        INTO errore_stato FROM information_schema.tables;
    END IF;  	

	IF errore_orario_consegna = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Orario Consegna non valido [formato numerico hh:mm]')
        INTO errore_orario_consegna FROM information_schema.tables;
    END IF;  
	
	IF errore_tempo_attesa = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Tempo Atteso non valido')  
        INTO errore_tempo_attesa FROM information_schema.tables;
    END IF;  
	
	IF errore_tempo_nullo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Stato e Tempo Atteso non corrispondenti')  
        INTO errore_tempo_nullo FROM information_schema.tables;
    END IF;  
	
	 IF errore_negativo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Valori negativi')  
        INTO errore_negativo FROM information_schema.tables;
    END IF; 
	
		
	IF errore_set = 1 THEN  
    SELECT CONCAT('Inserimento non valido - Ordine! Inizializzazione non valida')  
        INTO errore_set FROM information_schema.tables;
    END IF;
	
END; $$

/*TRIGGER UPDATE*/
DELIMITER $$  
CREATE TRIGGER Check_Ordine_Update BEFORE UPDATE ON Ordine FOR EACH ROW  
BEGIN  
    DECLARE errore_indirizzo, errore_stato, errore_tempo_attesa, errore_orario_consegna, errore_nome, errore_fattorino, errore_utente, errore_tempo_nullo, errore_negativo int;  
	DECLARE controllo_nome, controllo_fattorino, controllo_utente varchar(20);
	
	SET controllo_nome = (select nome from Account a where new.id_account_utente = a.id_account);
	SET controllo_fattorino = (select tipo from Account a where new.id_account_fattorino = a.id_account);
	SET controllo_utente = (select tipo from Account a where new.id_account_utente = a.id_account);
	
	IF (NEW.nome_utente not like controllo_nome)
	THEN 
        SET errore_nome = 1;  
    END IF;  
	 
	IF (controllo_fattorino not like "Fattorino")
	THEN 
        SET errore_fattorino = 1;  
    END IF; 
	
	IF (controllo_utente not like "Utente")
	THEN 
        SET errore_utente = 1;  
    END IF;
	
	
    IF (NEW.STATO not like "attesa") && (NEW.STATO not like "preparazione") && (NEW.STATO not like "consegna") &&
	(NEW.STATO not like "ritardo") && (NEW.STATO not like "evaso")
	THEN 
        SET errore_stato = 1;  
    END IF;  
	
	IF (NEW.stato not like "attesa") && (new.tempo_attesa is null)
	THEN 
        SET errore_tempo_nullo = 1;  
    END IF; 
	
    IF (NEW.TEMPO_ATTESA not like "__:__")
	THEN 
        SET errore_tempo_attesa = 1;  
    END IF;  
	
	 IF (NEW.ORARIO_CONSEGNA not like "__:__")
	THEN 
        SET errore_orario_consegna = 1;  
    END IF;  
		
	
	IF (NEW.TOTALE_QUANTITÀ < 0) || (NEW.TOTALE_PREZZO < 0)
	THEN 
        SET errore_negativo = 1;  
    END IF; 
	
	IF (length(NEW.INDIRIZZO_CONSEGNA) < 7)  
	THEN
			SET errore_indirizzo = 1;  
	END IF;
	
	IF errore_indirizzo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Indirizzo non valido [deve avere almeno 7 caratteri]')  
        INTO errore_indirizzo FROM information_schema.tables;
    END IF; 
	
	IF errore_nome = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Nome e ID non corrispondenti')  
        INTO errore_nome FROM information_schema.tables;
    END IF; 
	
	IF errore_fattorino = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Tipo Id_Fattorino non valido')  
        INTO errore_fattorino FROM information_schema.tables;
    END IF;
	
	IF errore_utente = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Tipo Id_Utente non valido')  
        INTO errore_utente FROM information_schema.tables;
    END IF;
	
    IF errore_stato = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Stato non valido')  
        INTO errore_stato FROM information_schema.tables;
    END IF;  	

	IF errore_orario_consegna = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Orario Consegna non valido [formato numerico hh:mm]')
        INTO errore_orario_consegna FROM information_schema.tables;
    END IF;  
	
	IF errore_tempo_attesa = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Tempo Atteso non valido')  
        INTO errore_tempo_attesa FROM information_schema.tables;
    END IF;  
	
	IF errore_tempo_nullo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Stato e Tempo Atteso non corrispondenti')  
        INTO errore_tempo_nullo FROM information_schema.tables;
    END IF;  
	
	IF errore_negativo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Valori negativi')  
        INTO errore_negativo FROM information_schema.tables;
    END IF; 
	
		
	
END; $$

/*TRIGGER DELETE*/
DELIMITER $$  
CREATE TRIGGER Ordine_delete BEFORE DELETE ON Ordine FOR EACH ROW  
BEGIN  
    DECLARE quantità_menù, vecchio_disponibilità, errore_cancellazione int; 
	DECLARE nome_menù, stato_ordine varchar(20);
	
	set stato_ordine = (select stato from ordine o where o.id_ordine = old.id_ordine);
	
	IF(stato_ordine not like "attesa")
	THEN
		SET errore_cancellazione = 1;
	END IF;
	
	IF errore_cancellazione = 1 THEN  
        SELECT CONCAT('Cancellazione non valida - Ordine! Stato incompatibile!')  
        INTO errore_cancellazione FROM information_schema.tables;
    END IF; 
	
END; $$

/*--------------------------------------------------------------/* CARRELLO */--------------------------------------------------------------------*/
/*TRIGGER INSERT*/
DELIMITER $$  
CREATE TRIGGER Check_Carrello BEFORE INSERT ON Carrello FOR EACH ROW  
BEGIN  
    DECLARE  errore_utente, errore_set, errore_negativo int;  
	DECLARE controllo_utente varchar(20);
	SET controllo_utente = (select tipo from Account a where new.id_account = a.id_account);
	
	IF (controllo_utente not like "Utente")
	THEN 
        SET errore_utente = 1;  
    END IF;
	
	IF(new.TOTALE_QUANTITÀ not like 0 || new.TOTALE_PREZZO not like 0)
	THEN 
        SET errore_set = 1;  
    END IF;
	
	IF (NEW.TOTALE_QUANTITÀ < 0) || (NEW.TOTALE_PREZZO < 0)
	THEN 
        SET errore_negativo = 1;  
    END IF;  

	
    IF errore_negativo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Carrello! Valori negativi')  
        INTO errore_negativo FROM information_schema.tables;
    END IF; 
		
	IF errore_utente = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Carrello! Tipo Id_Utente non valido')  
        INTO errore_utente FROM information_schema.tables;
    END IF;
	
	IF errore_set = 1 THEN  
    SELECT CONCAT('Inserimento non valido - Carrello! Inizializzazione non valida')  
        INTO errore_set FROM information_schema.tables;
    END IF;
END; $$

/*TRIGGER UPDATE*/
DELIMITER $$  
CREATE TRIGGER Check_Carrello_Update BEFORE UPDATE ON Carrello FOR EACH ROW  
BEGIN  
    DECLARE  errore_utente, errore_negativo int;  
	DECLARE controllo_utente varchar(20);
	SET controllo_utente = (select tipo from Account a where new.id_account = a.id_account);
	
	IF (controllo_utente not like "Utente")
	THEN 
        SET errore_utente = 1;  
    END IF;
	
	IF (NEW.TOTALE_QUANTITÀ < 0) || (NEW.TOTALE_PREZZO < 0)
	THEN 
        SET errore_negativo = 1;  
    END IF;  

	
    IF errore_negativo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Carrello! Valori negativi')  
        INTO errore_negativo FROM information_schema.tables;
    END IF; 
		
	IF errore_utente = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Carrello! Tipo Id_Utente non valido')  
        INTO errore_utente FROM information_schema.tables;
    END IF;
	
END; $$

/*--------------------------------------------------------------/* RECENSIONE */--------------------------------------------------------------------*/
/*TRIGGER INSERT*/
DELIMITER $$  
CREATE TRIGGER Check_Recensione BEFORE INSERT ON Recensione FOR EACH ROW  
BEGIN  
    DECLARE errore_titolo, errore_testo, errore_utente int;  
	DECLARE controllo_utente varchar(20);
	DECLARE errore_nickname int;
	
	SET controllo_utente = (select tipo from Account a where new.id_account = a.id_account);
	
    IF (length(NEW.titolo) < 10)
	THEN 
        SET errore_titolo = 1;  
    END IF;  
	
	IF (length(NEW.testo) < 50)
	THEN 
        SET errore_testo = 1;  
    END IF;  
	
	IF (controllo_utente not like "Utente")
	THEN 
        SET errore_utente = 1;  
    END IF;
	
	IF (length(NEW.nickname) < 2)
	THEN 
        SET errore_nickname = 1;  
    END IF; 
	
	IF errore_nickname = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Recensione! Nickname non valido [deve avere almeno 2 caratteri]')  
        INTO errore_nickname FROM information_schema.tables;
    END IF;  	
	
    IF errore_titolo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Recensione! Titolo non valido [deve avere almeno 10 caratteri]')  
        INTO errore_titolo FROM information_schema.tables;
    END IF;  	
	
	IF errore_testo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Recensione! Testo non valido [deve avere almeno 50 caratteri]')  
        INTO errore_testo FROM information_schema.tables;
    END IF;  
	
	IF errore_utente = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Recensione! Tipo Id_Utente non valido')  
        INTO errore_utente FROM information_schema.tables;
    END IF;
END; $$

/*TRIGGER UPDATE*/
DELIMITER $$  
CREATE TRIGGER Check_Recensione_Update BEFORE UPDATE ON Recensione FOR EACH ROW  
BEGIN  
    DECLARE errore_titolo, errore_testo, errore_utente int;  
	DECLARE controllo_utente varchar(20);
	DECLARE errore_nickname int;
	
	SET controllo_utente = (select tipo from Account a where new.id_account = a.id_account);

	
    IF (length(NEW.titolo) < 10)
	THEN 
        SET errore_titolo = 1;  
    END IF;  
	
	IF (length(NEW.testo) < 50)
	THEN 
        SET errore_testo = 1;  
    END IF;  
	
	IF (controllo_utente not like "Utente")
	THEN 
        SET errore_utente = 1;  
    END IF;
	
	IF (length(NEW.nickname) < 2)
	THEN 
        SET errore_nickname = 1;  
    END IF; 
	
	IF errore_nickname = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Recensione! Nickname non valido [deve avere almeno 2 caratteri]')  
        INTO errore_nickname FROM information_schema.tables;
    END IF;  	
	
    IF errore_titolo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Recensione! Titolo non valido [deve avere almeno 10 caratteri]')  
        INTO errore_titolo FROM information_schema.tables;
    END IF;  	
	
	IF errore_testo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Recensione! Testo non valido [deve avere almeno 50 caratteri]')  
        INTO errore_testo FROM information_schema.tables;
    END IF;  
	
	IF errore_utente = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Ordine! Tipo Id_Utente non valido')  
        INTO errore_utente FROM information_schema.tables;
    END IF;
END; $$

/*--------------------------------------------------------------/* MENU'*/--------------------------------------------------------------------*/
/*TRIGGER INSERT*/
DELIMITER $$  
CREATE TRIGGER Check_Menù BEFORE INSERT ON Menù FOR EACH ROW  
BEGIN  
    DECLARE errore_negativo int;  
	
	
    IF (NEW.prezzo < 0) || (NEW.DISPONIBILITA < 0)
	THEN 
        SET errore_negativo = 1;  
    END IF;  

	
    IF errore_negativo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Menù! Valori negativi')  
        INTO errore_negativo FROM information_schema.tables;
    END IF;  	
	
END; $$

/*TRIGGER UPDATE*/
DELIMITER $$  
CREATE TRIGGER Check_Menù_Update BEFORE UPDATE ON Menù FOR EACH ROW  
BEGIN  
    DECLARE errore_negativo int;  
	

    IF (NEW.prezzo < 0) || (NEW.DISPONIBILITA < 0)
	THEN 
        SET errore_negativo = 1;  
    END IF;  

	
    IF errore_negativo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Menù! Valori negativi')  
        INTO errore_negativo FROM information_schema.tables;
    END IF;  

END; $$


/*--------------------------------------------------------------/* COMPONENTE */--------------------------------------------------------------------*/
/*TRIGGER INSERT*/
DELIMITER $$  
CREATE TRIGGER Check_Componente BEFORE INSERT ON Componente FOR EACH ROW  
BEGIN  
    DECLARE errore_negativo, errore_tipo, errore_valori int;  
	
	
	IF (NEW.Tipo not like "PANINO") AND (NEW.Tipo not like "CONTORNO") AND (NEW.Tipo not like "BIBITA") AND (NEW.Tipo not like "AGGIUNTIVO")  THEN
        SET errore_tipo = 1;  
    END IF;
	
	IF( NEW.Tipo like "PANINO") THEN
		IF (NEW.descrizione is null) THEN
			SET errore_valori = 1;  
		END IF; 
	END IF;
	
	IF( NEW.Tipo like "AGGIUNTIVO") THEN
		IF (NEW.PREZZO is null) THEN
			SET errore_valori = 1;  
		END IF; 
	END IF;
	
	IF	(NEW.Tipo like "CONTORNO") || ( NEW.Tipo like "BIBITA") || ( NEW.Tipo like "PANINO") THEN
		IF (NEW.PREZZO is not null) THEN
			SET errore_valori = 1;  
		END IF; 
	END IF;

	IF	(NEW.Tipo like "CONTORNO") || ( NEW.Tipo like "BIBITA") || ( NEW.Tipo like "AGGIUNTIVO") THEN
		IF (NEW.DESCRIZIONE is not null) THEN
			SET errore_valori = 1;  
		END IF; 
	END IF;
	
    IF (NEW.prezzo is not null ) && (NEW.prezzo < 0)
	THEN 
        SET errore_negativo = 1;  
    END IF;  

	
    IF errore_negativo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Componente! Prezzo negativo')  
        INTO errore_negativo FROM information_schema.tables;
    END IF;  
	
	IF errore_valori = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Componente! Valori non esatti')  
        INTO errore_valori FROM information_schema.tables;
    END IF;

	 IF errore_tipo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Componente! Tipo non consentito')  
        INTO errore_tipo FROM information_schema.tables;
    END IF; 
	
END; $$

/*TRIGGER UPDATE*/
DELIMITER $$  
CREATE TRIGGER Check_Componente_Update BEFORE UPDATE ON Componente FOR EACH ROW  
BEGIN  
    DECLARE errore_negativo int;  
	

    IF (NEW.prezzo is not null ) && (NEW.prezzo < 0)
	THEN 
        SET errore_negativo = 1;  
    END IF;  

	
    IF errore_negativo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Componente! Prezzo negativo')  
        INTO errore_negativo FROM information_schema.tables;
    END IF;  	
	
END; $$


/*--------------------------------------------------------------/* MENU' SCELTO */--------------------------------------------------------------------*/
/*TRIGGER INSERT*/
DELIMITER $$  
CREATE TRIGGER Check_Menù_scelto BEFORE INSERT ON Menù_scelto FOR EACH ROW  
BEGIN  
    DECLARE disponibilita_menù, errore_quantità, errore_nome, errore_prezzo int; 
	DECLARE nome_Menù varchar(20);
	DECLARE prezzo_menù float(7);
	
	SET disponibilita_menù = (select m.disponibilita from Menù m where  m.nome =  new.nome);
	SET nome_menù = (select m.nome from Menù m where  m.nome =  new.nome);
	SET prezzo_menù = (select m.prezzo from Menù m where  m.nome =  new.nome);
	
	IF (nome_menù is null)
	THEN 
        SET errore_nome = 1;  
    END IF;  
	
	IF (disponibilita_menù < NEW.QUANTITÀ) || (new.QUANTITÀ <= 0)
	THEN 
        SET errore_quantità = 1;  
    END IF;  
	
	IF (prezzo_menù not like new.prezzo)
	THEN 
        SET errore_prezzo = 1;  
    END IF;  
	
	IF errore_nome = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Menù_Scelto! Nome Menù non disponibile')  
        INTO errore_nome FROM information_schema.tables;
    END IF; 
	
	IF errore_quantità = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Menù_Scelto! Quantità non disponibile o invalida')  
        INTO errore_quantità FROM information_schema.tables;
    END IF;  

	IF errore_prezzo = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Menù_Scelto! Prezzo non corrispondente')  
        INTO errore_prezzo FROM information_schema.tables;
    END IF; 	
	
END; $$

/*TRIGGER DELETE*/
DELIMITER $$  
CREATE TRIGGER Check_Menù_scelto_delete BEFORE DELETE ON Menù_scelto FOR EACH ROW  
BEGIN  
    DECLARE codice_carrello, vecchio_quantità int; 
	DECLARE vecchio_prezzo, prezzo_menu float(7);
	
	Set codice_carrello = (select id_carrello from contiene  where id_menù_scelto = old.id_menù_scelto);
	Set vecchio_prezzo = (Select totale_prezzo from carrello  where id_carrello = codice_carrello);
	Set vecchio_quantità = (Select totale_quantità from carrello  where id_carrello = codice_carrello);
	Set prezzo_menu = (old.prezzo * old.quantità);
	
	UPDATE carrello  SET totale_prezzo = vecchio_prezzo - prezzo_menu where id_carrello = codice_carrello;
	UPDATE carrello  SET totale_quantità = vecchio_quantità - old.quantità where ID_CARRELLO = codice_carrello;
END; $$

/*--------------------------------------------------------------/* COMPOSTO DA */--------------------------------------------------------------------*/
/*TRIGGER INSERT*/
DELIMITER $$  
CREATE TRIGGER Check_Composto_da BEFORE INSERT ON Composto_da FOR EACH ROW  
BEGIN  
    DECLARE codice_Menù, errore_corrispondenza_Menù int; 
	DECLARE nome_Menù varchar(20);
	DECLARE prezzo_componente , prezzo_vecchio float(7);
		
	SET nome_Menù = (select m.nome from Menù_scelto m where  m.ID_MENÙ_SCELTO =  new.ID_MENÙ_SCELTO);

	SET codice_Menù = (select Id_Menù from Costituito_da c where exists (select * from Menù m where new.id_componente = c.id_componente and m.nome = nome_Menù and m.ID_MENÙ = c.ID_menù));

	
	IF (codice_Menù is null)
	THEN 
        SET errore_corrispondenza_Menù = 1;  
    END IF;  

	IF errore_corrispondenza_Menù = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Composto_da! Componente non presente nel Menù')  
        INTO errore_corrispondenza_Menù FROM information_schema.tables;
    END IF;  	
	
	SET prezzo_componente =  (select prezzo from componente c where c.id_componente = new.id_componente);
	SET prezzo_vecchio = (select prezzo from Menù_scelto m where m.id_menù_scelto = new.id_menù_scelto);
	
	IF prezzo_componente is not null THEN
		UPDATE Menù_scelto m SET prezzo = prezzo_vecchio + prezzo_componente where m.id_menù_scelto = new.id_menù_scelto;
	END IF;
	
END; $$

/*TRIGGER DELETE*/
DELIMITER $$  
CREATE TRIGGER Check_Composto_da_delete BEFORE DELETE ON Composto_da FOR EACH ROW  
BEGIN  

	DECLARE prezzo_componente , prezzo_vecchio float(7);
		
	
	SET prezzo_componente =  (select prezzo from componente c where c.id_componente = old.id_componente);
	SET prezzo_vecchio = (select prezzo from Menù_scelto m where m.id_menù_scelto = old.id_menù_scelto);

	IF prezzo_componente is not null THEN
		UPDATE Menù_scelto m SET prezzo = prezzo_vecchio - prezzo_componente where m.id_menù_scelto = old.id_menù_scelto;
	END IF;
END; $$
/*--------------------------------------------------------------/* CONTIENE */--------------------------------------------------------------------*/
/*TRIGGER INSERT*/
DELIMITER $$  
CREATE TRIGGER Check_Contiene BEFORE INSERT ON Contiene FOR EACH ROW  
BEGIN  
    DECLARE quantità_menù, vecchio_quantità, codice_menù, errore_id int; 
	DECLARE prezzo_carrello, prezzo_menù, vecchio_prezzo float(7);
	DECLaRE nome_menu varchar(25);
	
	Set nome_menu = (Select nome from Menù_scelto m where m.id_menù_scelto = new.id_menù_scelto);
	/*Set codice_menù = (Select id_menù_scelto from Contiene c where exists (select * from Menù_scelto m where m.nome = nome_menu and c.id_menù_scelto = m.id_menù_scelto and c.id_carrello = new.id_carrello));*/
	
	/*
	IF (codice_menù is not null)
	THEN 
        SET errore_id = 1;  
    END IF; 
	
	IF errore_id = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Contiene! Menù già contenuto nel carrello!')  
        INTO errore_id FROM information_schema.tables;
    END IF;  */
	
	Set prezzo_menù = (select prezzo from Menù_Scelto where id_menù_scelto = new.id_menù_scelto);
	Set quantità_menù = (select quantità from Menù_Scelto where id_menù_scelto = new.id_menù_scelto);
	Set prezzo_carrello = (prezzo_menù * quantità_menù);
	
	Set vecchio_prezzo = (select totale_prezzo from Carrello where id_carrello = new.id_carrello);
	Set vecchio_quantità = (select totale_quantità from Carrello where id_carrello = new.id_carrello);
	
	UPDATE Carrello c SET totale_prezzo = vecchio_prezzo + prezzo_carrello where c.ID_CARRELLO = new.ID_Carrello;
	UPDATE Carrello c SET totale_quantità = vecchio_quantità + quantità_menù where c.ID_CARRELLO = new.ID_Carrello;
	
	
	  	
END; $$




/*--------------------------------------------------------------/* POSSIEDE */--------------------------------------------------------------------*/
/*TRIGGER INSERT*/
DELIMITER $$  
CREATE TRIGGER Check_Possiede BEFORE INSERT ON Possiede FOR EACH ROW  
BEGIN  
    DECLARE quantità_menù,  codice_menù, controllo_id_menù, controllo_id_Carrello , errore_id, vecchio_disponibilità, vecchio_quantità int; 
	DECLARE nome_menù varchar(20);
	DECLARE prezzo_menù, vecchio_prezzo, prezzo_ordine float;
	
	Set codice_menù = (Select id_menù_scelto from Possiede p where p.id_menù_scelto = new.id_menù_scelto);
	Set controllo_id_menù = (Select id_menù_scelto from Contiene c where c.id_menù_scelto = new.id_menù_scelto);
	Set controllo_id_Carrello = (Select id_carrello from Contiene c where c.id_menù_scelto = new.id_menù_scelto);
	
	IF (codice_menù is not null)
	THEN 
        SET errore_id = 1;  
    END IF; 
	
	IF errore_id = 1 THEN  
        SELECT CONCAT('Inserimento non valido - Possiede! Menù già contenuto in un altro ordine!')  
        INTO errore_id FROM information_schema.tables;
    END IF;  
	
	Set quantità_menù = (select quantità from Menù_Scelto where id_menù_scelto = new.id_menù_scelto);
	Set prezzo_menù = (select prezzo from Menù_Scelto where id_menù_scelto = new.id_menù_scelto);
	Set nome_menù = (select nome from Menù_Scelto where id_menù_scelto = new.id_menù_scelto);
	Set vecchio_disponibilità = (select disponibilita from Menù m where m.nome = nome_menù);
	
	UPDATE Menù m SET disponibilita = vecchio_disponibilità - quantità_menù where m.nome = nome_menù;  	
	
	DELETE FROM Contiene WHERE id_menù_scelto = controllo_id_menù;
	UPDATE carrello c SET totale_prezzo = 0, totale_quantità = 0 where c.id_Carrello = controllo_id_Carrello;
	
	Set vecchio_prezzo = (select totale_prezzo from Ordine where id_ordine = new.id_ordine);
	Set vecchio_quantità = (select totale_quantità from Ordine where id_ordine = new.id_ordine);
	
	Set prezzo_ordine = (prezzo_menù * quantità_menù);
	UPDATE ordine o SET totale_quantità = vecchio_quantità + quantità_menù  where o.id_ordine = new.id_ordine;
	UPDATE ordine o SET totale_prezzo = vecchio_prezzo + prezzo_ordine where o.id_ordine = new.id_ordine;
END; $$

/*TRIGGER DELETE*/
DELIMITER $$  
CREATE TRIGGER Check_Possiede_delete BEFORE DELETE ON Possiede FOR EACH ROW  
BEGIN  

	DECLARE quantità_menù, vecchio_disponibilità int; 
	DECLARE nome_menù varchar(20);
		
	Set quantità_menù = (select quantità from Menù_Scelto m where m.ID_MENÙ_SCELTO = old.ID_MENù_SCELTO);
	Set nome_menù = (select nome from Menù_Scelto m where m.ID_MENÙ_SCELTO = old.ID_MENù_SCELTO);
	Set vecchio_disponibilità = (select disponibilita from Menù m where m.nome = nome_menù);
	

	UPDATE Menù m SET disponibilita = vecchio_disponibilità + quantità_menù where m.nome = nome_menù;
	
END; $$
/*------------------------------------------------------------------------------------------------------------------------------------------*/


