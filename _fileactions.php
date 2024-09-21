<?php
    /**
     * 
     */

	function _getLast($file,$index){
		$_jsondb = new JsonCRUD($file);
        $_find = 1;
        $res = $_jsondb->getLast($index); 
        if($res !=null){ 
            $_find = $res+1; 
        }  
		return $_find;
	}
	function _getTotal($file){
		$_jsondb = new JsonCRUD($file);
        $_find = [];
        $res = $_jsondb->read(); 
        if(!is_array($res)){ 
            $_find = $res->data; 
        }  
		return count($_find);
	}
	function _exist($file){
		$_jsondb = new JsonCRUD($file); 
		return $_jsondb->exist();
	}
    function joinTable($value,$v){
        global $_myfile;
        global $_indexKey;
        global $_baseFolder;
        global $_token;
        $_baseFolderFichier = $_myfile->createFolder($_baseFolder.$_token);
        
        $key   = $v.'_id'; // "categories_id" - "souscategories_id" 
        $k     = $value->$key;
        if($k==0){
            return null;
        }
        $_file = $_baseFolderFichier.$v.'.json'; 
        if(_exist($_file)){
            $dt= _get($_file,$k,$_indexKey);
        }
        return $dt;
    }
    function traiteFichiers($value){
        global $_token; 
        global $_myfile; 
        global $_baseUrl; 
        global $_stockage; 
        global $_baseFolder; 
        $_initFold = $_myfile->createFolder($_baseFolder.$_token.'/files'); 

        if((isset($value->picture) && !empty($value->picture))){
            // Picture
            if($_stockage !='local'){
                if(is_array($value->picture)){
                    foreach ($value->picture as $k => $v) { 
                        if(!isset($v->webViewLink)){
                            $value->picture[$k] = getInfoGoogleDrive($v->id);
                        }
                    }
                }
                else{
                    if(!isset($value->picture->webViewLink)){
                        $value->picture = getInfoGoogleDrive($value->picture->id);
                    }
                }
            }
            else{
                if(is_array($value->picture)){
                    foreach ($value->picture as $k => $v) {
                        $value->picture[$k] = $_baseUrl.'/'.$_initFold.$v ;
                    }
                }
                else{
                    $value->picture = $_baseUrl.'/'.$_initFold.$value->picture ;
                }
            }
        }
        if((isset($value->file) && !empty($value->file))){
            // File
            if($_stockage !='local'){
                if(is_array($value->file)){
                    foreach ($value->file as $k => $v) { 
                        if(!isset($v->webViewLink)){
                            $value->file[$k] = getInfoGoogleDrive($v->id);
                        }
                    }
                }
                else{
                    if(!isset($value->file->webViewLink)){
                        $value->file = getInfoGoogleDrive($value->file->id);
                    }
                }
            }
            else{
                if(is_array($value->file)){
                    foreach ($value->file as $k => $v) {
                        $value->file[$k] = $_baseUrl.'/'.$_initFold.$v ;
                    }
                }
                else{
                    $value->file = $_baseUrl.'/'.$_initFold.$value->file ;
                }
            } 
        }
        return $value;
    }
	function _getAll($file,$param=null){
        global $_page;
        global $_limit; 
        $_find = [];

        // 1.  Get local datas
        $_jsondb = new JsonCRUD($file);
        $res = $_jsondb->read(); 
        foreach ($res->data as $key => $value) { 
            $_find[] = $value;  
        }

        if ($param != null && is_array($param)) {
            $_res = [];
            // Récupérer les paramètres de pagination
            $page = isset($param['page']) ? (int)$param['page'] : $_page;
            $limit= isset($param['limit'])? (int)$param['limit']: $_limit;
            unset($param['limit']); unset($param['page']); 
            $offset= ($page - 1) * $limit;
            $join  = $param['join'] ?? null; 
            if(isset($param['join'])){unset($param['join']); }

            if(count($param)==0){
                $_find = array_slice($_find, $offset, $limit);
            }
            else{
                foreach ($_find as $value) {
                    $match = true;
                    foreach ($param as $k => $v) {
                        if (!isset($value->$k) || $value->$k != $v) {
                            $match = false;
                            break;
                        }
                    }
                    if ($match) {
                        $_res[] = $value;
                    }
                }
                $_find = array_slice($_res, $offset, $limit);
            }

            // sous-table
            if($join!=null){
                $cjoin = explode(',',$join);
                foreach ($_find as $key => $value) {
                    foreach ($cjoin as $k => $v) {
                        $jon = joinTable($value,$v);
                        if($jon !=null){
                            $value->$v = $jon; 
                        }
                    }
                }
            }
        }
        else{
            // Récupérer les paramètres de pagination
            $page  = $_page;
            $limit = $_limit;
            $offset= ($page - 1) * $limit;
            $_find = array_slice($_find, $offset, $limit);
        }
            
		return $_find;
	}
	function _get($file,$id,$_key=null,$join=null){
        global $_indexKey;
		$_jsondb = new JsonCRUD($file);
        $_find = (object)[];
        $res = $_jsondb->read(); 

        foreach ($res->data as $key => $value) { 
            $k = $_key ?? $_indexKey;
            if(!isset($value->$k)){ $k='id'; }

            if(is_string($value->$k)){
                if($value->$k === $id){ 
                    $_find = $value;  
                    break;
                }
            }
            else{
                if($value->$k == $id){ 
                    $_find = $value;  
                    break;
                }
            }
        } 

        // sous-table
        if($join!=null){
            $cjoin = explode(',',$join);
            foreach ($cjoin as $k => $v) {
                $jon = joinTable($_find,$v);
                if($jon !=null){
                    $_find->$v = $jon; 
                }
            } 
        }
		return $_find;
	}
	function _save($file,$data){
		$_jsondb = new JsonCRUD($file);
        $res = $_jsondb->create($data); 
		return $res;
	}
	function _create($file,$record){
		global $_func;
		global $_mydates;
		global $_indexKey;
		$_jsondb = new JsonCRUD($file);
        
        if(!isset($record[$_indexKey])){ 
            $indexs = [$_indexKey => _getLast($file,$_indexKey), '_id' => $_func->generateID(24)];
            $record = array_merge($indexs, $record);
        }

        if(!isset($record['created_at'])){ 
            $record['created_at'] = $_mydates->DateTimeDefault();
        }

        $res = $_jsondb->create($record); 
		return $res;
	}
	function _update($file,$key,$id,$record){
		global $_mydates;
		$_jsondb = new JsonCRUD($file); 
 
        $record['updated_at'] = $_mydates->DateTimeDefault();
        $res = $_jsondb->update($key,$id,$record); 
		return $res;
	}
	function _delete($file,$key,$id){
		$_jsondb = new JsonCRUD($file);
        $res = $_jsondb->delete($key,$id); 
		return $res;
	}
	function _deleteAll($file){
		$_jsondb = new JsonCRUD($file);
        $res = $_jsondb->deleteAll(); 
		return $res;
	}
	function _login($file,$data){
		global $_func;
		global $_mymail;
		global $_myfile;
		global $_mydates;
		global $_indexKey;
        global $_titleToken;  
        global $_baseFolder;  
		$_jsondb = new JsonCRUD($file); 
        $identifiant = ($_mymail->isMail($data['login'])) ? 'email' : 'telephone';
        $where = array($identifiant =>$data['login']);
        $_find = $_jsondb->find($where); 
        
        if(!$_find){
            throw new Exception("Utisateur inconnu. Rééssayez!");
        }
        else{ 
            $verifPass = $_func->verifyPassword($data['password'], $_find[0]->password); 
            if($verifPass){
                if($_find[0]->isActive){
                    if($_mydates->compare($_find[0]->expire_account) !='-1'){
                        unset($_find[0]->password); 
                        return $_find[0];
                    }
                    else{
                        $id = $_find[0]->$_indexKey; 
                        // on le supprime de la base des utilisateurs
                        $_jsondb->delete($_indexKey,$id);
                        // on supprime son dossier de stockage local 
                        $_myfile->deleteFolder($_baseFolder.$_find[0]->$_titleToken); 
                        throw new Exception("Votre compte est expiré !");
                    }
                } 
                else{
                    throw new Exception("Votre compte est automatiquement désactivé. Contactez un Administrateur !");
                }
            }
            else{
                throw new Exception("Identifiants incorrects. Rééssayez!");
            }
        } 
	}
	function verifyJWT($token,$folder){
        global $_mydates; 
        global $_titleToken;  
        global $_accountsFiles;  
        $_find = false;
        
        $_file = $folder.$_accountsFiles;
        $_jsondb = new JsonCRUD($_file);
        $res = $_jsondb->read();  
            
        foreach ($res->data as $key => $value) { 
            if($value->$_titleToken == $token){
                // vérifier si son compte est actif
                if(($value->isActive) && ($_mydates->compare($value->expire_account) !='-1')){
                    // le compte est actif et la date d'expiration n'est pas encore atteinte
                    $_find = true;  
                    break;
                } 
            }
        } 
		return $_find;
	}
	function profileJWT($token,$folder){
        global $_titleToken; 
        global $_accountsFiles; 
        $_find = false;

        $_file = $folder.$_accountsFiles;
        $_jsondb = new JsonCRUD($_file);
        $res = $_jsondb->read();  
        
        foreach ($res->data as $key => $value) { 
            if($value->$_titleToken==$token){ 
                if(isset($value->password)){unset($value->password); }
                $_find = $value;
                break;
            }
        }
		return $_find;
	} 