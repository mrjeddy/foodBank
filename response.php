<?php
include "foodBank.php";

if (isset($_GET["example"])){
    $fb = new FoobBank($_GET["example"]);
    $fb->getMenu();
}
?>