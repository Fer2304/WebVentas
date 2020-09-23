<?php
// web/index.php
// carga del modelo y los controladores
require_once __DIR__ . '/../app/Config.php';
require_once __DIR__ . '/../app/Model.php';
require_once __DIR__ . '/../app/Controller.php';
require_once __DIR__ . '../../app/libs/sesionAgente.php';

ini_set("session.use_trans_sid", "0");
ini_set("session.use_only_cookies", "1");
//error_reporting(E_WARNING);
session_set_cookie_params(0, "/", $_SERVER["HTTP_HOST"], 0); #  Si se cierra el navegador, cerramos la sesion.

$sesion = new Session;
$sesion->init();


#   En el momento que se poase de tiempo, se cierra la sesion

if (isset($_SESSION['time'])) {
    if ($sesion->inactividad()) {

        header('location: index.php?ctl=loginAgente');
    }
}

// enrutamiento
$map = array(
    
    #   Desde aqui hacemos el enrutamiento por medioo del array map en el que le indicamos el nombre de la ruta, el controller, la accion y el nivel que se requiere
    #   'inicio' => array('controller' =>'Controller', 'action' =>'inicio', 'nivel_usuario'=>0)
    
    'loginAgente' => array('controller' => 'Controller', 'action' => 'loginAgente', 'nivel' => 0),
    'registroAgente' => array('controller' => 'Controller', 'action' => 'registroAgente', 'nivel' => 2),
    'inicio' => array('controller' => 'Controller', 'action' => 'inicio', 'nivel' => 1),
    'agentesRegistrados' => array('controller' => 'Controller', 'action' => 'agentesRegistrados', 'nivel' => 2),
    'ventasTotales' => array('controller' => 'Controller', 'action' => 'ventasTotales', 'nivel' => 1),
    'ventasAgente' => array('controller' => 'Controller', 'action' => 'ventasAgente', 'nivel' => 2),
    'insertarVenta' => array('controller' => 'Controller', 'action' => 'insertarVenta', 'nivel' => 1),
    'buscarVentasFecha' => array('controller' => 'Controller', 'action' => 'buscarVentasFecha', 'nivel' => 0),
    'buscarVentasNombre' => array('controller' => 'Controller', 'action' => 'buscarVentasNombre', 'nivel' => 1),
    'salir' => array('controller' => 'Controller', 'action' => 'salir', 'nivel' => 0),
    'error' => array('controller' => 'Controller', 'action' => 'error', 'nivel' => 0),
    'errorderuta' => array('controller' => 'Controller', 'action' => 'errorderuta', 'nivel' => 0)

);




// Parseo de la ruta
if (isset($_GET['ctl'])) {
    if (isset($map[$_GET['ctl']])) {
        $ruta = $_GET['ctl'];
    } else {

        if ($_SESSION['nivel'] == 0) { //si no está logueado mostrará el mensaje sólamente
            //Si el valor puesto en ctl en la URL no existe en el array de mapeo escribe en el fichero logError.txt y envía una cabecera de error
            $errorMensaje = "Error 404: No existe la ruta " . $_GET['ctl'];
            error_log($errorMensaje . microtime() . PHP_EOL, 3, "logError.txt");
            //header('../../app/libs/error.php');
            echo '<html><body><h1>Error 404: No existe la ruta <i>' . $_GET['ctl'] . '</p></body></html>';
            exit;
        } else { //si está logueado mostrará el mensaje con el menú
            //Si el valor puesto en ctl en la URL no existe en el array de mapeo escribe en el fichero logError.txt y envía una cabecera de error
            $errorMensaje = "Error 404: No existe la ruta " . $_GET['ctl'];
            error_log($errorMensaje . microtime() . PHP_EOL, 3, "logError.txt");
            $contenido = '<html><body><h1>Error 404: No existe la ruta <i>' . $_GET['ctl'] . '</p></body></html>';
            header('location: index.php?ctl=errorderuta');

            exit;
        }
    }
} else {
    $ruta = 'loginAgente';
}

$controlador = $map[$ruta];

#   Comprobamos que el controlador existe 

if (method_exists($controlador['controller'], $controlador['action'])) { //comprobar aqui si el usuario tiene el nivel suficiente para ejecutar la accion
    
    #   Verificamos que tiene el nivel necesario para dicha accion

    if ($map[$ruta]['nivel'] <= $sesion->get('nivel')) {
        call_user_func(array(new $controlador['controller'], $controlador['action']));
    } else {

        $errorMensaje = $sesion->get('user') . ", no tienes permiso para realizar esta acción. Se requiere un nivel " . $map[$ruta]['nivel'] . " pero sólo tienes nivel " . $sesion->get('nivel');
        error_log($errorMensaje . "-" . microtime() . PHP_EOL, 3, "logError.txt");
        $_SESSION['message'] = $errorMensaje;
        require_once '../app/templates/error.php';
    }
} else {
    header('Status: 404 Not Found');
    echo '<html><body><h1>Error 404: El controlador <i>' .
        $controlador['controller'] .
        '->' .
        $controlador['action'] .
        '</i> no existe</h1></body></html>';
}
