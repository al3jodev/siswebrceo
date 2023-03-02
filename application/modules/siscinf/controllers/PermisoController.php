<?php
require_once (APPLICATION_PATH . "/bridge/JavaBridge/java/Java.inc");
require_once APPLICATION_PATH . '/modules/siscrh/models/Siscrh_Model_Table_Permiso.php';
class Siscinf_PermisoController extends Zend_Controller_Action
{
	public $rol;
	public $usuid;
	public $nameapsu;
	
	public function getNameapsu() {
		return $this->nameapsu;
	}

	public function setNameapsu($nameapsu) {
		$this->nameapsu = $nameapsu;
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
			$this->setNameapsu($nombre." ".$apellido);
		}
		
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
	public function salcortasAction()
    {
    	$this->view->voperadores= "/siswebrceo/public/siscp/operador/buscaroperadores";
    }
    public function cierrepermisoAction()
    {
    }
	public function savepermisoAction()
	{
		$hora       =$this->getRequest()->getParam('horasalida');
		$fpermiso   =$this->getRequest()->getParam('fechapermiso');
		$apelnom    =$this->getRequest()->getParam('apellidosper');
		$cedula     =$this->getRequest()->getParam('cedula');
		$observacion=$this->getRequest()->getParam('observaciones');
		 
		$permisoModel = new Siscrh_Model_Table_Permiso();
		if($cedula != '' && $observacion != '' && $apelnom != ''){
			$msj = $permisoModel->createPermiso($hora,$fpermiso,$apelnom,$cedula,trim($observacion),'Pendiente',$this->getNameapsu());
		}else{
			$msj = 'Por favor ingrese todos los campos..!!!!';
		}
		echo $msj;
		exit;
	}
}