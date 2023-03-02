<?php

class Siscrh_IndexController extends Zend_Controller_Action
{
	public function init()
	{
		$session = Zend_Auth::getInstance();
		$dataSesion = $session->getStorage()->read();
		$nombre = $dataSesion->usu_firstname;
		$apellido = $dataSesion->usu_lastname;
		$this->view->nameuser = $nombre." ".$apellido;
	}
    public function indexAction()
    {
		
    }
}