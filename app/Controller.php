<?php
include_once('libs/utils.php');
include('libs/sesionAgente.php');
include('libs/classValidacion.php');


#   Clase donde se almacenan todos los Controllers que son los que se encargande realizar las diferentes 
#   acciones y llevarnos a las diferentes views e la app dependiendo del resultado de la petticion ....................

class Controller
{

    #   Funcion con la que vamos a poder logarnos y entrar a la web ..........

    public function loginAgente()
    {
        session_unset(); #  elimina si hay una sesion anterior
        $params['mensaje'] = "";
        $params['user'] = recoge("user");
        $params['password'] = crypt_blowfish(recoge('password'));


        #   En todas las funciones vamos a usar la clase validacion para verificar que los
        #   datos que recibimos son correctos y estan dentro de las reglas que les indicamos

        try {
            $validacion = new Validacion();
            $regla = array(
                array(
                    'name' => 'user',
                    'regla' => 'no-empty,letras'
                ),
                array(
                    'name' => 'password',
                    'regla' => 'no-empty'
                )

            );

            $validaciones = $validacion->rules($regla, $params);

            // Compruebo que las validaciones son correctas 
            if ($validaciones === true) {

                $m = Model::GetInstance();  #   Modelo Singleton

                $sesion = new Session;

                if (isset($_POST['bLogin'])) {

                    if ($registro = $m->SelectUser($params)) {

                        $sesion->cerrarSesion();
                        $sesion->init(); #  inicia sesion de usuario registrado

                        $temperatura = tiempoEnTuCiudad($registro['nom_ciudad']); # Guardo la temperatura utilizando mi funcion tuTiempoEnTuCiudad
                        $sesion->setSession($registro['id'], $params['user'], $registro['puesto'], $registro['nom_ciudad'], $temperatura); #    Almacenos las variables de sesion dentro del constructor de mis clase
                        header('location: index.php?ctl=inicio');
                    } else {

                        $params['mensaje'] = 'Usuario o contraseña incorrectos. Contacta con tu administrador';
                    }
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/templates/login.php';
    }

    #   Funcion para regitrarnos en caso de que aun no lo hayamos hecho


    function registroAgente()
    {
        $params['mensaje'] = "";
        $validacion = false;

        $params['usuario'] = "";
        $params['contra'] = "";
        $params['nom_ciudad'] = "";
        $params['puesto'] = "";

        if (isset($_REQUEST['bRegister'])) {

            $params['usuario'] = recoge("usuario");
            $params['contra'] = recoge('contra');
            $params['nom_ciudad'] = recoge("nom_ciudad");
            $params['puesto'] = recoge("puesto");

            try {
                $validacion = new Validacion();
                $regla = array(
                    array(
                        'name' => 'usuario',
                        'regla' => 'no-empty,letras'
                    ),
                    array(
                        'name' => 'contra',
                        'regla' => 'no-empty'
                    ),
                    array(
                        'name' => 'nom_ciudad',
                        'regla' => 'no-empty,letras,validaProvincia'
                    ),
                    array(
                        'name' => 'puesto',
                        'regla' => 'no-empty,numeric'
                    )

                );

                $validaciones = $validacion->rules($regla, $params);
            } catch (Exception $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
                header('Location: index.php?ctl=error');
            } catch (Error $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
                header('Location: index.php?ctl=error');
            }


            #   Validaciones

            #   Verificamos que todo ha salido bien
            if ($validaciones === true) {

                $params['contra'] = crypt_blowfish($params['contra']);
                $params['nom_ciudad'] =  mb_strtolower(recoge("nom_ciudad"));

                $m = Model::GetInstance();

                if ($m->insertaEmpleado($params)) {
                    header('location: index.php?ctl=agentesRegistrados');   #    Si todo va bien te vas a loginAgente
                } else {

                    header('Location: index.php?ctl=error');

                    $_SESSION['message'] = 'No se ha podido registrar el usuario. Revisa el formulario';
                }
            }
        }
        require __DIR__ . '/templates/registroAgente.php';
    }

    #   Funcion que realiza las acciones pertinentes para que podamos ver las ventas totales que hay hasta el momento ................................


    public function agentesRegistrados()
    {
        try {
            $m = Model::GetInstance();
            $params = array(
                'agentes' => $m->agentesRegistrados()
            );

            // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/templates/verAgentesRegistrados.php';
    }


    #   Funcion con la que podemos ver todas las ventas hechas hasta la fecha

    public function ventasAgente()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Página no encontrada');
            }
            $id = recoge('id');
            $m = Model::GetInstance();
            #   Desde aqui podremos filtrar las ventas por el id del agente, pinchando en su nombre
            $alimento = $m->ventasPorAgente($id);
            $params = $alimento;
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/templates/verVentasAgente.php';
    }


    #   Funcion que realiza las acciones pertinentes para que podamos ver las ventas totales que hay hasta el momento ................................


    public function ventasTotales()
    {
        try {
            $m = Model::GetInstance();
            $params = array(
                'ventas' => $m->ventasTotales()
            );

            // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/templates/verVentas.php';
    }


    #   Funcion para insertar una nueva venta ...............................

    public function insertarVenta()
    {
        $validacion = false;

        $params['nom_venta'] = "";
        $params['fecha_venta'] = "";

        if (isset($_REQUEST['bInsertar'])) {

            $params['id'] = $_SESSION['id'];
            $params['nom_venta'] = recoge("nom_venta");
            $params['fecha_venta'] = $_REQUEST['fecha_venta'];


            #   Realizamos las validaciones pertinentes
            try {
                $validacion = new Validacion();
                $regla = array(
                    array(
                        'name' => 'id',
                        'regla' => 'no-empty'
                    ),
                    array(
                        'name' => 'nom_venta',
                        'regla' => 'no-empty,validaVenta'
                    ),
                    array(
                        'name' => 'fecha_venta',
                        'regla' => 'no-empty, verificaFecha'
                    )
                );

                $validaciones = $validacion->rules($regla, $params);
                // La clase nos devolverá true si no ha habido errores y un objeto con que incluye los errores en un array
                // Ahora nos sirve para ver lo que devuelve la clase
                /*echo "<pre>";
                print_r($validaciones);
                echo "</pre><br>";*/
            } catch (Exception $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
                header('Location: index.php?ctl=error');
            } catch (Error $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
                header('Location: index.php?ctl=error');
            }

            #   Si todo va bien realizaremos la inserción de la venta en la BD
            if ($validaciones === true) {

                $m = Model::GetInstance();
                if ($m->insertarVenta($params)) {
                    header('location: index.php?ctl=ventasTotales');
                } else {

                    header('Location: index.php?ctl=error');

                    $_SESSION['message'] = 'No se ha podido insertar el alimento. Revisa el formulario';
                }
            }
        }
        require __DIR__ . '/templates/ventasInsertar.php';
    }



    #   Funcion que realiza las acciones pertinentes para que podamos ver las ventas filtradas por fecha ................................


    public function buscarVentasFecha()
    {
        try {
            $params = array(
                'fecha_1' => '',
                'fecha_2' => '',
                'ventas' => array()
            );

            $m = Model::GetInstance();
            if (isset($_POST['buscarN'])) {

                $params['fecha_1'] = recoge("fecha_1");
                $params['fecha_2'] = recoge("fecha_2");
                $params['ventas'] = $m->buscarVentasPorFecha($params);
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/templates/ventasPorFecha.php';
    }

    #   Funcion que realiza las acciones pertinentes para que podamos ver las ventas filtradas por nombre ................................

    public function buscarVentasNombre()
    {
        try {
            $params = array(
                'nom_venta' => '',
                'ventas' => array()
            );
            $m = Model::GetInstance();
            if (isset($_POST['buscarE'])) {

                $params['nom_venta'] = recoge("nom_venta");
                $params['ventas'] = $m->buscarVentasPorNombre($params['nom_venta']);
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/templates/ventasPorNombre.php';
    }



    #   Funciones basicas de inicio, error, errorRuta y salir .......

    public function inicio()
    {
        $params = array(
            'mensaje' => 'Web desarrollada para registrar nuestras ventas',
            'fecha' => date('d-m-yy')
        );
        require __DIR__ . '/templates/inicio.php';
    }


    public function error()
    {

        require 'templates/error.php';
    }
    public function errorDeRuta()
    {
        require __DIR__ . '/templates/errorderuta.php';
    }




    public function salir()
    {
        session_destroy();
        header('Location: index.php?ctl=loginAgente');
    }
}
