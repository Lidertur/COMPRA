<?php

error_reporting(E_ALL);
ini_set ('display_errors', 1);

require_once 'bd/Database.php';

class proveedor {
    private $proveedor;
    private $idP;
    private $it;
    private $nit;
    private $nombre;
    private $direccion;
    private $telefono;
    private $contacto;
    private $correo;
    private $producto;
    private $tipo;

    public function __construct(){
        $this->proveedor = basedeDatos::conectar();
    }

    // Getters
    public function getidP() { return $this->idP; }
    public function getit() { return $this->it; }
    public function getnit() { return $this->nit; }
    public function getnombre() { return $this->nombre; }
    public function getdireccion() { return $this->direccion; }
    public function gettelefono() { return $this->telefono; }
    public function getcontacto() { return $this->contacto; }
    public function getcorreo() { return $this->correo; }
    public function getproducto() { return $this->producto; }
    public function gettipo() { return $this->tipo; }

    // Setters
    public function setidP($idP) { $this->idP = $idP; }
    public function setit($it) { $this->it = $it; }
    public function setnit($nit) { $this->nit = $nit; }
    public function setnombre($nombre) { $this->nombre = $nombre; }
    public function setdireccion($direccion) { $this->direccion = $direccion; }
    public function settelefono($telefono) { $this->telefono = $telefono; }
    public function setcontacto($contacto) { $this->contacto = $contacto; }
    public function setcorreo($correo) { $this->correo = $correo; }
    public function setproducto($producto) { $this->producto = $producto; }
    public function settipo($tipo) { $this->tipo = $tipo; }

    public function listar(){
        try{
            $consulta = $this->proveedor->prepare("SELECT * FROM proveedor;");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
    public function crear(proveedor $p) {
        try {
            $sql = "INSERT INTO proveedor (it, nit, nombre, direccion, telefono, contacto, correo, producto, tipo)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $this->proveedor->prepare($sql)->execute([
                $p->getit(),
                $p->getnit(),
                $p->getnombre(),
                $p->getdireccion(),
                $p->gettelefono(),
                $p->getcontacto(),
                $p->getcorreo(),
                $p->getproducto(),
                $p->gettipo()
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function actualizar(proveedor $p) {
        try {
            $sql = "UPDATE proveedor SET it=?, nit=?, nombre=?, direccion=?, telefono=?, contacto=?, correo=?, producto=?, tipo=?
                    WHERE idP=?";
            $this->proveedor->prepare($sql)->execute([
                $p->getit(),
                $p->getnit(),
                $p->getnombre(),
                $p->getdireccion(),
                $p->gettelefono(),
                $p->getcontacto(),
                $p->getcorreo(),
                $p->getproducto(),
                $p->gettipo(),
                $p->getidP()
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function eliminar($idP) {
        try {
            $sql = "DELETE FROM proveedor WHERE idP = ?";
            $this->proveedor->prepare($sql)->execute([$idP]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function listarr($filtro = '') {
        try {
            if ($filtro) {
                $sql = "SELECT * FROM proveedor WHERE 
                            nombre LIKE ? OR 
                            nit LIKE ? OR 
                            producto LIKE ?";
                $stmt = $this->proveedor->prepare($sql);
                $buscar = "%$filtro%";
                $stmt->execute([$buscar, $buscar, $buscar]);
            } else {
                $stmt = $this->proveedor->prepare("SELECT * FROM proveedor");
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function existeNit($nit, $idExcluir = null) {
        $sql = "SELECT COUNT(*) FROM proveedor WHERE nit = ?";
        $params = [$nit];

        if ($idExcluir) {
            $sql .= " AND idP != ?";
            $params[] = $idExcluir;
        }

        $stmt = $this->proveedor->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

}
