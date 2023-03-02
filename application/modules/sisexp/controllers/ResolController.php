<?php
require_once (APPLICATION_PATH . "/bridge/JavaBridge/java/Java.inc");
class Sisexp_ResolController extends Zend_Controller_Action
{
	public $rol;
	public $usuid;
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
	public function hextrasAction()
    {
        //$this->_helper->layout()->disableLayout();
        $this->view->pdfReporte = '/siswebrceo/application/modules/sisexp/anuncios/hextras.pdf';
    }
    public function afamiliaresAction()
    {
    	//$this->_helper->layout()->disableLayout();
    	$this->view->pdfReporte = '/siswebrceo/application/modules/sisexp/anuncios/afamiliares.pdf';
    }
    public function scortasAction()
    {
    	//$this->_helper->layout()->disableLayout();
    	$this->view->pdfReporte = '/siswebrceo/application/modules/sisexp/anuncios/scortas.pdf';
    }
	public function provalAction()
    {
    	//$this->_helper->layout()->disableLayout();
    	$this->view->pdfReporte = '/siswebrceo/application/modules/sisexp/anuncios/procedimiento_validacion.pdf';
    }
}