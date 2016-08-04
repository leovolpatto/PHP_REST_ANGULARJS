<?php

require_once './AutoLoader.php';


$x = \Utils\Data\MySQL::Instance()->selectObject("SELECT * FROM pessoas", "Models\Pessoa");

if($x->isSuccess()){
    echo "consultou";
    var_dump($x->getResultArray());
}
else{
    echo "erro";
}


var_dump($x);