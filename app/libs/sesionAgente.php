<?php


class Session
{

    #   Metodo desde el cul iniciamos la sesion

    public function init()
    {
        session_start();
    }


    #	Método que se encarga de cerrar la sesión y eliminar las variables de sesión.

    public function cerrarSesion()
    {
        session_unset();
        session_destroy();
    }

    #	El constructor se encargará de crear la sesión. Le pasamos las variables de usuario 
    #   para que se almacenen y poder usarlas en cualquier lugar de nuestra aplicacion

    public function setSession($id, $user, $nivel, $ciudad, $temperatura)
    {
        session_name($user);
        $_SESSION['id'] = $id;
        $_SESSION['user'] = $user;
        $_SESSION['nivel'] = $nivel;
        $_SESSION['time'] = time();
        $_SESSION['nom_ciudad'] = $ciudad;
        $_SESSION['temp'] = $temperatura;
        $_SESSION['message'] = "";
    }

    #	Método que devuelve el valor de una variable de sesión si es que esta existe.

    public function get($key)
    {
        return !empty($_SESSION[$key]) ? $_SESSION[$key] : null;
    }    

	#	Método que realice el cierre de sesión por inactividad pasados 5 minutos.

    public function inactividad()
    {
        if (time() - $_SESSION['time'] > 300) { //tiempo de inactividad 15 minutos.

            session_destroy();
            return true;
        } else {
            $_SESSION['time'] = time();
            return false;
        }
    }

	#	Método que devuelve si hay una sesion iniciada o no.

    public function getStatus()
    {
        return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
    }


    #   Metodo con el cual podemos borrar una variable de sesion si es que existe

    public function remove($key)
    {
        if (!empty($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
}
