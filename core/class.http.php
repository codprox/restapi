<?php
/**
 * Content from http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
 *
 * You may also want a list of unofficial codes:
 *
 *  103 => 'Checkpoint',
 *  218 => 'This is fine', // Apache Web Server
 *  419 => 'Page Expired', // Laravel Framework
 *  420 => 'Method Failure', // Spring Framework
 *  420 => 'Enhance Your Calm', // Twitter
 *  430 => 'Request Header Fields Too Large', // Shopify
 *  450 => 'Blocked by Windows Parental Controls', // Microsoft
 *  498 => 'Invalid Token', // Esri
 *  499 => 'Token Required', // Esri
 *  509 => 'Bandwidth Limit Exceeded', // Apache Web Server/cPanel
 *  526 => 'Invalid SSL Certificate', // Cloudflare and Cloud Foundry's gorouter
 *  529 => 'Site is overloaded', // Qualys in the SSLLabs
 *  530 => 'Site is frozen', // Pantheon web platform
 *  598 => 'Network read timeout error', // Informal convention
 *  440 => 'Login Time-out', // IIS
 *  449 => 'Retry With', // IIS
 *  451 => 'Redirect', // IIS
 *  444 => 'No Response', // nginx
 *  494 => 'Request header too large', // nginx
 *  495 => 'SSL Certificate Error', // nginx
 *  496 => 'SSL Certificate Required', // nginx
 *  497 => 'HTTP Request Sent to HTTPS Port', // nginx
 *  499 => 'Client Closed Request', // nginx
 *  520 => 'Web Server Returned an Unknown Error', // Cloudflare
 *  521 => 'Web Server Is Down', // Cloudflare
 *  522 => 'Connection Timed Out', // Cloudflare
 *  523 => 'Origin Is Unreachable', // Cloudflare
 *  524 => 'A Timeout Occurred', // Cloudflare
 *  525 => 'SSL Handshake Failed', // Cloudflare
 *  526 => 'Invalid SSL Certificate', // Cloudflare
 *  527 => 'Railgun Error', // Cloudflare
 * 	
 * 	--------------------------------------
 * 	HTTP response status codes:
 * 	Informational responses ( 100 – 199 )
 * 	Successful responses    ( 200 – 299 )
 * 	Redirection messages    ( 300 – 399 )
 * 	Client error responses  ( 400 – 499 )
 * 	Server error responses  ( 500 – 599 )
 * 	--------------------------------------
 * 	
*/
class Response{ 
    private $attributs = []; 

	public function __construct(){}

    public function __get($key){
        return (isset($this->attributs[$key])) ? $this->attributs[$key] : null;
    } 
    public function __set($key,$value){
        return $this->attributs[$key] = $value;
    } 

	public function set($data){
        foreach ($data as $key => $value) {
            $this->__set($key,$value);
        }
    }
	public function get(){ 
		return $this->attributs;
	}
}

class HttpStatusCode{
    public function __construct(){}

    public function __get($code){
        $httpStatusCodes = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            103 => 'Early Hints', 
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            208 => 'Already Reported', 
            226 => 'IM Used', 
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            308 => 'Permanent Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            418 => "I'm a teapot",
            419 => 'Authentication Timeout',
            420 => 'Enhance Your Calm',
            421 => 'Misdirected Request', 
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            424 => 'Method Failure',
            425 => 'Unordered Collection',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            444 => 'No Response',
            449 => 'Retry With',
            450 => 'Blocked by Windows Parental Controls',
            451 => 'Unavailable For Legal Reasons',
            494 => 'Request Header Too Large',
            495 => 'Cert Error',
            496 => 'No Cert',
            497 => 'HTTP to HTTPS',
            499 => 'Client Closed Request',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            508 => 'Loop Detected',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended',
            511 => 'Network Authentication Required',
            598 => 'Network read timeout error',
            599 => 'Network connect timeout error'
        );

        if(isset($httpStatusCodes[$code])){
            return $httpStatusCodes[$code];
        }
        else{
            return array();
        }
    }
    public function __incorrect($message){
        if(isset($message['message'])){
            return $message;
        }
        else{
            return array(
                'error'=>1, 
                'message'=>$message, 
                'status'=>$this->__get(400), 
            );
        }
    }
    public function __valide($data){
        $arr= array(
            'error'=>0,  
            'status'=>$this->__get(200), 
        );
        if(is_array($data)){
            if(isset($data['message'])){
                $arr['message'] = $data['message'];
            }
            if(isset($data['data'])){
                $arr['data'] = $data['data'];
            }
        }
        else{
            $arr['message'] = $data ;
        }
        return $arr;
    }
    public function __response($data,$pagination=null){
		$res = new Response();
        $res->set($data);
        return $res->get();  
    }
}
