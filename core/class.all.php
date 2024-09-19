<?php
    /**
     * All functions
     * */ 

	Class _MyAllFunctions{
		public function __construct(){} 
		
        public function mobilePost(){
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            return $data;
        }
        public function __toJson($data) {
            header('Content-type: application/json');
            $output = json_encode($data, JSON_PRETTY_PRINT);
            return $output;
        }
        public function __toArray($data){
            if(gettype($data) == "object"){
                $data = (array)$data;
            }
            return $data;
        }
        public function __toObject($data){
            if(gettype($data) == "array"){
                $data = (object)$data;
            }
            return $data;
        }
		public function findString($searchain,$searchword,$i,$word){
			// $i = "" OR "i" for case insensitive
			if(strtoupper($word)=="W"){
				// $word=W: search instead of string in string search.
				if(preg_match("/\b{$searchain}\b/{$i}", $searchword)){
					return true;
				}
			}
			else{
				if(preg_match("/{$searchain}/{$i}", $searchword)){
					return true;
				}
			}
			return false;
		}
		public function containString($searchain,$searchword){
			if( str_contains($searchain,$searchword) ){
				return true;
			}else{
				return false;
			}
		} 
		public function gettypedata($data,$type){
			if($type=='string'){
				if(gettype($data) != 'string'){ 
					$data = (String)$data; 
				}
			}
			else{
				if($type=='object'){ 
					$data = (object)$data;  
				}
				else{
					$data = (array)$data;   
				}
			}
			return $data;
		} 
		public function url_exists2($url) {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_exec($ch);
			$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if($code==200){
				return true;
			}
			else{
				return false;
			}
		}
		public function getgoode_url($idvideo){
			$link = "https://i.ytimg.com/vi/".$idvideo."/maxresdefault.jpg" ;
			if($this->url_exists2($link)){
				$link = "https://i.ytimg.com/vi/".$idvideo."/maxresdefault.jpg" ;
			}
			else{
				$link = "https://i.ytimg.com/vi/".$idvideo."/hqdefault.jpg" ;
				if($this->url_exists2($link)){
					$link = "https://i.ytimg.com/vi/".$idvideo."/hqdefault.jpg" ;
				}
				else{
					$link = "https://i.ytimg.com/vi/".$idvideo."/default.jpg" ;
					if($this->url_exists2($link)){
						$link = "https://i.ytimg.com/vi/".$idvideo."/default.jpg" ;
					}
					else{
						$link = '' ;
					}
				}
			}
			return $link;
		} 
		// $code="ga";
		// $style="shiny"; // flat , shiny
		// $size="48"; // 16 , 24 , 32 , 48 , 64
		// print_r(getFlagsCountry($code,$style,$size)); 
		public function getFlagsCountry($code,$style,$size,$urlonly=null){
			$url = "https://www.countryflags.io/".$code."/".$style."/".$size.".png";
			$img = '<img src="'.$url.'">';
			if($urlonly !=null){
				$img = $url;
			}
			return $img;
		} 
		public function connecterInternet(){
			if(!$sock = @fsockopen('www.google.fr', 80, $num, $error, 5)){ return 0; }
			else{ return 1; } 
		} 
		public function randomHex() {
			$color= substr(str_shuffle('AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899'), 0, 6);
			return $color;
		}
		// 	BBCode personnalisé  
		public function decodePOSTE($data){
			$rest='';
			$nn= array('<','>','','>');
			$oo= array('[',']',"'\'",'; ]');
			$rest = str_replace($oo, $nn, $data); 
			return $rest;
		}
		public function decodePOSTsimple($data){
			$rest='';
			$nn= array('<','>','','>');
			$oo= array('[',']',"'\'",'; ]');
			$rest = str_replace($oo, $nn, $data);
			// $NON_array = array(',', '"', '\'', '&amp;', '  ',"'");
			// $OUI_array = array('',  '',  ' ',   '', ' ', "&#39;", "&#39;");
			// $rest = str_replace($NON_array, $OUI_array, $rest);
			return $rest;
		}
		public function encodePOST($data){
			$rest='';
			$nn= array('<','>','"');
			$oo= array('[',']','');
			$rest = str_replace($nn, $oo, $data);
			return $rest;
		}
		public function decodeAff($data){
			$rest='';
			$rest = html_entity_decode($data);
			return $rest;
		}
		public function removeBalises($data){
			$rest='';
			$nn= array('<','>');
			$oo= array('[',']');
			$rest = str_replace($oo, $nn, $data);
			$tad = array('<br>','</br>','<br/>','<hr>','<hr/>','<p>','</p>','<b>','</b>','<i>','</i>','<u>','</u>','<h1>','</h1>','<h2>','</h2>','<h3>','</h3>','<h4>','</h4>','<h5>','</h5>','<h6>','</h6>','<pre>','</pre>');
			$nn2= array('','');
			$rest = str_replace($tad, $nn2, $rest);
			return $rest;
		}
		public function decodePOST3($data){
			$rest='';
			$nn= array('<', '>', '', '', '', '', '');
			$oo= array('[' ,']' ,"'\'", '&amp;', '&quot;', '&amp;quot;' ,'amp;nbsp;');
			$rest = str_replace($oo, $nn, $data);
			$tad = array('<ol>','</ol>','<li>','</li>','<p>','</p>','<b>','</b>','<i>','</i>','<u>','</u>','<h1>','</h1>','<h2>','</h2>','<h3>','</h3>','<h4>','</h4>','<h5>','</h5>','<h6>','</h6>','<pre>','</pre>');
			$nn2= array('','');
			$rest = str_replace($tad, $nn2, $rest);
			return $rest;
		}
		public function formateFromPOST($chaine){
			global $mesfonctionsusuelles ;
			$chaine = $this->encodePOST($mesfonctionsusuelles->formatage_from_post($chaine));
			return $chaine;
		}
		public function formateToPOST($chaine){
			global $mesfonctionsusuelles ;
			$chaine = $this->decodePOSTE($chaine);
			$chaine = $mesfonctionsusuelles->formatage_special_chars($chaine,1);
			$chaine = $mesfonctionsusuelles->formatage_affichage($chaine);
			$chaine = $this->decodeAff($chaine);
			return $chaine;
		}
		public function formateToPOSTSimple($chaine){ 
			global $mesfonctionsusuelles ;
			$chaine = $this->decodePOSTE($chaine);
			$chaine = $mesfonctionsusuelles->formatage_affichage($chaine);
			$chaine = $mesfonctionsusuelles->formatage_special_chars($chaine,1);
			return $chaine;
		}   
		public function minuscule($mot){
			if(gettype($mot) == 'string'){
				$mot = strtolower($mot);
			}
			return $mot;
		}
		public function majuscule($mot){
			if(gettype($mot) == 'string'){
				$mot = strtoupper($mot);
			}
			return $mot;
		}  
		public function _parsentonumber($number){ return $number = ($number == (int) $number) ? (int) $number : (float) $number; }
		public function _additionner($val,$val2){ return $val + $val2 ;}
		public function _soustraire($val,$val2){  return $val - $val2 ;}
		public function _diviser($val,$val2){ return $val/ $val2 ;}
		public function _multiplier($val,$val2){ return $val * $val2 ;}
		public function _modulo($val,$val2){ return $val % $val2 ;}
		public function _exponentiel($val,$val2){ return $val ** $val2 ;} 
		public function getRandomPictures($limit){
			// [{"id":"0","author":"","width":"","height":"","url":"","download_url":""}]
			$url = "https://picsum.photos/v2/list?random=2&limit=".$limit;
			$datas = @file_get_contents($url);
			$datas = json_decode($datas);
			return $datas;
		}
		public function getRandomPicture($width,$height){
			$datas = "https://picsum.photos/".$width."/".$height."?grayscale&blur=2" ;
			return $datas;
		}
		public function getAvatar(){
			global $cookies;
			global $_myall;
			if($_myall->connecterInternet()==1){
				$link = $this->getRandomPicture('300','300');
				// $link = $link[0]->download_url;
				// $idat = base64_encode(file_get_contents($link));
				// $base64 = 'data:image/png;base64,' . base64_encode($idat);
				$cookies->set('avatar', $link);
				$img = $link;
			}
			else{
				// s'il y a un stockage
				if($cookies->get('avatar') == true){
					$img = $cookies->get('avatar');
				}else{
					$img = "img/user.png";
				}
			}
			return $img;
		} 
		public function strictExtractNumber($str){
			if(gettype($str) == 'string'){
				$str = preg_replace("/[^0-9]/", '', $str);
			}
			return $str;
		}
		public function partialExtractNumber($str){
			if(gettype($str) == 'string'){
				$str = preg_replace("/[^0-9\.]/", '', $str);
			}
			return $str;
		}
		public function strExtractNumber($str){
			if(gettype($str) == 'string'){
				$str = preg_replace("/[^0-9]/", '', $str);
			}
			return $str;
		}
		public function toFixed($number, $decimals) {
			return number_format($number, $decimals, '.', "");
		}
		public function convertBytes($number){
			$_uniTS = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
			
			// if($unit == "KB")
			// {
			// 	return $fileSize = round($size / 1024,4) . 'KB';	
			// }
			// if($unit == "MB")
			// {
			// 	return $fileSize = round($size / 1024 / 1024,4) . 'MB';	
			// }
			// if($unit == "GB")
			// {
			// 	return $fileSize = round($size / 1024 / 1024 / 1024,4) . 'GB';	
			// }

			$l = 0;
			$n = (int)$number;
			while($n >= 1024 && ++$l){
				$n = $n/1024;
			}
			return $this->toFixed($n, $n < 10 && $l > 0 ? 1 : 0)  .' '. $_uniTS[$l] ;
		} 
		public function getLocatMe()
		{
			$url   = "http://ip-api.com/json";
			$datas = file_get_contents($url);
			$datas = json_decode($datas);
			return $datas; // print_r($datas);
			// stdClass Object
			// (
			//     [status] => success
			//     [country] => Cameroon
			//     [countryCode] => CM
			//     [region] => CE
			//     [regionName] => Centre
			//     [city] => Mbalmayo
			//     [zip] =>
			//     [lat] => 3.51667
			//     [lon] => 11.5
			//     [timezone] => Africa/Douala
			//     [isp] => Orange Cameroun Internet IP Pool1
			//     [org] =>
			//     [as] => AS36912 Orange Cameroun SA
			//     [query] => 41.202.207.14
			// )
		}
	}
 