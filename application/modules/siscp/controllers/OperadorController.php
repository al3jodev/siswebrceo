<?php
require_once APPLICATION_PATH . '/modules/siscp/models/Siscp_Model_Table_Operador.php';
class Siscp_OperadorController extends Zend_Controller_Action
{
	public function init()
	{
		$session = Zend_Auth::getInstance();
		$dataSesion = $session->getStorage()->read();
		$nombre = $dataSesion->usu_firstname;
		$apellido = $dataSesion->usu_lastname;
		$this->view->nameuser = $nombre." ".$apellido;
	}

    public function ingoperadorAction()
    {
    }
    
	public function guardaroperadorAction() 
	{
	  $cedula               =$this->getRequest()->getParam('cedula');
	  $nombresop            =$this->getRequest()->getParam('nombresop');
	  $apellidosop          =$this->getRequest()->getParam('apellidosop');
	  $ciudad               =$this->getRequest()->getParam('ciudad');
	  $operadorModel = new Siscp_Model_Table_Operador();				
	  $msj = $operadorModel->createOperador($cedula,$nombresop,$apellidosop,$ciudad,'Activo');
	  echo $msj;
	  exit;
	}
	public function conoperadorAction()
    {
    	
    }
    
    public function buscaroperadoresAction()
    {
    	$operadorModel = new Siscp_Model_Table_Operador();
    	$data = new Zend_Dojo_Data ( 'op_cedula', $operadorModel->getTodosOperadores() );
		$json = new Zend_Json ( );
	    if(count($data) > 0){
				$json = new Zend_Json ( );
				echo $json->encode ($data);
		}else{
			$data->clearItems();
			$json = new Zend_Json ( );
			echo $json->encode ($data);
		}
		exit();
    }
    
	public function buscaroperadoresxciudadAction()
    {
    	$ciudad        =$this->getRequest()->getParam('ciudad');
    	$operadorModel = new Siscp_Model_Table_Operador();
    	$data = new Zend_Dojo_Data ( 'op_id', $operadorModel->getOperadoresxciudad($ciudad) );
		$json = new Zend_Json ();
	    if(count($data) > 0){
				$json = new Zend_Json ( );
				echo $json->encode ($data);
		}else{
			$data->clearItems();
			$json = new Zend_Json ( );
			echo $json->encode ($data);
		}
		exit();
    }
	public function buscaroperadoridAction()
    {
		$codigoop  = $this->getRequest()->getParam('idop');		
		$operadorModel = new Siscp_Model_Table_Operador( );
		$data = new Zend_Dojo_Data ('op_id', $operadorModel->getOperadorxId($codigoop));
		if(count($data) > 0){
			$json = new Zend_Json ( );
			echo $json->encode ($data);
		}else{
			$data->clearItems();
			$json = new Zend_Json ( );
			echo $json->encode ($data);
		}
		exit();
    }
	public function actualizaroperadorAction() 
	{
	  $cedula              =$this->getRequest()->getParam('cedula');
	  $apellidosop         =$this->getRequest()->getParam('apellidosop');
	  $nombresop           =$this->getRequest()->getParam('nombresop');
	  $ciudad              =$this->getRequest()->getParam('ciudad');
	  $idop                =$this->getRequest()->getParam('idop');
	  $operadorModel = new Siscp_Model_Table_Operador();				
	  $msj = $operadorModel->updateOperador($cedula,$apellidosop,$nombresop,$ciudad,$idop);
	  echo $msj;
	  exit;
	}
	
	public function eliminaroperadorAction()
    {
    	$idop = $this->getRequest()->getParam('idop');
		$operadorModel = new Siscp_Model_Table_Operador( );
		$msj = $operadorModel->eliminarOperador($idop);
		echo $msj;
		exit;
    }
}