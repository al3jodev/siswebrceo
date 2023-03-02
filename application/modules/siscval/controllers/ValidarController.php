<?php
require_once APPLICATION_PATH . '/modules/siscval/models/Siscval_Model_Table_Validacion.php';

class Siscval_ValidarController extends Zend_Controller_Action
{
	private $fecha;
	private $day;
	
	public function getFecha() {
		$this->fecha = new Zend_Date();
		$this->fecha = date("Y-m-d", $this->fecha->getTimestamp());
		return $this->fecha;
	}
	public function getDay() {
		$this->day = new Zend_Date();
		$this->day = date("d");
		return $this->day;
	}
	public function getYear() {
		$this->year = new Zend_Date();
		$this->year = date("Y");
		return $this->year;
	}
	public function setRol($rol) {
		$this->rol = $rol;
	}
	public function getRol() {
		return $this->rol;
	}
	public function setUsuid($usuid) {
		$this->usuid = $usuid;
	}
	
	public function getUsuid() {
		return $this->usuid;
	}
	public function init()
	{
		if(!Zend_Auth::getInstance()->hasIdentity()){
	        $this->_redirect('index');
		}else{
			$session = Zend_Auth::getInstance();
			$dataSesion = $session->getStorage()->read();
			$this->setUsuid($dataSesion->usu_id);
			$this->setRol($dataSesion->usu_rol);
			$nombre = $dataSesion->usu_firstname;
			$apellido = $dataSesion->usu_lastname;
			$this->view->nameuser = $nombre." ".$apellido;
		}
	}
    public function indexAction()
    {
		
    }
    public function ingsolicitudAction()
    {
    	$valmodel = new Siscval_Model_Table_Validacion();
    	$numfilas = $valmodel->numsolicitud();
    	$this->view->nrosol = '07'.(string)(count($numfilas)+1).$this->getDay().$this->getYear();
    }
    public function guardarsolicitudAction()
    {
    	$piusuario = $this->getRequest ()->getParam ( 'piusuario' );
		$pipadre = $this->getRequest ()->getParam ( 'pipadre' );
		$pimadre = $this->getRequest ()->getParam ( 'pimadre' );
		$piconyuge = $this->getRequest ()->getParam ( 'piconyuge' );
		$valusuario = $this->getRequest ()->getParam ( 'valusuario' );
		$valpadre = $this->getRequest ()->getParam ( 'valpadre' );
		$valmadre = $this->getRequest ()->getParam ( 'valmadre' );
		$valconyuge = $this->getRequest ()->getParam ( 'valconyuge' );
		$tipocedulacion = $this->getRequest ()->getParam ( 'tipocedulacion' );
		$cedusuario = $this->getRequest ()->getParam ( 'cedusuario' );
		$apenomusu = $this->getRequest ()->getParam ( 'apenomusu' );
		$provusuario = $this->getRequest ()->getParam ( 'provusuario' );
		$tipociusuario = $this->getRequest ()->getParam ( 'tipociusuario' );
		$cedpadre = $this->getRequest ()->getParam ( 'cedpadre' );
		$apenompadre = $this->getRequest ()->getParam ('apenompadre' );
		$provpadre = $this->getRequest ()->getParam ( 'provpadre' );
		$tipocipadre = $this->getRequest ()->getParam ( 'tipocipadre' );
		$cedmadre = $this->getRequest ()->getParam ( 'cedmadre' );
		$apenommadre = $this->getRequest ()->getParam ( 'apenommadre' );
		$provmadre = $this->getRequest ()->getParam ( 'provmadre' );
		$tipocimadre = $this->getRequest ()->getParam ( 'tipocimadre' );
		$cedconyuge = $this->getRequest ()->getParam ( 'cedconyuge' );
		$apenomconyuge = $this->getRequest ()->getParam ( 'apenomconyuge' );
		$provconyuge = $this->getRequest ()->getParam ( 'provconyuge' );
		$tipociconyuge = $this->getRequest ()->getParam ( 'tipociconyuge' );
		$telefono = $this->getRequest ()->getParam ( 'telefono' );
		$observacion = $this->getRequest ()->getParam ( 'observacion' );
		$correoe = $this->getRequest ()->getParam ( 'correoe' );
		$fechares = $this->getRequest ()->getParam ( 'fechares' );
		$numsol = $this->getRequest ()->getParam ( 'numsol' );
    	
		$valmodel = new Siscval_Model_Table_Validacion();
		
    	if($piusuario == 'true'){
    		$msj = $valmodel->createSolicitud($numsol,$tipocedulacion,$valusuario,$cedusuario,$apenomusu,$provusuario,$tipociusuario,$telefono,$correoe,$this->getFecha(),$fechares,$observacion,'Pedida',$this->getUsuid());
    	}
    	if($pipadre == 'true')
    	{
    		$msj = $valmodel->createSolicitudFam($numsol,$valpadre,$cedpadre,$apenompadre,$provpadre,$tipocipadre,$this->getFecha(),$fechares,'Pedida',$this->getUsuid());
    	}
    	if($pimadre == 'true'){
    		$msj = $valmodel->createSolicitudFam($numsol,$valmadre,$cedmadre,$apenommadre,$provmadre,$tipocimadre,$this->getFecha(),$fechares,'Pedida',$this->getUsuid());
    	}
    	if($piconyuge == 'true'){
    		$msj = $valmodel->createSolicitudFam($numsol,$valconyuge,$cedconyuge,$apenomconyuge,$provconyuge,$tipociconyuge,$this->getFecha(),$fechares,'Pedida',$this->getUsuid());
    		
    	}
    	echo $msj;
    	exit;
    }
}