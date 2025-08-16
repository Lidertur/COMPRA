<?php

error_reporting(E_ALL);
ini_set ('display_errors', 1);

require_once 'bd/Database.php';

class calificacion {

private $calificacion;
private $idC;
private $precio;
private $garantia;
private $disponibilidad;
private $plazos;
private $respuesta;
private $calidad;
private $sg_sst;
private $parafiscales;
private $certificaciones;
private $ambiental;
private $anticorrupcion;
private $rs;
private $sostenible;
private $agregado;
private $tcalificacion;
private $idD;

    public function __construct(){
        $this->calificacion = basedeDatos::conectar();
    }
    // Getters
    public function getidC() { return $this->idC; }
    public function getprecio() { return $this->precio; }
    public function getgarantia() { return $this->garantia; }
    public function getdisponibilidad() { return $this->disponibilidad; }
    public function getplazos() { return $this->plazos; }
    public function getrespuesta() { return $this->respuesta; }
    public function getcalidad() { return $this->calidad; }
    public function getsg_sst() { return $this->sg_sst; }
    public function getparafiscales() { return $this->parafiscales; }
    public function getcertificaciones() { return $this->certificaciones; }
    public function getambiental() { return $this->ambiental; }
    public function getanticorrupcion() { return $this->anticorrupcion; }
    public function getrs() { return $this->rs; }
    public function getsostenible() { return $this->sostenible; }
    public function getagregado() { return $this->agregado; }
    public function gettcalificacion() { return $this->tcalificacion; }
    public function getidD() { return $this->idD; }

    // Setters
    public function setidC($idC) { $this->idC = $idC; }
    public function setprecio($precio) { $this->precio = $precio; }
    public function setgarantia($garantia) { $this->garantia = $garantia; }
    public function setdisponibilidad($disponibilidad) { $this->disponibilidad = $disponibilidad; }
    public function setplazos($plazos) { $this->plazos = $plazos; }
    public function setrespuesta($respuesta) { $this->respuesta = $respuesta; }
    public function setcalidad($calidad) { $this->calidad = $calidad; }
    public function setsg_sst($sg_sst) { $this->sg_sst = $sg_sst; }
    public function setparafiscales($parafiscales) { $this->parafiscales = $parafiscales; }
    public function setcertificaciones($certificaciones) { $this->certificaciones = $certificaciones; }
    public function setambiental($ambiental) { $this->ambiental = $ambiental; }
    public function setanticorrupcion($anticorrupcion) { $this->anticorrupcion = $anticorrupcion; }
    public function setrs($rs) { $this->rs = $rs; }
    public function setsostenible($sostenible) { $this->sostenible = $sostenible; }
    public function setagregado($agregado) { $this->agregado = $agregado; }
    public function settcalificacion($tcalificacion) { $this->tcalificacion = $tcalificacion; }
    public function setidD($idD) { $this->idD = $idD; }

    public function listar(){
        try{
            $consulta = $this->calificacion->prepare("SELECT * FROM calificacion;");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }catch (Exception $e){
            die($e->getMessage());
        }
    }
}