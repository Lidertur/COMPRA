<?php 
    class basedeDatos{
        const servidor = "127.0.0.1";
        const usuariobd = "root";
        const clave = "";
        const dbname = "compra";

        public static function conectar(){
            try {
                $conexion = new PDO(
                    "mysql:host=" . self::servidor . ";dbname=" . self::dbname . ";charset=utf8",
                    self::usuariobd,
                    self::clave
                );
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conexion; // Devuelve la conexión exitosa
            } catch (PDOException $e) {
                die("Fallo: " . $e->getMessage()); // Detiene la ejecución en caso de error
            }
        }
    }
    
?>