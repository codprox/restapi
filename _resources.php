<?php
    /**
     * 
     */
    switch ($collection) {
        case 'users':
            if($action=='list'){
                $_arr = [];
                foreach ($_find as $key => $value) {
                    $_item = new UsersResource($value);
                    $_arr[$key] = $_item->toArray();
                }
                $_find = $_arr;
            }
            else{
                if(count($_find)>0){
                    $_item = new UsersResource($_find[0]);
                    $_find = $_item->toArray();
                }
            }
            break;
        
        default:
            if($action=='list'){
                $_arr = [];
                foreach ($_find as $key => $value) {
                    $_item = new SingleResource($value);
                    $_arr[$key] = $_item->toArray();
                }
                $_find = $_arr;
            }
            else{
                if(count($_find)>0){
                    $_item = new SingleResource($_find[0]);
                    $_find = $_item->toArray();
                } 
            }
            break;
    }