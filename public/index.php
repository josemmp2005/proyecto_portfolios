<?php

use App\Models\Usuarios;

session_start();

//Carga de archivos de configuración de la autocarga de clases
require('../vendor/autoload.php');

//Carga de archivos de configuración
require "../bootstrap.php";
require "../app/conf/conf.php";

// Importación de clases
use App\Core\Router;
use App\Controllers\UserController;
use App\Controllers\TrabajoController;
use App\Controllers\ProyectoController;
use App\Controllers\RedSocialController;
use App\Controllers\SkillController;

// Creación de rutas
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
    'path' => '/^\/eliminarProyecto\/\d+$/',
    'action' => [ProyectoController::class, 'eliminarProyecto'],
));
$router->add(array(
    'name' => 'eliminarTrabajo',
    'path' => '/^\/eliminarTrabajo\/\d+$/',
    'action' => [TrabajoController::class, 'eliminarTrabajo'],
));
$router->add(array(
    'name' => 'editarTrabajo',
    'path' => '/^\/editarTrabajo\/\d+$/',
    'action' => [TrabajoController::class, 'editarTrabajo'],
));

$router->add(array(
    'name' => 'editarProyecto',
    'path' => '/^\/editarProyecto\/\d+$/',
    'action' => [ProyectoController::class, 'editarProyecto'],
));

$router->add(array(
    'name' => 'editarRedSocial',
    'path' => '/^\/editarRedSocial\/\d+$/',
    'action' => [RedSocialController::class, 'editarRedSocial'],
));

$router->add(array(
    'name' => 'eliminarRedSocial',
    'path' => '/^\/eliminarRedSocial\/\d+$/',
    'action' => [RedSocialController::class, 'eliminarRedSocial'],
));

$router->add(array(
    'name' => 'editarSkill',
    'path' => '/^\/editarSkill\/\d+$/',
    'action' => [SkillController::class, 'editarSkill'],
));

$router->add(array(
    'name' => 'eliminarSkill',
    'path' => '/^\/eliminarSkill\/\d+$/',
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
    'path' => '/^\/verPortfolio\/\d+$/',
    'action' => [UserController::class, 'verPortfolio'],
));

// Obtiene la solicitud actual, eliminando la base URL de la ruta
$request = str_replace(DIRBASEURL, '', $_SERVER['REQUEST_URI']); 

// Busca la ruta correspondiente a la solicitud
$route = $router->match(request: $request);
if ($route) {
    // Si la ruta existe, se ejecuta el controlador y acción correspondientes
    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName;
    $controller->$actionName($request);

} else {
    // Si no se encuentra la ruta, muestra un mensaje de error
    echo "No route";
}