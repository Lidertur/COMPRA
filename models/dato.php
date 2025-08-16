<?php

error_reporting(E_ALL);
ini_set ('display_errors', 1);

require_once 'bd/Database.php';

class dato {
    private $dato;
    private $idD;
    private $it;
    private $oc;
    private $itoc;
    private $fecha;
    private $tipo;
    private $descripcion;
    private $cantidad;
    private $valor;
    private $descuento;
    private $total;
    private $abono;
    private $afecha;
    private $apor;
    private $observacion;
    private $nelectronica;
    private $idU;
    private $idP;
    private $idM;

    public function __construct(){
        $this->dato = basedeDatos::conectar();
    }

     // Getters
        public function getidD() { return $this->idD; }
        public function getit() { return $this->it; }
        public function getoc() { return $this->oc; }
        public function getitoc() { return $this->itoc; }
        public function getfecha() { return $this->fecha; }
        public function gettipo() { return $this->tipo; }
        public function getdescripcion() { return $this->descripcion; }
        public function getcantidad() { return $this->cantidad; }
        public function getvalor() { return $this->valor; }
        public function getdescuento() { return $this->descuento; }
        public function gettotal() { return $this->total; }
        public function getabono() { return $this->abono; }
        public function getafecha() { return $this->afecha; }
        public function getapor() { return $this->apor; }
        public function getobservacion() { return $this->observacion; }
        public function getnelectronica() { return $this->nelectronica; }
        public function getidU() { return $this->idU; }
        public function getidP() { return $this->idP; }
        public function getidM() { return $this->idM; }

    // Setters
        public function setidD($idD) { $this->idD = $idD; }
        public function setit($it) { $this->it = $it; }
        public function setoc($oc) { $this->oc = $oc; }
        public function setitoc($itoc) { $this->itoc = $itoc; }
        public function setfecha($fecha) { $this->fecha = $fecha; }
        public function settipo($tipo) { $this->tipo = $tipo; }
        public function setdescripcion($descripcion) { $this->descripcion = $descripcion; }
        public function setcantidad($cantidad) { $this->cantidad = $cantidad; }
        public function setvalor($valor) { $this->valor = $valor; }
        public function setdescuento($descuento) { $this->descuento = $descuento; }
        public function settotal($total) { $this->total = $total; }
        public function setabono($abono) { $this->abono = $abono; }
        public function setafecha($afecha) { $this->afecha = $afecha; }
        public function setapor($apor) { $this->apor = $apor; }
        public function setobservacion($observacion) { $this->observacion = $observacion; }
        public function setnelectronica($nelectronica) { $this->nelectronica = $nelectronica; }
        public function setidU($idU) { $this->idU = $idU; }
        public function setidP($idP) { $this->idP = $idP; }
        public function setidM($idM) { $this->idM = $idM; }

    public function listar(){
        try{
            $consulta = $this->dato->prepare("SELECT * FROM dato;");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
    public function crear(dato $d) {
        try {
            $sql = "INSERT INTO dato (it, oc, itoc, fecha, tipo, descripcion, cantidad, valor, descuento, total, abono, afecha, apor, observacion, nelectronica, idU, idP, idM)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $this->dato->prepare($sql)->execute([
                $d->getit(),
                $d->getoc(),
                $d->getitoc(),
                $d->getfecha(),
                $d->gettipo(),
                $d->getdescripcion(),
                $d->getcantidad(),
                $d->getvalor(),
                $d->getdescuento(),
                $d->gettotal(),
                $d->getabono(),
                $d->getafecha(),
                $d->getapor(),
                $d->getobservacion(),
                $d->getnelectronica(),
                $d->getidU(),
                $d->getidP(),
                $d->getidM()
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function actualizar(dato $d) {
        try {
            $sql = "UPDATE dato SET it=?, oc=?, itoc=?, fecha=?, tipo=?, descripcion=?, cantidad=?, valor=?, descuento=?, total=?, abono=?, afecha=?, apor=?, observacion=?, nelectronica=?, idU=?, idP=?, idM=? 
                    WHERE idD=?";
            $this->dato->prepare($sql)->execute([
                $d->getit(),
                $d->getoc(),
                $d->getitoc(),
                $d->getfecha(),
                $d->gettipo(),
                $d->getdescripcion(),
                $d->getcantidad(),
                $d->getvalor(),
                $d->getdescuento(),
                $d->gettotal(),
                $d->getabono(),
                $d->getafecha(),
                $d->getapor(),
                $d->getobservacion(),
                $d->getnelectronica(),
                $d->getidU(),
                $d->getidP(),
                $d->getidM(),
                $d->getidD()
            ]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function eliminar($idD) {
        try {
            $sql = "DELETE FROM dato WHERE idD = ?";
            $this->dato->prepare($sql)->execute([$idD]);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function listarr($filtro = '') {
        try {
            if ($filtro) {
                $sql = "SELECT * FROM dato WHERE descripcion LIKE ? OR tipo LIKE ? OR it LIKE ? OR fecha LIKE ? OR valor LIKE ?";
                $stmt = $this->dato->prepare($sql);
                $buscar = "%$filtro%";
                $stmt->execute([$buscar, $buscar]);
            } else {
                $stmt = $this->dato->prepare("SELECT * FROM dato");
                $stmt->execute();
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    public function existeIt($it, $idExcluir = null) {
        $sql = "SELECT COUNT(*) FROM dato WHERE it = ?";
        $params = [$it];

        if ($idExcluir) {
            $sql .= " AND idD != ?";
            $params[] = $idExcluir;
        }
        $stmt = $this->dato->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
    public function generarNuevaOC() {
        $sql = "SELECT MAX(oc) as ultima_oc FROM dato";
        $consulta = $this->dato->prepare($sql);
        $consulta->execute();
        $fila = $consulta->fetch(PDO::FETCH_ASSOC);
        $ultimaOC = $fila['ultima_oc'] ?? 0;
        return $ultimaOC + 1;
    }
    public function generarSiguienteIT($oc) {
        $sql = "SELECT MAX(it) as ultimo_it FROM dato WHERE oc = ?";
        $consulta = $this->dato->prepare($sql);
        $consulta->execute([$oc]);
        $fila = $consulta->fetch(PDO::FETCH_ASSOC);
        $ultimoIT = $fila['ultimo_it'] ?? 0;
        return $ultimoIT + 1;
    }
    public function obtenerUltimaOC() {
        $sql = "SELECT MAX(oc) as ultima_oc FROM dato";
        $consulta = $this->dato->prepare($sql);
        $consulta->execute();
        $fila = $consulta->fetch(PDO::FETCH_ASSOC);
        return $fila['ultima_oc'] ?? 1;
    }
}