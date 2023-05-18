<?php
include "Ingridient.php";
include "Meal.php";
include "queryDataBase.php";

class FoobBank{
public $menu;
public $rcp;
public $rcpArr;
public $dataArray;
    public function __construct(String $s){
        $this->rcp = $s;
        $this->rcpArr = str_split($this->rcp);
        $queryDB = new queryDataBase();
        for ($i=0; $i < strlen($this->rcp); $i++) {
            $this->dataArray[] = $queryDB->showMeWhatYouGot($this->rcpArr[$i]);            
        }
        $this->Combine($this->dataArray);
    }
    function Combine ($arrays, $N=-1, $count=FALSE, $weight=FALSE){    
        if ($N == -1) {            
            $arrays = array_values($arrays);
            $count = count($arrays);
            $weight = array_fill(-1, $count+1, 1);
            $Q = 1;
            foreach ($arrays as $i=>$array) {
                $size = count($array);
                $Q = $Q * $size;
                $weight[$i] = $weight[$i-1] * $size;
            }            
            $result = array();
            for ($n=0; $n<$Q; $n++){
                $result[] = $this->Combine($arrays, $n, $count, $weight);
            }            
        }
        else {
            $SostArr = array_fill(0, $count, 0);
            for ($i=$count-1; $i>=0; $i--)
            {
                $SostArr[$i] = floor($N/$weight[$i-1]);
                $N = $N - $SostArr[$i] * $weight[$i-1];
            }
            $unsortedArray= array();
                for ($i=0; $i<$count; $i++){
                    $unsortedArray[$i] = $arrays[$i][$SostArr[$i]];
            }
            $details = $this->unique_multidim_array($unsortedArray,'name');
            if (count($details)==count($unsortedArray)){
                $tempMeal = new Meal();
                foreach ($unsortedArray as $ingredient) {
                    $tempMeal->addIngridient(
                        new Ingridient($ingredient["type"], $ingredient["name"]),
                        $ingredient["price"]
                    );
                }
                $this->menu[] = $tempMeal;
            }
        }        
    }
    function unique_multidim_array($array, $key) {
        $temp_array = array();    
        $i = 0;    
        $key_array = array();   
        foreach($array as $val) {    
            if (!in_array($val[$key], $key_array)) {    
                $key_array[$i] = $val[$key];    
                $temp_array[$i] = $val;    
            }    
            $i++;    
        }    
        return $temp_array;    
    }
    function getMenu(){
        header('Content-type: application/json');
        echo json_encode($this->menu, JSON_UNESCAPED_UNICODE);
    }
}
?>