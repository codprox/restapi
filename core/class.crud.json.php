<?php
    /**
     * CRUD JSON FILE
     */
    class JsonCRUD{
        private $file;

        public function __construct($file)
        {
            $this->file = $file;
        } 
        private function _getData()
        {
            if(!file_exists($this->file)){
                return [];
            }
            $json = file_get_contents($this->file);
            return json_decode($json);
        }
        private function _saveData($data)
        {
            $json = json_encode($data, JSON_PRETTY_PRINT);
            $res  = file_put_contents($this->file,$json);
            if($res === false){
                throw new Exception("Erreur lors de l'enregistrement des données.");
            }
            return $res;
        }

        public function exist()
        {
            if(file_exists($this->file)){
                return true;
            }else{
                return false;
            }
        }
        public function getMax($field)
        {
            $max  = null;
            $res  = $this->_getData();
            if(isset($res->data) && count($res->data)>0){
                foreach ($res->data as $item) {
                    if(isset($item->$field)){
                        if ($max === null || $item->$field > $max) {
                            $max = $item->$field;
                        }
                    }
                }
            }
            return $max;
        }
        public function getMin($field)
        {
            $min  = null;
            $res  = $this->_getData();
            if(isset($res->data) && count($res->data)>0){
                foreach ($res->data as $item) {
                    if(isset($item->$field)){
                        if ($min === null || $item->$field < $min) {
                            $min = $item->$field;
                        }
                    }
                }
            }
            return $min;
        }
        public function getSum($field)
        {
            $sum  = 0;
            $res  = $this->_getData();
            if(isset($res->data) && count($res->data)>0){
                foreach ($res->data as $item) {
                    if(isset($item->$field)){
                        $sum += $item->$field;
                    }
                }
            }
            return $sum;
        }
        public function getDistinct($field)
        {
            $distinct = []; 
            $res  = $this->_getData();
            if(isset($res->data) && count($res->data)>0){
                foreach ($res->data as $item) {
                    if(isset($item->$field)){
                        if (!in_array($item->$field, $distinct)) {
                            $distinct[] = $item->$field;
                        }
                    }
                }
            }
            return $distinct;
        }
        public function getLast($field)
        {
            $last = null; 
            $res  = $this->_getData();
            if(isset($res->data) && count($res->data)>0){
                $res = end($res->data);
                if(isset($res->$field)){
                    $last = $res->$field;
                }
            }
            return $last;
        }
        public function where($array, $conditions) 
        {
            // $conditions = [ 'age' => ['>', 25], 'salary' => 7000 ];
            $result = [];
            $res  = $this->_getData();
            if(isset($res->data) && count($res->data)>0){
                foreach ($array as $item) {
                    $match = true;
                    foreach ($conditions as $field => $condition) {
                        if (is_array($condition)) {
                            $operator = $condition[0];
                            $value = $condition[1];
                            switch ($operator) {
                                case '>':
                                    if (!($item->$field > $value)) $match = false;
                                    break;
                                case '<':
                                    if (!($item->$field < $value)) $match = false;
                                    break;
                                case '>=':
                                    if (!($item->$field >= $value)) $match = false;
                                    break;
                                case '<=':
                                    if (!($item->$field <= $value)) $match = false;
                                    break;
                                case '!=':
                                    if (!($item->$field != $value)) $match = false;
                                    break;
                                case '=':
                                default:
                                    if (!($item->$field == $value)) $match = false;
                                    break;
                            }
                        } else {
                            if ($item->$field != $condition) $match = false;
                        }
                    }
                    if ($match) {
                        $result[] = $item;
                    }
                }
            }
            return $result;
        }        
        public function joinArrays($array1, $array2, $field) 
        {
            $result = [];
            foreach ($array1 as $item1) {
                foreach ($array2 as $item2) {
                    if ($item1[$field] == $item2[$field]) {
                        $result[] = array_merge($item1, $item2);
                    }
                }
            }
            return $result;
        }

        /** F = Methode FIND */
        public function find($where) 
        {
            $res = $this->_getData();
            $fil = array_filter($res->data, function($item) use ($where) {
                foreach ($where as $key => $value) {
                    if (isset($item->$key) && $item->$key == $value) {
                        return $value;
                    }
                }
                return false;
            });
            return $fil;
        }
        /** C = Method CREATE */
        public function create($record)
        {
            $data = $this->_getData();
            if(is_array($data)){
                $data['data'][] = $record;
            }
            else{
                $data->data[] = $record; 
            } 
            $res = $this->_saveData($data);

            if($res){
                return $record;
            }
            return $res;
        }
        /** R = Method READ */
        public function read()
        {
            return $this->_getData();
        }
        /** U = Method UPDATE */
        public function update($key,$index,$newRecord)
        {
            $find = false;
            $newRecord = (array)$newRecord;
            $res = $this->_getData();
            if(isset($res->data) && count($res->data)>0){
                foreach ($res->data as $i => $item) {
                    if(isset($item->$key) && ($item->$key == $index)){
                        foreach ($newRecord as $k => $val) {
                            $res->data[$i]->$k = $val;
                        }
                        $find = true;
                        break;
                    }
                }
                if($find){
                    return $this->_saveData($res); 
                }else{
                    throw new Exception("Enregistrement non trouvé.");
                }
            }else{
                throw new Exception("Tableau vide.");
            }
        }
        /** D = Method DELETE */
        public function delete($key,$index)
        {
            $find = false;
            $res = $this->_getData();
            if(isset($res->data) && count($res->data)>0){
                foreach ($res->data as $i => $item) {
                    if(isset($item->$key) && ($item->$key == $index)){
                        array_splice($res->data, $i, 1);
                        $find = true;
                        break;
                    }
                }
                if($find){
                    return $this->_saveData($res); 
                }else{
                    throw new Exception("Enregistrement non trouvé.");
                }
            }else{
                throw new Exception("Tableau vide.");
            }
        }
        /** D = Method DELETEAll */
        public function deleteAll()
        {
            if(file_exists($this->file)){
                @unlink($this->file);
                return 1;
            }else{
                throw new Exception("Collection inexistante.");
            }
        }  
    }
