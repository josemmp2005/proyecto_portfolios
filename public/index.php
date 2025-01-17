<?php

use App\Models\Usuarios;

session_start();
require('../vendor/autoload.php');
require "../bootstrap.php";
require "../app/conf/conf.php";

use App\Core\Router;
use App\Controllers\UserController;
use App\Controllers\TrabajoController;
use App\Controllers\ProyectoController;
use App\Controllers\RedSocialController;
use App\Controllers\SkillController;

$router = new Router();
$router->add(array(
    'name' => 'home',
    'path' => '/^\/$/',
    'action' => [UserController::class, 'indexAction'],
));

$router->add(array(
    'name' => 'login',
    'path' => '/^\/login$/',
    'action' => [UserController::class, 'loginAction'],
));

$router->add(array(
    'name' => 'registrar',
    'path' => '/^\/register$/',
    'action' => [UserController::class, 'registrarAction'],
));
$router->add(route: array(
    'name' => 'logout',
    'path' => '/^\/logout$/',
    'action' => [UserController::class, 'cerrarSesionAction'],
));
$router->add(array(
    'name' => 'edit',
    'path' => '/^\/edit$/',
    'action' => [UserController::class, 'editAction'],
));
$router->add(array(
    'name' => 'anadirTrabajo',
    'path' => '/^\/anadirTrabajo$/',
    'action' => [TrabajoController::class, 'anadirTrabajoAction'],
));
$router->add(array(
    'name' => 'anadirProyecto',
    'path' => '/^\/anadirProyecto$/',
    'action' => [ProyectoController::class, 'anadirProyectoAction'],
));
$router->add(array(
    'name' => 'anadirRedSocial',
    'path' => '/^\/anadirRedSocial$/',
    'action' => [RedSocialController::class, 'anadirRedSocialAction'],
));
$router->add(array(
    'name' => 'anadirSkill',
    'path' => '/^\/anadirSkill$/',
    'action' => [SkillController::class, 'anadirSkillAction'],
));

$router->add(array(
    'name' => 'eliminarProyecto',
    'path' => '/^\/eliminarProyecto\?id=\d+$/',
    'action' => [ProyectoController::class, 'eliminarProyecto'],
));
$router->add(array(
    'name' => 'eliminarTrabajo',
    'path' => '/^\/eliminarTrabajo\?id=\d+$/',
    'action' => [TrabajoController::class, 'eliminarTrabajo'],
));
$router->add(array(
    'name' => 'editarTrabajo',
    'path' => '/^\/editarTrabajo\?id=\d+$/',
    'action' => [TrabajoController::class, 'editarTrabajo'],
));

$router->add(array(
    'name' => 'editarProyecto',
    'path' => '/^\/editarProyecto\?id=\d+$/',
    'action' => [ProyectoController::class, 'editarProyecto'],
));

$router->add(array(
    'name' => 'editarRedSocial',
    'path' => '/^\/editarRedSocial\?id=\d+$/',
    'action' => [RedSocialController::class, 'editarRedSocial'],
));

$router->add(array(
    'name' => 'eliminarRedSocial',
    'path' => '/^\/eliminarRedSocial\?id=\d+$/',
    'action' => [RedSocialController::class, 'eliminarRedSocial'],
));

$router->add(array(
    'name' => 'editarSkill',
    'path' => '/^\/editarSkill\?id=\d+$/',
    'action' => [SkillController::class, 'editarSkill'],
));

$router->add(array(
    'name' => 'eliminarSkill',
    'path' => '/^\/eliminarSkill\?id=\d+$/',
    'action' => [SkillController::class, 'eliminarSkill'],
));

$router->add(array(
    'name' => 'verificar',
    'path' => '/^\/verificar(\/|\?token=)[\w\.\+\-\/=]+$/',
    'method' => 'GET',
    'action' => [UserController::class, 'verificarAction'],
));

$router->add(array(
    'name' => 'verPortfolio',
    'path' => '/^\/verPortfolio\?id=\d+$/',
    'action' => [UserController::class, 'verPortfolio'],
));

$request = str_replace(DIRBASEURL, '', $_SERVER['REQUEST_URI']); 
// echo $request;
$route = $router->match(request: $request);
if ($route) {
    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName;
    $controller->$actionName($request);

} else {
    echo "No route";
}