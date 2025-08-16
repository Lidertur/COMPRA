<?php
error_reporting(E_ALL);
ini_set ('display_errors', 1);
require_once 'bd/Database.php';
class area {
private $area;
private $idA;    
private $nombre;
    public function __construct(){
        $this->area = basedeDatos::conectar();
    }
    // Getters
    public function getidA() { return $this->idA; }
    public function getnombre() { return $this->nombre; }
    // Setters
    public function setidA($idA) { $this->idA = $idA; }
    public function setnombre($nombre) { $this->nombre = $nombre; }

    public function listar(){
        try{
            $consulta = $this->area->prepare("SELECT * FROM area;");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }catch(exception $e) {
            die($e->getMessage());
        }
    }
    public function crear (area $p){
        try{
            $sql = "INSERT INTO area (nombre)
                VALUES (?)";
            $this->area->prepare($sql)->execute([
                $p->getnombre()
            ]);
        }catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function actualizar(area $p){
        try {
            $sql = "UPDATE area SET nombre=? where idA=?";
            $this->area->prepare($sql)->execute([
                $p->getnombre(),
                $p->getidA(),
            ]);
        }catch (Exception $e){
            die ($e->getMessage());
        }
    }
    public function eliminar ($idA) {
        try {
            $sql = "DELETE FROM area WHERE idA =?";
            $this->area->prepare($sql)->execute([$idA]);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
    public function listarr($filtro = '') {
    try {
        if ($filtro) {
            $sql = "SELECT * FROM area WHERE nombre LIKE ?";
            $stmt = $this->area->prepare($sql);
            $buscar = "%$filtro%";
            $stmt->execute([$buscar]);
        } else {
            $sql = "SELECT * FROM area";
            $stmt = $this->area->prepare($sql);
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
        die($e->getMessage());
    }
}

    public function existeNombre($nombre, $idExcluir = null) {
        $sql = "SELECT COUNT(*) FROM area WHERE nombre = ?";
        $params =[$nombre];
        if ($idExcluir){
            $sql .= " AND idA != ?";
            $params[] = $idExcluir;
        }
        $stmt = $this->area->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}