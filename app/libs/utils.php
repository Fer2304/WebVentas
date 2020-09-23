<?php
//Aqui pondremos las funciones de validación de los campos

function sinTildes($frase)
{
    $no_permitidas = array(
        "á",
        "é",
        "í",
        "ó",
        "ú",
        "Á",
        "É",
        "Í",
        "Ó",
        "Ú",
        "à",
        "è",
        "ì",
        "ò",
        "ù",
        "À",
        "È",
        "Ì",
        "Ò",
        "Ù"
    );
    $permitidas = array(
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U",
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U"
    );
    $texto = str_replace($no_permitidas, $permitidas, $frase);
    return $texto;
}



function validarDatos($n, $e, $p, $hc, $f, $g)
{
    return (is_string($n) &
        is_numeric($e) &
        is_numeric($p) &
        is_numeric($hc) &
        is_numeric($f) &
        is_numeric($g));
}


function recoge($var)
{
    if (isset($_REQUEST[$var]))
        $tmp=strip_tags(sinEspacios($_REQUEST[$var]));
        else
            $tmp= "";
            
            return $tmp;
}

function sinEspacios($frase) {
    $texto = trim(preg_replace('/ +/', ' ', $frase));
    return $texto;
}

//  Funcion para que se encripte la contraseña. Falta revisarla y utilizarla en nuestro programa para grabar las cotraseñas 
//  en nuestra BD y, despues, comprobarlas para que funcionen correctamente

function crypt_blowfish($password) {

    $salt = '$2a$07$usesomesillystringforsalt$';
    $pass= crypt($password, $salt);
    
    //echo "<br> SALT:  $salt <br>" ;
    return $pass;
}

//  Funcion que determina el tiempo de tu ciudad. En este caso solo incluimos el parametro ciudad pero se podría incluir
//  tambien otro campo que fuese el parametro pais, el cual ahora es fijo.

function tiempoEnTuCiudad($ciudad){

    $api_tiempo = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$ciudad.",es&appid=96edde9f7c64ae00b99322b16b678542");

    $json = json_decode($api_tiempo);

    $Kel = $json->main->temp;

    $Cel = number_format($Kel - 273.15);

    return $Cel." Celsius";
}



#   Funcion que comprueba la provincia

function validaProvincia($provincia)
{
    $valido = true;

    $provCV = array(
        "valencia",
        "alicante",
        "castellon",
        "albacete",
        "cuenca"        
    );

    if (!in_array(sinTildes(mb_strtolower($provincia)), $provCV)) {
        $errores["provincia"] = "El campo provincia no es correcto";
        $valido = false;
    }

    //return $valido;
    return sinTildes(mb_strtolower($provincia));
}

?>