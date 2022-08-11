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
	const MD = " USD"; // Divisa
	const DEC = ","; // Decimales;
	const MIL = ".";//Millares;
	const ENVIO =0;
	const DESCRIPCION = "Lorem ipsum dolor sit amet consectetur adipiscing elit tempor, natoque aptent metus purus nostra fames commodo, venenatis justo himenaeos ultrices congue varius magna.";
	const SHAREDHASH ="mediastore";
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
	const DIRECCION = "1234 Street Name, City, US";
	const TELEFONO = "+1 123123123123";
	const WEB_EMPRESA = "http://localhost/mediastore";

	//Paypal data
	const CURRENCY ="USD";
	const CLIENT_ID ="AakgfOkNP7xRfFWsnxsBFwlDFCnrbry6NWBM9Lg-003UIFfZgnvMprJLHyhrZj65i0oMJx-SF9QS4z6R";
	const SECRET = "EGbVpex-9_HGLoBB2N6fYii6Qjzbad0yRupp8vbeg9pf95S_R9pUsqMxI3uHy2D2KOoJ8-Ez16jvFb96";
	const URLPAYPAL="https://api.sandbox.paypal.com";
	
	//Encriptado
	const KEY = "ecommerce";
	const METHOD = "AES-128-ECB";

	//SOCIAL NETWORKS
	const FACEBOOK="https://www.facebook.com";
	const INSTAGRAM = "https://www.instagram.com";
	const TWITTER = "https://www.twitter.com";
?>