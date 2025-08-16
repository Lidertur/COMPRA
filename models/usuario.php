<?php

error_reporting(E_ALL);
ini_set ('display_errors', 1);

require_once 'bd/Database.php' ;

class usuario {
    private $usuario;
    private $idU;
    private $rol;
    private $nombre;
    private $telefono;
    private $correo;
    private $contraseña;
    private $idA;

    public function __construct(){
        $this->usuario = basedeDatos::conectar();
    }

    //getters
    public function getidU(){return $this->idU;}
    public function getrol(){return $this->rol;}
    public function getnombre(){return $this->nombre;}
    public function gettelefono(){return $this->telefono;}
    public function getcorreo(){return $this->correo;}
    public function getcontraseña(){return $this->contraseña;}
    public function getidA(){return $this->idA;}

    //setters
    public function setidU($idU) { $this->idU = $idU; }
    public function setrol($rol) { $this->rol = $rol; }
    public function setnombre($nombre) { $this->nombre = $nombre; }
    public function settelefono($telefono) { $this->telefono = $telefono; }
    public function setcorreo($correo) { $this->correo = $correo; }
    public function setcontraseña($contraseña){ $this->contraseña = $contraseña;}
    public function setidA($idA) { $this->idA = $idA; }

   public function listar(){
        try{
            $consulta = $this->usuario->prepare("SELECT * FROM usuario;");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
   public function crear($rol, $nombre, $contraseña, $telefono, $correo, $idA = null) {
        try {
            $hash = password_hash($contraseña, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuario (rol, nombre, contraseña, telefono, correo, idA)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->usuario->prepare($sql);
            $stmt->execute([$rol, $nombre, $hash, $telefono, $correo, $idA]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function actualizar(usuario $p) {
        try {
            $sql = "UPDATE usuario SET rol=?, nombre=?, telefono=?, correo=?,  idA=?
                    WHERE idU=?";
            $this->usuario->prepare($sql)->execute([
                $p->getrol(),
                $p->getnombre(),
                $p->gettelefono(),
                $p->getcorreo(),
                $p->getidA(),
                $p->getidU()
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function eliminar($idA) {
        try {
            $sql = "DELETE FROM usuario WHERE idA = ?";
            $this->usuario->prepare($sql)->execute([$idA]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function listarr($filtro = '') {
        try {
            if ($filtro) {
                $sql = "SELECT * FROM usuario WHERE 
                            nombre LIKE ? OR 
                            correo LIKE ?";
                $stmt = $this->usuario->prepare($sql);
                $buscar = "%$filtro%";
                $stmt->execute([$buscar, $buscar, $buscar]);
            } else {
                $stmt = $this->usuario->prepare("SELECT * FROM usuario");
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function existeNombre($nombre, $idExcluir = null) {
        $sql = "SELECT COUNT(*) FROM usuario WHERE nombre = ?";
        $params = [$nombre];

        if ($idExcluir) {
            $sql .= " AND idU != ?";
            $params[] = $idExcluir;
        }

        $stmt = $this->usuario->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    // Validar login
   public function validarLogin($nombre, $contraseña) {
        try {
            $sql = "SELECT * FROM usuario WHERE nombre = ?";
            $stmt = $this->usuario->prepare($sql);
            $stmt->execute([$nombre]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
                return $usuario; // Login exitoso
            }

            return false; // Credenciales incorrectas
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    // Listar todos los usuarios
    
}

