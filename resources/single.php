<?php

class SingleResource {
    protected $item;
    public function __construct($item) {
        $this->item = $item;
    }

    public function toArray() { 
        return $this->item;
    }
}
