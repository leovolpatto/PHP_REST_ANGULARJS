<?php

require_once './AutoLoader.php';


$p = \Models\Pessoa::Create('nome', 'sobrenome', 34, true);


var_dump($p);