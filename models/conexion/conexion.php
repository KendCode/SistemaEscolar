<?php
class Database {
    private static $servidor = "localhost";
    private static $usuario = "root";
    private static $contrasena = "";
    private static $bd_datos = "bd_escolar";
    private static $conexion = null;

    public static function conectar() {
        if (self::$conexion == null) {
            self::$conexion = new mysqli(self::$servidor, self::$usuario, self::$contrasena, self::$bd_datos);
            if (self::$conexion->connect_error) {
                die("Error de conexión: " . self::$conexion->connect_error);
            }
        }
        return self::$conexion;
    }
}
?>
