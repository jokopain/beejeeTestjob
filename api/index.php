<?php

spl_autoload_register(function (string $className) {
    $uri = __DIR__ . '/src/' . $className . '.php';
    $new_uri = str_replace ( '\\' , "/" , $uri );
    require_once ($new_uri);
  });


$route = $_GET['route'] ?? '';
$routes = require __DIR__ . '/src/routes.php';



$isRouteFound = false;
foreach ($routes as $pattern => $controllerAndAction) {
    preg_match($pattern, $route, $matches);
    // var_dump( $matches);
    if (!empty($matches)) {
        $isRouteFound = true;
        break;
    }
}

if (!$isRouteFound) {
    echo 'Страница не найдена!';
    return;
}

unset($matches[0]);



$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

$controller = new $controllerName();

if ($_GET["route"] == "task/add/"){
    $controller->$actionName($_GET["username"], $_GET["text"], $_GET["email"], ...$matches);
} 
elseif ($_GET["route"] == "task/edit/"){
    $controller->$actionName($_GET["username"], $_GET["text"], $_GET["email"], $_GET["id"], $_GET["isModered"], ...$matches);
}
else {
    $controller->$actionName(...$matches);
}



?>
