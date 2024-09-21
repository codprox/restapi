<?php
    /**
     * ALL JSON ACTIONS
     */
    global $_func;
    global $_myfile;
    global $_mydates;
    global $_httpRes;

    $_baseFile = $collection.'.json';
    if($_token == $_serverToken){
        $_initFold = $_baseFolder ; 
    }
    else{
        $_initFold = $_myfile->createFolder($_baseFolder.$_token); 
    }
    $_file = $_initFold.$_baseFile; 
      
    switch ($_method) {
        case 'GET':
            try {  
                if(!_exist($_file) && $local==null){
                    $response = array('success'=>false,'data'=> [], 'message'=> "Collection inexistante.");
                    $res = $_httpRes->__response($response); 
                    if($collection=='profile'){
                        $_find = profileJWT($_token,$_baseFolder);
                        $response = array('success'=>true,'data'=>$_find);
                        $res = $_httpRes->__response($response);
                    }
                }   
                else{
                    if($action=='list'){
                        if($collection=='profile'){
                            $_find = profileJWT($_token,$_baseFolder);
                        }
                        else{
                            if(count($_params)==0){
                                $_find = _getAll($_file);
                            }
                            else{
                                $_find = _getAll($_file,$_params);
                            }
                        }
                        $response = array('success'=>true,'data'=>$_find);
                        $res = $_httpRes->__response($response);
                    }
                    else{
                        if($id !=null){ 
                            $join = null;
                            if(count($_params)>0){
                                $join = $_params['join'] ?? null; 
                            }
                            $_find = _get($_file,$id,null,$join);
                            $response = array('success'=>true,'data'=>$_find);
                            $res = $_httpRes->__response($response);
                        }else{
                            $response = array('success'=>false,'data'=>[],'message'=>$_httpRes->__get(400).' : ID vide !');
                            $res = $_httpRes->__response($response);
                        }
                    }
                }
                echo $_myall->__toJson($res);  
            } catch (Exception $e) {
                $response = array('success'=>false,'data'=>[], 'message'=>$e->getMessage());
                $res = $_httpRes->__response($response); 
                echo $_myall->__toJson($res);  
            }
            break; 
        case 'POST':
            if(isset($_FILES) && count($_FILES)>0){
                $data = $_POST;
            }else{
                $data = $_myall->mobilePost(); 
                $data = $_myall->__toArray($data);
            }

            $_c = explode('/',$_uriSVR)[2];
            if($_c =='login' || $_c=='logout'){
                if($_c=='login'){
                    // LOGIN operation 
                    try { 
                        $_file = $_initFold.$_accountsFiles; 
                        $_find = _login($_file,$data);
                        $response = array('success'=>true,'data'=>$_find);
                        $res = $_httpRes->__response($response);
                        echo $_myall->__toJson($res);  
                    } catch (Exception $e) {
                        $response = array('success'=>false,'data'=>[],'message'=>$e->getMessage());
                        $res = $_httpRes->__response($response); 
                        echo $_myall->__toJson($res);  
                    }
                }else{
                    // LOGOUT operation 
                    $response = array('success'=>true,'data'=>[]);
                    $res = $_httpRes->__response($response);
                    echo $_myall->__toJson($res); 
                }
            }
            else{
                try {  
                    if($collection=='profile'){
                        $_file= $_baseFolder.$_accountsFiles;  
                        $_inst= new UsersResource($data);
                        $data = $_inst->createAccount();
                    } 

                    $_find = _create($_file,$data);
                    // if(isset($_find['password'])){unset($_find['password']);}

                    $response = array('success'=>true,'data'=>$_find);
                    $res   = $_httpRes->__response($response);
                    echo $_myall->__toJson($res);  
                } catch (Exception $e) {
                    $response = array('success'=>false,'data'=>[],'message'=>$e->getMessage());
                    $res = $_httpRes->__response($response); 
                    echo $_myall->__toJson($res);  
                }
            }
            break; 
        case 'PUT':
            try { 
                if($collection=='profile'){ $_file= $_baseFolder.$_accountsFiles; } 

                if(!_exist($_file)){
                    $response = array('success'=>false,'data'=>[],'message'=>"Collection inexistante..");
                } 
                else{
                    if($id !=null){
                        $data = $_myall->mobilePost(); 
                        $data = $_myall->__toArray($data);
                            
                        if($collection=='profile'){
                            $_file= $_baseFolder.$_accountsFiles;    
                            $_inst= new UsersResource($data);
                            $data = $_inst->updateAccount(); 
                        }  

                        $_find = _update($_file,$_indexKey,$id,$data);
                        $response = array('success'=>true,'data'=>[],'message'=>'Mise à jour effectuée avec succès!');
                    }
                    else{
                        $response = array('success'=>false,'data'=>[],'message'=>$_httpRes->__get(400).' : ID vide !');
                    } 
                }
                $res = $_httpRes->__response($response);
                echo $_myall->__toJson($res);  
            } catch (Exception $e) {
                $response = array('success'=>false,'data'=>[],'message'=>$e->getMessage());
                $res = $_httpRes->__response($response); 
                echo $_myall->__toJson($res);  
            }
            break; 
        case 'DELETE':
            if($action=='delete_all'){
                try {   
                    $items = _getAll($_file); 
                    $_find = _deleteAll($_file);
                    $response = array('success'=>true,'data'=>[],'message'=>'Liste supprimée avec succès!');
                    $res = $_httpRes->__response($response);
                    echo $_myall->__toJson($res);  
                } catch (Exception $e) {
                    $response = array('success'=>false,'data'=>[],'message'=>$e->getMessage());
                    $res = $_httpRes->__response($response); 
                    echo $_myall->__toJson($res);  
                }
            }
            else{
                try { 
                    if($id !=null){
                        if($collection=='profile'){
                            $_file = $_baseFolder.$_accountsFiles; 
                            // on supprime son dossier local 
                            $_jsondb = new JsonCRUD($_file);
                            $where = array($_indexKey =>$id);
                            $_find = $_jsondb->find($where);
                            if(is_array($_find)){
                                $_myfile->deleteFolder($_baseFolder.$_find[0]->$_titleToken); 
                            }
                        } 
                        $_find = _delete($_file,$_indexKey,$id);

                        $response = array('success'=>true,'data'=>[],'message'=>'Supprimer avec succès!');
                        $res = $_httpRes->__response($response);
                    }else{
                        $response = array('success'=>false,'data'=>[],'message'=>$_httpRes->__get(400).' : ID vide !');
                        $res = $_httpRes->__response($response);
                    }  
                    echo $_myall->__toJson($res);  
                } catch (Exception $e) {
                    $response = array('success'=>false,'data'=>[],'message'=>$e->getMessage());
                    $res = $_httpRes->__response($response); 
                    echo $_myall->__toJson($res);  
                }
            } 
            break;  
        default:
            $response = array('success'=>false,'data'=>[],'message'=>$_httpRes->__get(400));
            $res = $_httpRes->__response($response);
            echo $_myall->__toJson($res); 
            break;
    }
