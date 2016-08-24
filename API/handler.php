<?php

require_once '../AutoLoader.php';

$routerConfigs = new API\RouteConfigs();
$router = $routerConfigs->buildRouter();

$router->routeRequest();