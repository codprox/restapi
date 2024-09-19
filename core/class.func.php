<?php 
	/**
	*  Class [Bibliothèque] usuelle contenant toutes les grandes fonctions utilisées fréquement
	*  dans toutes les applications Web
	*  @author Armand MOUELE B.N. <armandmouele@gmail.com>
	*  @copyright Merc. 20 Mai 2014
	*  @license Propriété du Concepteur
	*/
	Class MesFonctionsUsuelles{    
		public function __construct(){} 
		public function formatage_special_chars($chaine,$ch=null){
			$NON_array  = array('&lt;','&gt;','&quot;','&amp;','&#39;','&#39;');
			$OUI_array  = array('<'   ,'>'   ,'"'     ,'&'    , "'"   , "£"   );
			if($ch ==null){
				$chaine = str_replace($OUI_array, $NON_array, $chaine);
			}
			else{
				$chaine = str_replace($NON_array, $OUI_array, $chaine);
			}
			return $chaine;
		}
		public function removepostrophe($chaine){
			$chaine = str_replace("'", "", $chaine);
			return $chaine;
		}
		public function formatage_from_post($chaine){
			$NON_array		= array('\'',"'");
			$OUI_array		= array('£',  '£');
			$chaine 		= str_replace($NON_array, $OUI_array, $chaine);

			$chaine			= addslashes(trim($chaine));
			$chaine			= html_entity_decode($chaine, ENT_QUOTES, 'UTF-8'); 
			$chaine 		= htmlspecialchars($chaine, ENT_NOQUOTES, 'UTF-8');
			$chaine 		= str_replace('&amp;','&',$chaine); // on garde l'&
			return $chaine;
		} 
		public function specials_caracteres($chaine, array $non,array $oui){
			$chaine 		= str_replace($non, $oui, $chaine);
			// $chaine			= stripslashes(trim($chaine));
			// $chaine			= html_entity_decode($chaine); 		// convertit les entités HTML spéciales en caractères 
			// $NON_array		= array('Ã©','&amp;lt;', '&amp;gt;', '&amp;', '&quot;', '&amp;quot;', '&lt;', '&gt;' ,"'\'" , "'"    );
			// $OUI_array		= array('é' ,'&lt;'    , '&gt;'    , '&'    , '"'     ,  ''         ,  '<'  ,  '>'   ,  ''  , '&#39;');
			// $chaine 		= str_replace($NON_array, $OUI_array, $chaine);
			return $chaine;
		}
		public function cleanUrl($chaine){
			return rawurlencode($chaine);
		}
		public function formatage_affichage($chaine){
			$NON_array		= array("'");
			$OUI_array		= array('£');
			$chaine 		= str_replace($OUI_array, $NON_array, $chaine);
			
			$chaine			= stripslashes(trim($chaine));
			$chaine			= html_entity_decode($chaine); 		// convertit les entités HTML spéciales en caractères 
			$NON_array		= array('Ã©','&amp;lt;', '&amp;gt;', '&amp;', '&quot;', '&amp;quot;', '&lt;', '&gt;' ,"'\'" , "'"    );
			$OUI_array		= array('é' ,'&lt;'    , '&gt;'    , '&'    , '"'     ,  ''         ,  '<'  ,  '>'   ,  ''  , '&#39;');
			$chaine 		= str_replace($NON_array, $OUI_array, $chaine);
			return $chaine;
		}
		public function formatageToAffichage($chaine){
			$NON_array		= array('£','£','&nbsp;',"�");
			$OUI_array		= array('\'',"'",' ',''); 
			$chaine 		= str_replace($NON_array, $OUI_array, $chaine);
			
			$chaine			= stripslashes(trim($chaine));
			$chaine			= html_entity_decode($chaine); 		// convertit les entités HTML spéciales en caractères 
			$NON_array		= array('Ã©','&amp;lt;', '&amp;gt;', '&amp;', '&quot;', '&amp;quot;', '&lt;', '&gt;' ,"'\'" );
			$OUI_array		= array('é' ,'&lt;'    , '&gt;'    , '&'    , '"'     ,  ''         ,  '<'  ,  '>'   ,  ''  );
			$chaine 		= str_replace($NON_array, $OUI_array, $chaine);
			$chaine 		= preg_replace('/\xc2\xa0/', '', $chaine);
			// -------------
			return $chaine;
		}
		public function formatage_valideurl($chaine, $table, $id) {
			$chaine         = iconv('windows-1252','UTF-8', $chaine);
			$NON_array		= array('Ã©','é','Ã¯','&amp;lt;', '&amp;gt;', '&amp;', '&quot;', '&amp;quot;', '&lt;', '&gt;' ,"'\'" , 'Ã¨','Ã´');
			$OUI_array		= array('e' ,'e','i', '&lt;'  ,'&gt;', '&', '"',  '',  '',  '',  '', 'e', 'o');
			$chaine 		= str_replace($NON_array, $OUI_array, $chaine);

			$NON_array		= array(
							'Ã','Ã¢','Ã©','Ã¨','Ãª','Ã«','Ã®','Ã¯','Ã´',
							'Ã¶','Ã¹','Ã»','Ã¼','Ã§','Å','â¬',
							'Â°','Ã','Ã','Ã','Ã','Ã','Ã','Ã',
							'Ã','Ã','Ã','Ã','Ã','Ã','Ã','Å',
							'À','Á','Â','Ã','Ä','Å','à','á','â','ã','ä','å',
							'Ò','Ó','Ô','Õ','Ö','Ø','ò','ó','ô','õ','ö','ø',
							'È','É','Ê','Ë','è','é','ê','ë'
							);

			$OUI_array		= array(
							'a','a','e','e','e','e','i','i','o',
							'o','u','u','u','c','oe','e',
							'','a','a','e','e','e','e','i',
							'i','o','o','u','u','u','c','oe',
							'a','a','a','a','a','a','a','a','a','a','a','a',
							'o','o','o','o','o','o','o','o','o','o','o','o',
							'e','e','e','e','e','e','e','e'
							);
			$chaine 		= str_replace($NON_array, $OUI_array, $chaine);

			// $chaine = strtr($chaine,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
			// Mettez ici les caractères spéciaux qui seraient susceptibles d'apparaître dans les titres. La liste ci-dessous est indicative.
			$speciau = array("?","!","@","#","%","&amp;","*","(",")","[","]","=","+"," ",";",":","'",".","_");
			$chaine = str_replace($speciau, "-", $chaine); // Les caractères spéciaux dont les espaces, sont remplacés par un tiret.
			$chaine = $this->formatage_nom_fichier($chaine);
			$chaine = strtolower(strip_tags($chaine)) ;
			return $chaine.'_'.$table.'-'.$id.'.html' ;
		}
		public function formatage_valideurl2($chaine) {
			$chaine         = iconv('windows-1252','UTF-8', $chaine);
			$NON_array		= array('Ã©','é','Ã¯','&amp;lt;', '&amp;gt;', '&amp;', '&quot;', '&amp;quot;', '&lt;', '&gt;' ,"'\'" , 'Ã¨','Ã´');
			$OUI_array		= array('e' ,'e','i', '&lt;'  ,'&gt;', '&', '"',  '',  '',  '',  '', 'e', 'o');
			$chaine 		= str_replace($NON_array, $OUI_array, $chaine);

			$NON_array		= array(
							'Ã','Ã¢','Ã©','Ã¨','Ãª','Ã«','Ã®','Ã¯','Ã´',
							'Ã¶','Ã¹','Ã»','Ã¼','Ã§','Å','â¬',
							'Â°','Ã','Ã','Ã','Ã','Ã','Ã','Ã',
							'Ã','Ã','Ã','Ã','Ã','Ã','Ã','Å',
							'À','Á','Â','Ã','Ä','Å','à','á','â','ã','ä','å',
							'Ò','Ó','Ô','Õ','Ö','Ø','ò','ó','ô','õ','ö','ø',
							'È','É','Ê','Ë','è','é','ê','ë'
							);

			$OUI_array		= array(
							'a','a','e','e','e','e','i','i','o',
							'o','u','u','u','c','oe','e',
							'','a','a','e','e','e','e','i',
							'i','o','o','u','u','u','c','oe',
							'a','a','a','a','a','a','a','a','a','a','a','a',
							'o','o','o','o','o','o','o','o','o','o','o','o',
							'e','e','e','e','e','e','e','e'
							);
			$chaine 		= str_replace($NON_array, $OUI_array, $chaine);

			// $chaine = strtr($chaine,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
			// Mettez ici les caractères spéciaux qui seraient susceptibles d'apparaître dans les titres. La liste ci-dessous est indicative.
			$speciau = array("?" , "!" , "@" , "#" , "%" , "&amp;" , "*" , "(" , ")" , "[" , "]" , "=" , "+" , " " , ";" , ":" , "'" , "." , "_");
			$chaine = str_replace($speciau, "", $chaine); // Suppression de tous les caractères spéciaux
			$chaine = $this->formatage_nom_fichier($chaine);
			$chaine = strtolower(strip_tags($chaine)) ;
			return $chaine ;
		} 
		public function formatage_sans_accent($chaine){
			$chaine			= utf8_decode($chaine); 			// convertit une chaîne UTF-8 en ISO-8859-1
			$chaine			= html_entity_decode($chaine); 		// convertit les entités HTML spéciales en caractères 
			$chaine 		= trim($chaine);

			$NON_array 		= array(
				'Ã©','À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ă', 'Ą',
				'Ç', 'Ć', 'Č', 'Œ',
				'Ď', 'Đ',
				'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ă', 'ą',
				'ç', 'ć', 'č', 'œ',
				'ď', 'đ',
				'È', 'É', 'Ê', 'Ë', 'Ę', 'Ě',
				'Ğ',
				'Ì', 'Í', 'Î', 'Ï', 'İ',
				'Ĺ', 'Ľ', 'Ł',
				'è', 'é', 'ê', 'ë', 'ę', 'ě',
				'ğ',
				'ì', 'í', 'î', 'ï', 'ı',
				'ĺ', 'ľ', 'ł',
				'Ñ', 'Ń', 'Ň',
				'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ő',
				'Ŕ', 'Ř',
				'Ś', 'Ş', 'Š',
				'ñ', 'ń', 'ň',
				'ò', 'ó', 'ô', 'ö', 'ø', 'ő',
				'ŕ', 'ř',
				'ś', 'ş', 'š',
				'Ţ', 'Ť',
				'Ù', 'Ú', 'Û', 'Ų', 'Ü', 'Ů', 'Ű',
				'Ý', 'ß',
				'Ź', 'Ż', 'Ž',
				'ţ', 'ť',
				'ù', 'ú', 'û', 'ų', 'ü', 'ů', 'ű',
				'ý', 'ÿ',
				'ź', 'ż', 'ž',
				'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р',
				'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'р',
				'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
				'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
			);		 
			$OUI_array = array(
				'e','A', 'A', 'A', 'A', 'A', 'A', 'AE', 'A', 'A',
				'C', 'C', 'C', 'CE',
				'D', 'D',
				'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'a', 'a',
				'c', 'c', 'c', 'ce',
				'd', 'd',
				'E', 'E', 'E', 'E', 'E', 'E',
				'G',
				'I', 'I', 'I', 'I', 'I',
				'L', 'L', 'L',
				'e', 'e', 'e', 'e', 'e', 'e',
				'g',
				'i', 'i', 'i', 'i', 'i',
				'l', 'l', 'l',
				'N', 'N', 'N',
				'O', 'O', 'O', 'O', 'O', 'O', 'O',
				'R', 'R',
				'S', 'S', 'S',
				'n', 'n', 'n',
				'o', 'o', 'o', 'o', 'o', 'o',
				'r', 'r',
				's', 's', 's',
				'T', 'T',
				'U', 'U', 'U', 'U', 'U', 'U', 'U',
				'Y', 'Y',
				'Z', 'Z', 'Z',
				't', 't',
				'u', 'u', 'u', 'u', 'u', 'u', 'u',
				'y', 'y',
				'z', 'z', 'z',
				'A', 'B', 'B', 'r', 'A', 'E', 'E', 'X', '3', 'N', 'N', 'K', 'N', 'M', 'H', 'O', 'N', 'P',
				'a', 'b', 'b', 'r', 'a', 'e', 'e', 'x', '3', 'n', 'n', 'k', 'n', 'm', 'h', 'o', 'p',
				'C', 'T', 'Y', 'O', 'X', 'U', 'u', 'W', 'W', 'b', 'b', 'b', 'E', 'O', 'R',
				'c', 't', 'y', 'o', 'x', 'u', 'u', 'w', 'w', 'b', 'b', 'b', 'e', 'o', 'r'
			);
			$chaine = str_replace($NON_array, $OUI_array, $chaine);
			return utf8_encode($chaine); // convertit une chaîne ISO-8859-1 en UTF-8
		} 
		public function formatage_nom_fichier($chaine){
			$chaine			= utf8_decode($chaine); 			// convertit une chaîne UTF-8 en ISO-8859-1
			$chaine			= html_entity_decode($chaine); 		// convertit les entités HTML spéciales en caractères 
			$chaine 		= strtolower(stripslashes(trim($chaine)));
			$chaine			= strip_tags($chaine);				// suppression de toutes les balises éventuelles
			$chaine 		= trim($chaine);
			$chaine 		= trim($chaine,'.-+"\'?!,:;#*');	// suppression des ponctuations en bout de chaine
			// -------------
			// remplacement : caractères accentués et espace
			$chaine 		= $this->formatage_sans_accent($chaine);
			// -------------
			// expression régulière qui remplace tout ce qui n'est pas une lettre non accentuées ou un chiffre par un tiret "-"
			$chaine 		= preg_replace('/([^.a-zA-Z0-9]+)/i', '-', $chaine);
			// -------------
			$NON_array		= array('&amp;', '&quot;', '&amp;quot;', '&lt;', '&gt;');
			$OUI_array		= array('&',    '',    '',    '',    '');
			$chaine 		= str_replace($NON_array, $OUI_array, $chaine);
			// -------------
			$NON_array		= array(',', ':', '!', '?', '"', '\'', '&amp;', '  ',"'");
			$OUI_array		= array('',  '',  '',  '',  '',  '',   '', ' ', "");
			$chaine 		= str_replace($NON_array, $OUI_array, $chaine);
			// -------------
			// remplacement : nettoyage final
			$NON_array		= array('----','---','--',' ','*');
			$OUI_array		= array('-',   '-',  '-', '', '');
			$chaine 		= str_replace($NON_array, $OUI_array, $chaine);
			// -------------
			// Fichier :
			// raccourcir le nom si trop long (nom 50 caracères maxi + extension 5 caracères maxi)
			$chaine 		= (strlen($chaine)>50)? substr(pathinfo($chaine,PATHINFO_FILENAME), 0, 50).'.'.substr(pathinfo($chaine,PATHINFO_EXTENSION), 0, 5) : $chaine;
			// -------------
			$chaine 		= trim($chaine, '.-');
			$chaine 		= utf8_encode($chaine); // convertit une chaîne ISO-8859-1 en UTF-8
			$chaine 		= strtolower($chaine);  // renvoie une chaine en miniscule
			return $chaine;
		}	 
		public function tronquer($mot,$max_caracteres=NULL){
			//nombre de caractères à afficher
				if($max_caracteres==NULL){$max_caracteres=30; }
			// Test si la longueur du texte dépasse la limite
				if(strlen($mot) > $max_caracteres){    
					// Séléction du maximum de caractères
					$mot = substr($mot, 0, $max_caracteres);
					// Récupération de la position du dernier espace (afin déviter de tronquer un mot)
					$position_espace = strrpos($mot, " ");    
					$mot = substr($mot, 0, $position_espace)."..." ;    
				}
			return $mot;
		}		
		public function tronque($mot,$max_caracteres=NULL){
			//nombre de caractères à afficher
			// Test si la longueur du texte dépasse la limite
			if(strlen($mot) > $max_caracteres){    
				// Séléction du maximum de caractères
				$mot = substr($mot, 0, $max_caracteres);   
			}
			return $mot;
		}	
		public function strArray($mot,$caract){
			return explode($caract, $mot);   
		}	
		public function coupe($mot,$caract){
			return explode($caract, $mot);   
		}	
		public function bcrypt($password) {
			return password_hash($password, PASSWORD_BCRYPT);
		}
		public function verifyPassword($password, $hash) {
			return password_verify($password, $hash);
		}
		public function countStringArray($mot){
			if(is_array($mot)){
				$mot = count($mot);
			}
			else{
				if(is_string($mot)){
					$mot = strlen($mot);
				}
				else{
					if(is_object($mot)){
						$mot = (array)$mot;
						$mot = count($mot);
					}
				}
			}
			return $mot;
		}
		public function tronquerlastspace($mot,$max_caracteres=NULL){
			//nombre de caractères à afficher
				if($max_caracteres==NULL){$max_caracteres=30; }
			// Test si la longueur du texte dépasse la limite
				if(strlen($mot)>$max_caracteres){    
					// Séléction du maximum de caractères
					$mot = substr($mot, 0, $max_caracteres);
					// Récupération de la position du dernier espace (afin déviter de tronquer un mot)
					$position_espace = strrpos($mot, " ");    
					$mot = substr($mot, 0, $position_espace) ;    
				}
			return $mot;
		}	
		public function removelastspace($mot){
			$lastspace = strrpos($mot, " ");    
			$mot = substr($mot, 0, $lastspace) ; 
			return trim($mot);
		}	
		public function removelastcaracteres($mot,$nbr){
			$nbr = (int)$nbr ;      
			$mot = substr($mot, 0 ,-$nbr);
			return $mot;
		}
		public function gen_tocken($mot=NULL,$min=NULL,$max=NULL){
			if($mot==NULL){$mt='';}else{$mt=$mot;}
			if($min==NULL){$min=0;} 
			if($max==NULL){$max=20;} 
			$tocken= uniqid(rand($min,$max), true);
			$tocken= strtoupper(substr(sha1(str_shuffle('nAit3ya2n1sxzt3a7o9n'.$tocken.'da8bx4m5ali6t0y'.$mt)) , $min , $max)) ;
			return $tocken;
		}
		public function uniquetocken($mot=NULL){
			if($mot==NULL){$mt='';}else{$mt=$mot;}
			$tocken= uniqid(rand(), true);
			$tocken= strtoupper(substr(sha1(str_shuffle('nAit3ya2n1sxzt3a7o9n'.$tocken.'da8bx4m5ali6t0y')) , 0 , 23)) ;
			$tocken= sha1($mot.'£'.$tocken);
			return $tocken;
		}
		public function assign_rand_value($num){
		    switch($num){
		        case "1":
		            $rand_value = "a";
		        break;
		        case "2":
		            $rand_value = "b";
		        break;
		        case "3":
		            $rand_value = "c";
		        break;
		        case "4":
		            $rand_value = "d";
		        break;
		        case "5":
		            $rand_value = "e";
		        break;
		        case "6":
		            $rand_value = "f";
		        break;
		        case "7":
		            $rand_value = "g";
		        break;
		        case "8":
		            $rand_value = "h";
		        break;
		        case "9":
		            $rand_value = "i";
		        break;
		        case "10":
		            $rand_value = "j";
		        break;
		        case "11":
		            $rand_value = "k";
		        break;
		        case "12":
		            $rand_value = "l";
		        break;
		        case "13":
		            $rand_value = "m";
		        break;
		        case "14":
		            $rand_value = "n";
		        break;
		        case "15":
		            $rand_value = "o";
		        break;
		        case "16":
		            $rand_value = "p";
		        break;
		        case "17":
		            $rand_value = "q";
		        break;
		        case "18":
		            $rand_value = "r";
		        break;
		        case "19":
		            $rand_value = "s";
		        break;
		        case "20":
		            $rand_value = "t";
		        break;
		        case "21":
		            $rand_value = "u";
		        break;
		        case "22":
		            $rand_value = "v";
		        break;
		        case "23":
		            $rand_value = "w";
		        break;
		        case "24":
		            $rand_value = "x";
		        break;
		        case "25":
		            $rand_value = "y";
		        break;
		        case "26":
		            $rand_value = "z";
		        break;
		        case "27":
		            $rand_value = "0";
		        break;
		        case "28":
		            $rand_value = "1";
		        break;
		        case "29":
		            $rand_value = "2";
		        break;
		        case "30":
		            $rand_value = "3";
		        break;
		        case "31":
		            $rand_value = "4";
		        break;
		        case "32":
		            $rand_value = "5";
		        break;
		        case "33":
		            $rand_value = "6";
		        break;
		        case "34":
		            $rand_value = "7";
		        break;
		        case "35":
		            $rand_value = "8";
		        break;
		        case "36":
		            $rand_value = "9";
		        break;
		    }
		    return $rand_value;
		}
		public function generate_password($length,$mot=NULL){
		    if($length > 0){
		    	if($mot==NULL){$mt='';}else{$mt=$mot;}
		        $rand_id="";
		        for($i=1; $i<=$length; $i++){
		            // mt_srand((double)microtime() * 1000000);
		            $num = mt_rand(1,36);
		            $rand_id .= base64_encode(str_shuffle(md5(sha1($this->assign_rand_value($num).$mt)))) ;
		        }
		    }
		    return substr( $rand_id , 0, $length) ;
		}
		public function generateCrypt($mot,$crypt){ 
			$_crypt = ($crypt=='md5') ? md5($mot) : sha1($mot);
		    return $_crypt;
		} 
		public function genRandom($length,$mot=NULL) {
			$newlicence = "";
			$num   = array ('1', '2', '3', '4', '5', '6', '7', '8', '9');   
			$alpha = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I','J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
			$code  = array (); 
			$tocken=$this->gen_tocken($mot, 0, $length*2);  
			if($mot==NULL){
				$pwd=$this->generate_password($length) ;
			}
			else{
				$pwd=$this->generate_password($length,$mot) ;
			}

			foreach ($num as $x) {
			    foreach($alpha as $y){   
			        array_push($code,"$y");   
			        array_push($code,"$x");
				}
			}
			for($i=0;$i<=$length;$i++){$newlicence= $newlicence.$code[array_rand($code) ];}

			$newlicence=$tocken.$newlicence.$pwd;
			$newlicence=$this->tronque($newlicence,$length) ; 
			return $newlicence; 
		}
		public function genRandomUID($length = 10){
			if($length < 1){ $length = 1; }
			$newgenerateID = $this->minuscule($this->genRandom($length));
			return substr(preg_replace("/[^A-Za-z0-9]/", '', base64_encode(openssl_random_pseudo_bytes($length * 2)).$newgenerateID ), 0, $length);
		}
		public function genRandomString($total) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $total; $i++) {
				$index = rand(0, strlen($characters) - 1);
				$randomString .= $characters[$index];
			}
			$char = $this->genRandom($total);
			return $randomString;
		}
		public function genRandomNumber($total){ 
			$number = rand(0,999999);
			$number = str_split($number, $total)[0]; 
			return $number;
		}  
		public function generateRandom($min = 1, $max = 20) {
			if (function_exists('random_int')):
				return random_int($min, $max); // more secure
			elseif (function_exists('mt_rand')):
				return mt_rand($min, $max); // faster
			endif;
			return rand($min, $max); // old
		}
		public function minuscule($mot){
			if(gettype($mot) == 'string'){
				$mot = strtolower($mot);
			}
			return $mot;
		}
		public function generateID($length=null){
			if($length==null){$length = 30;}
			$newgenerateID = $this->genRandomUID($length);
			$newgenerateID =$this->tronque($newgenerateID,$length) ;
			return $newgenerateID;
		} 
		public function generateUIID($length=null) {
			$data = random_bytes($length ?? 16);
			$data[6] = chr(ord($data[6]) & 0x0f | 0x40); // version 4
			$data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variant
			return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
		}
		public function convertToMo($number){
			return ($number / 1048576);
		}
		public function sizeFilter( $bytes ){
			$label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
			for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
			return( round( $bytes, 2 ) . " " . $label[$i] );
		}
	}