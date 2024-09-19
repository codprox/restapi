<?php
    /**
     * 
     * */ 
    class _MyFiles{
		private $attributs = [];
        public function __construct($init=null){ 
			if($init !=null && is_array($init)){
				foreach($init as $key => $value){
					$el = '_'.$key;
					$this->attributs[$el] = $value;
				}
			}
        }  
		public function __get($key){
			$el = '_'.$key;
			return (isset($this->attributs[$el])) ? $this->attributs[$el] : null;
		} 
		public function __set($key,$value){
			$el = '_'.$key;
			return $this->attributs[$el] = $value;
		} 
        public function parseData($data){
            if (is_null($data)) return [];

            $data = json_decode($data, true);
            if (json_last_error() != JSON_ERROR_NONE) return [];

            return $data;
        } 
        public function realPathFile($jsonFileroot, $online=null){
            $existExt = $this->__extensionFile($jsonFileroot, '.');
            if(!isset($existExt) || empty($existExt)){ $jsonFileroot = $jsonFileroot.'.json'; }

            if (is_null($jsonFileroot)) {
                return array('error'=>1, 'message'=>'path is null !');
            }
            else{ 
                if($online!=null){
                    if (filter_var($jsonFileroot, FILTER_VALIDATE_URL)) {
                        return $jsonFileroot;
                    }
                }
                else{
                    if(!file_exists($jsonFileroot)){   
                        return array('error'=>1, 'message'=>'path not exist !');
                    }
                    return $jsonFileroot;
                }
            }
        }
        public function createEmpty($jsonFile, $local=null){
            $existExt = $this->__extensionFile($jsonFile, '.');
            if(!isset($existExt) || empty($existExt)){ $jsonFile = $jsonFile.'.json'; }

            if (is_null($jsonFile)) {
                return array('error'=>1, 'message'=>'path is null !');
            }

            $_data = [];
            if($local !=null){
                // 
            }
            else{
                if (!file_exists($jsonFile)) {
                    $this->__createfile($jsonFile);
                }
            }
            return $jsonFile;
        }
        public function deleteFolder($dir) {
            if (!file_exists($dir)) { return false; }
            if (!is_dir($dir)) { return unlink($dir); }
        
            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..') {
                    continue;
                }
                if (!$this->deleteFolder($dir . DIRECTORY_SEPARATOR . $item)) {
                    return false;
                }
            }
            return rmdir($dir);
        } 
        public function createFolder($folder){
            return $this->__createfolderproject($folder);
        }
        public function read($file, $local=null){
            $existExt = $this->__extensionFile($file, '.');
            if(!isset($existExt) || empty($existExt)){ $file = $file.'.json'; }

            if (is_null($file)) {
                return array('error'=>1, 'message'=>'path is null !');
            }

            $_data = null;
            if($local!=null){
                if (filter_var($file, FILTER_VALIDATE_URL)) {
                    $_data = file_get_contents($file);
                }
            }
            else{
                if (file_exists($file)) { 
                    $_data = file_get_contents($file);
                }
            }

            if (is_null($_data)){ 
                return array('error'=>1, 'message'=>'Data empty !');
            }

            $data = json_decode($_data, true);
            if (json_last_error() !== JSON_ERROR_NONE){ 
                return array('error'=>1, 'message'=>'invalid '.$existExt.' format !');
            }

            return $data;
        }
        public function write($data, $file){
            $this->__writeInFile($data,$file);
        }
        public function download($url,$name,$file=null){ 
            if($file==null){
                // $data = file_get_contents($url);
                // file_put_contents($name, $data);
                @copy($url, $name);
                
                // $in = fopen($url, "rb");
                // $out= fopen($name, "wb");
                // while ($chunk = fread($in,8192)){
                //     fwrite($out, $chunk, 8192);
                // }
                // fclose($in);
                // fclose($out);
            }
            else{
                @copy($url, $name);
            }
            
            // $data = $this->__curl($url,$name);
            // if($data === false) {
            //     $name = '';
            // } else { 
            //     file_put_contents($name, $data);
            // }  
            return $name;
        }
        public function delete($file){
            $this->__deletefile($file);
        }
        public function exist($file){
            return $this->__existsFile($file);
        }
        public function extension($file){
            return $this->__extensionFile($file);
        }
        public function modFiles($dir,$thr=null) { 
            return $this->__modifiedfiles($dir,$thr);
        } 
        public function analyse($dir=null){
            $dir = ($dir!=null)? $dir : '/';
            $_arrFiles = $this->modFiles($dir);
            // Envoyer l'email si des fichiers ont été modifiés
            if (!empty($_arrFiles)) {
                $message = "Les fichiers suivants ont été modifiés :\n\n";
                foreach ($_arrFiles as $key => $value) {
                    $message .= $value['file']." (Durée: ".$value['durer']." / Date: ".$value['date'].")\n" ;
                }
                $message ."\n\n";
                return $message;
            }else{
                return false;
            }
        } 
        public function uploadFile($folder,$file,$filename=null) {
            // Vérifier si le dossier existe, sinon le créer
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }
        
            // Obtenir les informations du fichier
            $fileName = $filename ?? basename($file["name"]);
            $targetFilePath = $folder . $fileName;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        
            // Définir les types de fichiers autorisés
            $allowedTypes = $this->__get('validExtens');
        
            // Vérifier si le type de fichier est autorisé
            if (in_array($fileType, $allowedTypes)) {
                // Vérifier s'il n'y a pas d'erreur lors de l'upload
                if ($file["error"] == 0) {
                    // Déplacer le fichier vers le dossier de destination
                    if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                        return array('success'=>true, 'path'=>$targetFilePath);
                    } else {
                        return array('success'=>false, 'message'=>'Erreur lors du téléchargement du fichier');
                    }
                } else { 
                    return array('success'=>false, 'message'=>$file["error"]);
                }
            } else {
                return array('success'=>false, 'message'=>'Type de fichier non autorisé. Voici les types acceptés : '.implode(',',$allowedTypes));
            }
        } 
        // 
        protected function __curl($url,$path) { 
            // $ch = curl_init(); 
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // $data = curl_exec($ch);
            // curl_close($ch);
            // return $data; 
            
            $ch = curl_init($url);
            $fp = fopen($path, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
        } 
        protected function __extensionFile($file){
            // $path      = pathinfo($file);
            // $extension = isset($path['extension']) ? $path['extension'] : null; 
            return strtolower(pathinfo($file, PATHINFO_EXTENSION));
        }
        protected function __existsFile($file){  
            return (file_exists($file))? true: false;
        }
        protected function __movesFile($oldfile,$newfile){ 
            $txt = '';
            $this->__deletefile($newfile);
            
            if(move_uploaded_file($oldfile, $newfile)){
                @chmod($newfile, 0777);
                $txt = $newfile;
            } 
            return $txt;
        }
        protected function __renameFile($oldfile,$newfile){ 
            $txt = '';
            if($this->__existsFile($oldfile)){
                if(rename($oldfile, $newfile)){
                    @chmod($newfile, 0777);
                    $txt = $newfile;
                } 
            }
            return $txt;
        }
        protected function __readExists($file){
            $txt= [];
            if(file_exists($file)){
                $txt = file_get_contents($file);
                $txt = json_decode($txt, true);
            }
            return $txt;
        }
        protected function __close($file){
            $existExt = $this->__extensionFile($file, '.');
            if(!isset($existExt) || empty($existExt)){ $file = $file.'.json'; }

            if ( $file && is_resource( $file ) ) {
                fclose( $file );
            }
        } 
        protected function __writeInFile($data, $file){
            $existExt = $this->__extensionFile($file, '.');
            if(!isset($existExt) || empty($existExt)){ $file = $file.'.json'; }

            $datas = json_encode($data,JSON_PRETTY_PRINT) ;
            file_put_contents($file, $datas);
            $this->__close($file);
        } 
        protected function __deletefile($file){
            if(file_exists($file)){
                @unlink($file);
            }
        } 
        protected function __createfile($file){
            $existExt = $this->__extensionFile($file, '.');
            if(!isset($existExt) || empty($existExt)){ $file = $file.'.json'; }

            if (!file_exists($file)) {
                touch($file);
            }
        }
        protected function __createfolderproject($folder){
            if(!file_exists($folder)){ 
                @mkdir($folder, 0777, true); 
                return $folder.'/' ;
            }else{
                return $folder.'/' ;
            }
        }
        protected function __modifiedfiles($dir,$thr=null){
            $listFiles = [];
            $threshold = ($thr==null)? strtotime('-1 day') : strtotime($thr);
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
            foreach ($files as $file) {
                if ($file->isFile() && filemtime($file) > $threshold) {
                    $listFiles[] = array('path'=>$file->getRealPath(),'durer'=>filemtime($file),'date'=>date('F d Y H:i:s', filemtime($file)));
                }
            }
            return $listFiles;
        }  
        protected function __changemod($file){
            $res=false;
            if(chmod($file, 0777)){
                $res = true;
            }
            return $res;
        } 
        protected function __scanFilesInFolder($directory,$extension=null,$namefile=null){
            $directory    = $directory ;
            $foldersarray = [];
            $fols = array_diff(scandir($directory), array('..', '.'));
            $i = 0;
            foreach($fols as $key=>$value){
                if($extension !=null){
                    // alors, il veut un type de fichier
                    $cp = explode('.', $value);
                    if( $cp[(count($cp)-1)] == $extension){
                        if($namefile !=null){
                            if($value == $namefile){
                                $foldersarray = $value;
                            } 
                        }
                        else{
                            $foldersarray[$i] = $value ;
                        }
                    }
                }
                else{
                    // il veut tous les fichiers
                    if($namefile !=null){
                        if($value == $namefile){
                            $foldersarray = $value;
                        } 
                    }
                    else{
                        $foldersarray[$i] = $value ;
                    }
                }
                $i++; 
            }
            return $foldersarray;
        }
        protected function scanFolders($directory){
            $foldersarray = [];
            $fols = array_diff(scandir($directory), array('..', '.'));
            $i    = 0;
            foreach($fols as $key=>$value){
                $file = $directory .'/'. $value ;
                if(is_dir($file)){
                    $foldersarray[$i] = $value ;
                    $i++;
                }
            }
            return $foldersarray;
        }
        protected function is_empty_dir($directory){
            if (is_dir($directory)){
                $objects = scandir($directory);
                foreach ($objects as $object){
                    if ($object != "." && $object != ".."){
                        if (filetype($directory."/".$object) == "dir"){
                            return false;
                        }else { 
                            return false;
                        }
                    }
                }
                reset($objects);
                return true;
            }
        }
        protected function removeDirectory($path){
            if($this->is_empty_dir($path)){
                rmdir($path);
            }
        }
    } 

    