<?php

    /*const BASE_URL = "https://buhosmarqueteriaygaleria.co";
	
    const DB_HOST = "localhost";
	const DB_NAME = "u209003010_buhos";
	const DB_USER = "u209003010_buhos";
	const DB_PASSWORD = "Buhos.197023";
	const DB_CHARSET = "utf8";*/
	const DB_HOST = "localhost";
	const BASE_URL = "http://localhost/mediastore";
	const DB_NAME = "db_mediastore";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "utf8";
	
	date_default_timezone_set('America/Bogota');

	//Otros
	const KEYWORDS ="";
	const MS = "$"; // Simbolo de moneda
	const MD = " US"; // Divisa
	const DEC = ","; // Decimales;
	const MIL = ".";//Millares;
	const ENVIO =0;
	const DESCRIPCION = "Marquetería tradicional y Moderna para diplomas, fotografías, afiches, retablos, espejos y obras de arte. Venta de todo tipo de obra sobre lienzo. La mejor marquetería del departamento de Villavicencio/Meta";
	const SHAREDHASH ="BuhosMarqueteríayGalería";
	//Datos envio de correo produccion
	/*const NOMBRE_REMITENTE= "Buhos Marquetería & Galería";
	const EMAIL_REMITENTE = "info@buhosmarqueteriaygaleria.co";
	const EMAIL_COPIA = "davidstiven1999@hotmail.com";
	const REMITENTE_PASSWORD = "Buhos.197023";*/

	//Datos envio de correo pruebas
	const NOMBRE_REMITENTE= "MediaStore";
	const EMAIL_REMITENTE = "davidstiven1999@hotmail.com";
	const EMAIL_COPIA = "davidstiven1999@hotmail.com";
	const REMITENTE_PASSWORD = "da197023";
	
	const NOMBRE_EMPRESA = "MediaStore";
	const DIRECCION = "Colombia, Villavicencio/Meta, Cra 36 #15a-03 Barrio Nuevo Ricaurte";
	const TELEFONO = "(+57)3108714741";
	const WEB_EMPRESA = "https://buhosmarqueteriaygaleria.co";

	//Encriptado
	const KEY = "ecommerce";
	const METHOD = "AES-128-ECB";

	//mercadopago
	const COMISION = 1.04;
	const TASA = 900;
	const IVA = 0.19;
?>