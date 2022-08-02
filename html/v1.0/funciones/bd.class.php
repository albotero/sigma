<?php
class BASEDATOS {
    public $basedatos;
    public $host;
    public $usuario;
    public $contrasena;

    public const BASES = [
        "pruebas" => "Pruebas",
        "sigma" => "Sigma"
    ];

    function __construct() {
        $this->basedatos = $_SESSION['ips'];
        switch ($this->basedatos) {
            case "pruebas":
            case "sigma":
                $this->host = "localhost";
                $this->usuario = "sigma";
                $this->contrasena = "Alejo123";
                break;
        }
    }
}

function ejecutarSql($sql) {
    if (isset($_SESSION['ips'])) {
        $bd = new BASEDATOS();
        $conn = new mysqli($bd->host, $bd->usuario, $bd->contrasena, $bd->basedatos);
        // Check connection
        if ($conn->connect_error)
            die("Connection failed: {$conn->connect_error}");
        else {
            $result = $conn->query($sql);
            $conn->close();
            return $result;
        }
    }
    else
        die("No se encontraron los datos de la sesi&oacute;n");
}
?>