<?php
class Meal{
    public $products;
    public $price = 0;
    public function addIngridient(Ingridient $i, float $p){
        $this->products[] = $i;
        $this->price += $p;
    }
    public function getMeal(){
        echo json_encode($this, JSON_UNESCAPED_UNICODE);
    }
}
?>