<?php

error_reporting(E_ALL);
ini_set ('display_errors', 1);

require_once 'bd/Database.php';

class movil {
    private $movil;    
    private $idM;
    private $nmovil;
    private $placa;


     public function __construct(){
        $this->movil = basedeDatos::conectar();
    }
    // Getters
    public function getidM() { return $this->idM; }
    public function getnmovil() { return $this->nmovil; }
    public function getplaca() { return $this->placa; }

    // Setters
    public function setidM($idM) { $this->idM = $idM; }
    public function setnmovil($nmovil) { $this->nmovil = $nmovil; }
    public function setplaca($placa) { $this->placa = $placa; }

    public function listar(){
        try{
            $consulta = $this->movil->prepare("SELECT *FROM movil;");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
    public function crear(movil $p) {
        try {
            $sql = "INSERT INTO movil (nmovil, placa)
                    VALUES (?, ?)";
            $this->movil->prepare($sql)->execute([
                $p->getnmovil(),
                $p->getplaca(),
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
     public function actualizar(movil $p) {
        try {
            $sql = "UPDATE movil SET nmovil=?, placa=? WHERE idM=?";
            $this->movil->prepare($sql)->execute([
                $p->getnmovil(),
                $p->getplaca(),
                
                $p->getidM()
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function eliminar($idM) {
        try {
            $sql = "DELETE FROM movil WHERE idM = ?";
            $this->movil->prepare($sql)->execute([$idM]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function listarr($filtro = '') {
        try {
            if ($filtro) {
                $sql = "SELECT * FROM movil WHERE 
                            nmovil LIKE ? OR 
                            placa LIKE ? ";
                $stmt = $this->movil->prepare($sql);
                $buscar = "%$filtro%";
                $stmt->execute([$buscar, $buscar, $buscar]);
            } else {
                $stmt = $this->movil->prepare("SELECT * FROM movil");
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function existePlaca($placa, $idExcluir = null) {
        $sql = "SELECT COUNT(*) FROM movil WHERE placa = ?";
        $params = [$placa];

        if ($idExcluir) {
            $sql .= " AND idM != ?";
            $params[] = $idExcluir;
        }
        $stmt = $this->movil->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

}