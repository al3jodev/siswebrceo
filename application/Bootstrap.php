<?php
require_once APPLICATION_PATH . '/modules/siscp/plugins/layout.php';
require_once APPLICATION_PATH . '/modules/siscrh/plugins/layout.php';
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initViewHelpers(){
			$this->bootstrap('layout');
			$layout	= $this->getResource('layout');
			$view	= $layout->getView();
			Zend_Dojo::enableView($view);
			$view->doctype('HTML4_STRICT');
			$view->headTitle('SisWEB RCEO');
		}
	protected function _initPlugins(){
		$this->bootstrap('frontController');
		$layoutPluginSiscp = new Siscp_Plugin_Layout();
		$this->frontController->registerPlugin($layoutPluginSiscp);
		/*$layoutPluginSiscrh = new Siscrh_Plugin_Layout();
		$this->frontController->registerPlugin($layoutPluginSiscrh);*/
	}
}