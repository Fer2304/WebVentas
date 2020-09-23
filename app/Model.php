<?php
include_once('Config.php');

class Model extends PDO
{

    private static $instance = null;

    #   Creamos la conexion por medio del constructor
    public function __construct()
    {
        #   Realizamos la conexion con los datos que tenemos almacenados en config.php
        parent::__construct('mysql:host=' . Config::$hostname . ';dbname=' . Config::$nombreBD . '', Config::$usuario, Config::$clave);
        parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        parent::exec("set names utf8");
    }


    #   Creamos un método que comprueba si existe la conexion con la BD, si no es asi llamara
    #   al constructor para que la cree. SINGLETON

    public static function GetInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    //////////////////////////////////////////////////////////////////////////////////////////

    //  Aqui vamos incluiendo las nuevas funciones que vamos probando y se tienen que dejar funcionando

    #   Creamos una funcion para insertar el nuevo empleado en la BD

    public function insertaEmpleado(array $params)
    {

        $consulta = "INSERT INTO agentes (nombre, contra, puesto, id_ciudad) VALUES (:nombre, :contra, :puesto, (SELECT id_ciudad FROM ciudad WHERE nom_ciudad = :sede))";

        $result = $this->GetInstance()->prepare($consulta);
        $result->bindParam(':nombre', $params['usuario']);
        $result->bindParam(':contra', $params['contra']); 
        $result->bindParam(':sede', $params['nom_ciudad']);
        $result->bindParam(':puesto', $params['puesto']);
        $result->execute();

        return $result;
    }



    #   Funcion para confirmar si hay un usuario con los valores que indicamos

    function SelectUser(array $params)
    {
        $consulta = "SELECT * FROM agentes a INNER JOIN ciudad c on a.id_ciudad = c.id_ciudad WHERE a.nombre =:user AND a.contra =:pass";

        $select = $this->GetInstance()->prepare($consulta);
        $select->bindParam(':user', $params['user']);
        $select->bindParam(':pass', $params['password']);
        $select->execute();
        $registro = $select->fetch();
        return $registro;
    }


    #   Funcion para buscar las ventas por medio del id ...............

    function ventasPorAgente($id)
    {
        $consulta = "SELECT a.nombre as nombre, count(a.id) as ventas, sum(tv.importe_venta) as total, c.nom_ciudad as sede 
                     FROM agentes_ventas av INNER JOIN tipo_venta tv on av.id_venta = tv.id_venta 
                                            INNER JOIN agentes a on av.id_agente = a.id 
                                            INNER JOIN ciudad c ON a.id_ciudad = c.id_ciudad WHERE a.id =:id";

        $result = $this->GetInstance()->prepare($consulta);
        $result->bindParam(':id', $id);
        $result->execute();
        return $result->fetch();
    }

    #   Funcion que nos devuelve todos los agentes que estan dados de alta ..........

    public function agentesRegistrados()
    {
        $consulta = "SELECT * FROM agentes a INNER JOIN ciudad c on a.id_ciudad = c.id_ciudad ORDER BY a.id";

        $result = $this->GetInstance()->query($consulta);

        return $result->fetchAll();
    }


    #   Funcion que nos devuelve todas las ventas que haya registradas hasta el momento ..........

    public function ventasTotales()
    {
        $consulta = "SELECT * FROM agentes_ventas av INNER join tipo_venta tv on av.id_venta = tv.id_venta 
                                                     INNER JOIN agentes a on av.id_agente = a.id ORDER BY a.id";

        $result = $this->GetInstance()->query($consulta);

        return $result->fetchAll();
    }


    #   Funcion para insertar una nueva venta .......

    public function insertarVenta(array $params)
    {
        $consulta = "INSERT INTO agentes_ventas (id_agente, id_venta, fecha_venta) 
                                        VALUES ((SELECT id FROM agentes WHERE id = :id), (SELECT id_venta FROM tipo_venta WHERE nom_venta = :nom_venta), :fecha_venta)";
        $result = $this->GetInstance()->prepare($consulta);
        $result->bindParam(':id', $params['id']);
        $result->bindParam(':nom_venta', $params['nom_venta']);
        $result->bindParam(':fecha_venta', $params['fecha_venta']);
        $result->execute();

        return $result;
    }

    #   En esta funcion el agente podra buscar las ventas realizadas dentro en un espacio de tiempo determindo ............... 

    public function buscarVentasPorFecha($params)
    {
        $consulta = "SELECT * FROM agentes_ventas av INNER join tipo_venta tv on av.id_venta = tv.id_venta 
                                                     INNER JOIN agentes a on av.id_agente = a.id 
                                                     WHERE fecha_venta BETWEEN :fecha_1 AND :fecha_2 ORDER BY a.id";

        $result = $this->GetInstance()->prepare($consulta);
        $result->bindParam(':fecha_1', $params['fecha_1']);
        $result->bindParam(':fecha_2', $params['fecha_2']);
        $result->execute();

        return $result->fetchAll();
    }

    #   Funcion que nos devuelve las ventas filtrando por nombre .......................

    public function buscarVentasPorNombre($nom_venta)
    {
        $consulta = "SELECT * FROM agentes_ventas av INNER join tipo_venta tv on av.id_venta = tv.id_venta 
                                                     INNER JOIN agentes a on av.id_agente = a.id 
                                                     WHERE tv.nom_venta LIKE :nom_venta ORDER BY a.id";

        $result = $this->GetInstance()->prepare($consulta);
        $result->bindParam(':nom_venta', $nom_venta);
        $result->execute();

        return $result->fetchAll();
    }
}
