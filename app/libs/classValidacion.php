<?php

/**
 * Clase para realizar validaciones en el modelo
 * Es utilizada para realizar validaciones 
 * 
 * La manera de usarla es crear un array donde indicaremos para cada campo 
 * que validaciones son las que queremos comprobar.
 * Por otro lado crearemos el objeto validación 
 * Llamaremos al método validación que es el único público rules pasándole los datos 
 * en un array y el array regla que previamente hemos definido.
 * 
 * 
 * $validacion = new Validacion();
$regla = array(
 array(
 'name' => 'nombre',
 'regla' => 'no-empty,letras'
 ),
 array(
 'name' => 'energia',
 'regla' => 'no-empty,numeric'
 ),
 array(
 'name' => 'proteina',
 'regla' => 'numeric'
 ),array(
 'name' => 'hc',
 'regla' => 'numeric'
 ),array(
 'name' => 'fibra',
 'regla' => 'numeric'
 ),array(
 'name' => 'grasa',
 'regla' => 'numeric'
 )

 );






 $regla = array(
 array(
 'name' => 'campo2',
 'regla' => 'no-empty,email'
 ),
 array(
 'name' => 'campo1',
 'regla' => 'no-empty,numeric'
 )

 );

 Le pasamos los datos en un array donde debe haber coincidencia los índices de este con el monbre de los campos
 $validaciones = $validacion->rules($regla, $datos);
 *
 * 
 */
class Validacion
{

    protected $_atributos;

    protected $_error;

    public $mensaje;

    /**
     * Metodo para indicar la regla de validacion
     * El método retorna un valor verdadero si la validación es correcta, de lo contrario retorna el objeto
     * actual, permitiendo acceder al atributo Validacion::$mensaje ya que es publico
     */
    public function rules($rule = array(), $data)
    {
        if (!is_array($rule)) {
            $this->mensaje = "las reglas deben de estar en formato de arreglo";
            return $this;
        }
        foreach ($rule as $key => $rules) {
            $reglas = explode(',', $rules['regla']);
            if (array_key_exists($rules['name'], $data)) {
                foreach ($data as $indice => $valor) {
                    if ($indice === $rules['name']) {
                        foreach ($reglas as $clave => $valores) {
                            //Llamamos a _getInflectedName para montar el nombre del método al que tenemos que llamar
                            $validator = $this->_getInflectedName($valores);
                            if (!is_callable(array($this, $validator))) {
                                //Si la regla no existe enviamos una excepción
                                throw new BadMethodCallException("No se encontro el metodo $valores");
                            }
                            $respuesta = $this->$validator($rules['name'], $valor);
                        }
                        break;
                    }
                }
            } else {
                //Sino hay coincidencia en los nombres de los campos enviados en $data y $rule
                //guardamos un error tambien podríamos enviar una excepción como hacemos en el caso
                //de que no haya coincidencia en la regla
                $this->mensaje[$rules['name']] = "el campo {$rules['name']} no esta dentro de la regla de validación o en el formulario";
            }
        }
        if (!empty($this->mensaje)) {
            return $this;
        } else {
            return true;
        }
    }

    /**
     * Metodo inflector de la clase
     * por medio de este metodo llamamos a las reglas de validacion que se generen y las adecuamos al nombre del método
     */
    private function _getInflectedName($text)
    {
        $validator = "";
        $_validator = preg_replace('/[^A-Za-z0-9]+/', ' ', $text);
        $arrayValidator = explode(' ', $_validator);
        if (count($arrayValidator) > 1) {
            foreach ($arrayValidator as $key => $value) {
                if ($key == 0) {
                    $validator .= "_" . $value;
                } else {
                    $validator .= ucwords($value);
                }
            }
        } else {
            $validator = "_" . $_validator;
        }

        return $validator;
    }

    /**
     * Metodo de verificacion de que el dato no este vacio o NULL
     * El metodo retorna un valor verdadero si la validacion es correcta de lo contrario retorna un valor falso
     * y llena el atributo validacion::$mensaje con un arreglo indicando el campo que mostrara el mensaje y el
     * mensaje que visualizara el usuario
     */
    protected function _noEmpty($campo, $valor)
    {
        if ($valor != "") {
            return true;
        } else {
            $this->mensaje[$campo][] = "el campo $campo debe de estar lleno";
            return false;
        }
    }

    /**
     * Metodo de verificacion de tipo numerico
     * El metodo retorna un valor verdadero si la validacion es correcta de lo contrario retorna un valor falso
     * y llena el atributo validacion::$mensaje con un arreglo indicando el campo que mostrara el mensaje y el
     * mensaje que visualizara el usuario
     */
    protected function _numeric($campo, $valor)
    {
        if (is_numeric($valor)) {
            return true;
        } else {
            $this->mensaje[$campo][] = "el campo $campo debe de ser numerico";
            return false;
        }
    }

    #   Función que confirma que el valor introducido es de tipo letras

    function _letras($campo, $valor)
    {
        if (preg_match("/^[A-Za-zñÑ]*$/", $valor))
            return true;
        else {
            $this->mensaje[$campo][] = "el campo $campo deben de ser sólo letras";
            return false;
        }
    }


    #   Funcion que valida que la sede este dentro de los valores establecidos .......

    function _validaProvincia($campo, $provincia)
    {
        $valido = true;

        $provCV = array(
            "valencia",
            "alicante",
            "castellon"
        );

        if (!in_array(sinTildes(mb_strtolower($provincia)), $provCV)) {
            //$errores["provincia"] = "El campo provincia no es correcto";
            $this->mensaje[$campo][] = "El campo provincia no es correcto";
            $valido = false;
        }

        return $valido;
    }

    #   Funcion que valida que la vneta este dentro de los valores establecidos ...............

    function _validaVenta($campo, $venta)
    {
        $valido = true;

        $nomVentas = array(
            "FIJO",
            "MOVIL",
            "FIJO + INTERNET",
            "FIJO + INTERNET + MOVIL (CONVERGENTE)"
        );

        if (!in_array(sinTildes(mb_strtoupper($venta)),  $nomVentas)) {
            $this->mensaje[$campo][] = "El campo venta no es correcto";
            $valido = false;
        }

        return $valido;
    }

    #   Funcion que valida que la fecha sea una fecha real ....................

    function _verificaFecha($campo, $fecha)
    {

        $valido = true;

        $valores = explode('-', $fecha);

        #   Comprobamos que entran 3 valores y que la fecha existe dentro del calendario
        #   conla funcion de php checkdate()
        if (!(count($valores) == 3 && checkdate($valores[1], $valores[2], $valores[0]))) { // mes /dia /año

            //$errores['fecha_2'] = "La fecha introducida no es valida";
            $this->mensaje[$campo][] = "El campo fecha no es valida";
            $valido = false;
        }



        return $valido;
    }
}
