<?php    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
	$_timeZone      = 'Africa/Libreville';

    $_useScrapping  = true;
    $_page          = 1;
    $_limit         = 10;
    $_join          = [];
    $_hasMany       = [];
    $_where         = null;
    $_search        = null;
    $_orderby       = null;
    $_fromView      = '';
    $_fromProcedure = '';
    $_orderdir      = 'DESC';
    $_indexKey      = 'index';
    $_iscryptPSW    = true;
    $_titleToken    = 'access_token';
    $_longToken     = 40;
    $_expireAccount = 90; //day
    $_defaultActive = true;
    $_accountsFiles = '__qc2qE6Yx3773mJsau35q6H8zer85.json';
    $validExtens    = array("jpg", "jpeg", "png", "gif", "pdf", "txt", "csv", "xlsx");
 
	require_once '_fcts.php'; 

    $_appname     = 'restapi'; 
	$_baseUrl     = "https://api.bitech-gabon.com";
	$_baseFolder  = $_myfile->createFolder('apidata');
    $_serverToken = "rqXJ28773mJsau3D8EzzjCT3m4GrKi42YLD33Ab4";
    
    $_method      = $_SERVER["REQUEST_METHOD"];
    $_uriSVR      = $_SERVER["REQUEST_URI"];
    $_token       = $_GET['token'] ?? '';
    
    try {
        // SECURISER L'API
        if(!in_array($_GET['action'], ['login','logout']) && !verifyJWT($_token,$_baseFolder) && $_token != $_serverToken){
            // S'il n'ya pas de token en paramètre et que la route demander ne soit ni "LOGIN" ou "LOGOUT",
            // on génère une erreur.
            $response = array('success'=>false,'data'=>[], 'message'=>$_httpRes->__get(401) .", ".$_httpRes->__get(407));
            $res = $_httpRes->__response($response);
            echo $_myall->__toJson($res); 
        }
        else{ 
            $collection = $_GET['collection'] ?? '';
            $action     = $_GET['action'] ?? '';
            $id         = $_GET['id'] ?? null;  
            $local      = $_GET['local'] ?? null; 
            unset($_GET['apikey']); unset($_GET['token']); 
            unset($_GET['action']); unset($_GET['collection']);  
            if(isset($_GET['local'])){unset($_GET['local']); }

            $_params = $_GET;  

            include '_jsonactions.php';
        }
    } catch (Exception $e) {
        // 'file' => $e->getFile(),
        // 'line' => $e->getLine(),
        // 'trace' => $e->getTraceAsString()
        if(is_string($_httpRes->__get($e->getCode()))){$mess = $_httpRes->__get($e->getCode());}else{$mess = $e->getMessage();}
        $response = array('success'=>false,'data'=>[], 'message'=>$mess);
        $res = $_httpRes->__response($response);
        echo $_myall->__toJson($res); 
    }
