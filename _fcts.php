<?php  
	/**
	 * REQUIRE 
	 */
	require_once 'core/class.all.php'        		 ;	 
	require_once 'core/class.crud.json.php'  		 ;	
	require_once 'core/class.date.php'       		 ;	 
	require_once 'core/class.file.php'       		 ;  	
	require_once 'core/class.func.php'       		 ;	 
	require_once 'core/class.http.php'       		 ;	
	require_once 'core/class.mail.php'       		 ;	
	require_once 'resources/resources.all.php'       ;  	
	 
	$_mydates    = new DateConverter('fr');
	$_mymail     = new _MyMail(); 
	$_myfile     = new _MyFiles(['validExtens'=>$validExtens]);  
	$_httpRes    = new HttpStatusCode(); 
	$_myall      = new _MyAllFunctions();
	$_func       = new MesFonctionsUsuelles();  
	 
	// $_m = $_myfile->analyse();
	// if($_m !== false){
	// 	$_mymail->sendMail($_m);
	// }
	
	require_once '_fileactions.php'; 
	