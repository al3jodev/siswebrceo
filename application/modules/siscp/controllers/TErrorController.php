<?php
require_once APPLICATION_PATH . '/modules/siscp/models/Siscp_Model_Table_TError.php';
class Siscp_TErrorController extends Zend_Controller_Action
{
	public function init()
	{
		$session = Zend_Auth::getInstance();
		$dataSesion = $session->getStorage()->read();
		$nombre = $dataSesion->usu_firstname;
		$apellido = $dataSesion->usu_lastname;
		$this->view->nameuser = $nombre." ".$apellido;
	}

	public function guardarerrorAction() 
	{
	  $tipoerror             =$this->getRequest()->getParam('tipoerror');
	  $descripcion           =$this->getRequest()->getParam('descripcion');
	  $errorModel = new Siscp_Model_Table_TError();				
	  $msj = $errorModel->createError($tipoerror,$descripcion);
	  echo $msj;
	  exit;
	}
	public function getterroresAction()
    {
    	$errorModel = new Siscp_Model_Table_TError();
    	$data = new Zend_Dojo_Data ( 'te_id', $errorModel->getTodosErrores() );
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
}