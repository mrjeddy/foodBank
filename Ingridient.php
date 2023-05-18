<?php
class Ingridient{
    public $type = null;
    public $value = null;

    public function __construct(String $t, String $v){
        $this->type = $t;
        $this->value = $v;
    }
}
?>