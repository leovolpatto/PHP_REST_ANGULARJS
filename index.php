<?php

require_once './AutoLoader.php';


$x = \Utils\Data\MySQL::Instance()->selectObject("SELECT * FROM pessoas", "\Models\Pessoa");

var_dump($x->getResultArray());