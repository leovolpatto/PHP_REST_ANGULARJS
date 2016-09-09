<?php

require_once '../AutoLoader.php';

$routerConfigs = new api\RouteConfigs();
$router = $routerConfigs->buildRouter();

$router->routeRequest();