<?php
class queryDataBase
{
    public $host = "localhost";
    public $user = "root";
    public $pass = "1q2w3e4r";
    public $base = "test_task";
    public $resultArr;
    public function showMeWhatYouGot(String $s){
        $conn=mysqli_connect($this->host,$this->user,$this->pass,$this->base);
        $sqlType = "SELECT `title` FROM `ingredient_type` WHERE `code` = '$s'";
        $queryType = mysqli_query($conn, $sqlType);
        $type = mysqli_fetch_array($queryType);
        $typeTitle = $type['title'];
        $sqlIng = "SELECT `title`, `price` FROM `ingredient` WHERE `type_id` = (
            SELECT `id` FROM `ingredient_type` WHERE `code` = '$s'
            )";
        $queryIng = mysqli_query($conn, $sqlIng);
        $this->resultArr = array();
        while ($row = mysqli_fetch_array($queryIng)) {
            $this->resultArr[] = array("type"=>$typeTitle, "name"=>$row['title'], "price"=>$row['price']);
        }
        return $this->resultArr;
    }
}

?>