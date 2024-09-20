<?php

class UsersResource {
    protected $item;

    public function __construct($item) {
        $this->item = $item;
    }

    public function toArray() {
        $arr = [
            'id' => $this->item['id'],
            'title' => $this->item['title'],
            'categories_id' => $this->item['categories_id'],
        ];

        // if(isset($this->item['categories'])){
        //     $arr['categorie'] = $this->item['categories'];
        //     unset($arr['categories_id']);
        // }  
        return $arr;
    }
    
    /**
     * @OA\Post(
     *     path="/rqXJ28773mJsau3D8EzzjCT3m4GrKi42YLD33Ab4/profile",
     *     summary="Crée un nouveau profil utilisateur",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="email", type="string"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Profil créé avec succès")
     * )
     */
    public function createAccount(){
        global $_func;
        global $_mydates;
        global $_titleToken;
        global $_iscryptPSW; 
        global $_defaultActive;
        global $_expireAccount; 
         
		if(!isset($this->item[$_titleToken])){
			$this->item[$_titleToken] = $_func->generateUIID();
		}
        if(($_iscryptPSW) && isset($this->item['password'])){ 
            $this->item['password'] = $_func->bcrypt($this->item['password']); 
        }
		if(!isset($this->item['isActive'])){
			$this->item['isActive'] = $_defaultActive;
		}
		if(!isset($this->item['expire_account'])){
			$this->item['expire_account'] = $_mydates->addDate($_expireAccount,'day','Y-m-d H:i:s');
		} 
        
        return $this->item;
    }
}
