<?php
require_once (APPLICATION_PATH . "/bridge/JavaBridge/java/Java.inc");
require_once APPLICATION_PATH . '/modules/siscrh/models/Siscrh_Model_Table_Permiso.php';
class Siscrh_PermisoController extends Zend_Controller_Action
{
	public $rol;
	public $usuid;
	public $fecha;
	public $hora;
	public $autorizado;
	
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
			$this->setAutorizado($nombre." ".$apellido);
		}
		
	}
	public function getAutorizado() {
		return $this->autorizado;
	}
	
	public function setAutorizado($autorizado) {
		$this->autorizado = $autorizado;
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
	public function aprpermisoAction()
    {
    }
    public function getFecha() {
    	$this->fecha = new Zend_Date();
    	$this->fecha = date("Y-m-d", $this->fecha->getTimestamp());
    	return $this->fecha;
    }
    
	public function getHora() {
		date_default_timezone_set('America/Guayaquil');
    	$this->hora = new Zend_Date();
    	$this->hora = date("H:i a");
    	return $this->hora;
    }
	public function savepermisoAction()
	{
		$hora       =$this->getRequest()->getParam('horasalida');
		$fpermiso   =$this->getRequest()->getParam('fechapermiso');
		$apelnom    =$this->getRequest()->getParam('apellidosper');
		$cedula     =$this->getRequest()->getParam('cedula');
		$observacion=$this->getRequest()->getParam('observaciones');
		 
		$permisoModel = new Siscrh_Model_Table_Permiso();
		$msj = $permisoModel->createPermiso($hora,$fpermiso,$apelnom,$cedula,$observacion,'Pendiente');
		echo $msj;
		exit;
	}
	public function cambiarestperAction()
	{
		$idperm       =$this->getRequest()->getParam('idperm');
		$estado       =$this->getRequest()->getParam('estado');
		$permisoModel = new Siscrh_Model_Table_Permiso();
		if($estado == 'Impreso'){
			$msj = $permisoModel->updatePermiso($idperm,$estado,$this->getHora());	
		}elseif($estado == 'Cerrado'){
			$msj = $permisoModel->updatePermisoCierre($idperm,$estado,$this->getHora());
		} 
		
		echo $msj;
		exit;
	}
	
	public function buscarpermisosAction()
	{
		$permisoModel = new Siscrh_Model_Table_Permiso();
		$data = new Zend_Dojo_Data ('perm_id',$permisoModel->getPermisosfecxestado($this->getFecha()));
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
	public function cierrepermisosAction()
	{
		$permisoModel = new Siscrh_Model_Table_Permiso();
		$data = new Zend_Dojo_Data ( 'perm_id',$permisoModel->getPermisosfecxestadocerrado($this->getFecha(),$this->getAutorizado()));
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
	public function impticketAction()
	{
		//$this->_helper->layout()->disableLayout();
		$print = false;
		if($this->_hasParam('id')){
			$id = $this->getRequest()->getParam('id');
            $print = true;
		}
		if($print){
			$dirReporte = APPLICATION_PATH .'/modules/siscrh/reports/';
			$jrDirLib = APPLICATION_PATH .'/lib_reports/';
			$pdfReporte = 'tckpermiso';
			$archivo = '';
			$directorio = opendir($jrDirLib);
			 
			while (($lib = readdir($directorio)) !== false) {
				$archivo .= 'file:' . $jrDirLib . '/' . $lib . ';';
			}
	
			try {
				java_require($archivo);
				$connexion = new Java('org.altic.jasperReports.JdbcConnection');
				$crearReporte = new JavaClass('net.sf.jasperreports.engine.JasperFillManager');
				$exportaRepote = new JavaClass('net.sf.jasperreports.engine.JasperExportManager');
				$parametro = new Java("java.util.HashMap");
				$connexion->setDriver('org.postgresql.Driver');
				$connexion->setConnectString('jdbc:postgresql://10.7.6.250:5432/bdswrceo1');
				$connexion->setUser('postgres');
				$connexion->setPassword('Magna2011');
				$parametro->put('SUBREPORT_DIR', new Java('java.lang.String', $dirReporte));
				$parametro->put('DIRECCION_LOGO', new Java('java.lang.String', 'c:/xampp/htdocs/siswebrceo/public/imagenes/logo_main1.jpg'));
				$parametro->put('ID', new Java('java.lang.Long', (int)$id));
				$irptFactura = $crearReporte->fillReportToFile($dirReporte . $pdfReporte . '.jasper', $parametro, $connexion->getConnection());
				$exportaRepote->exportReportToPdfFile($irptFactura, $dirReporte . $pdfReporte . '.pdf');
				if (file_exists($dirReporte . $pdfReporte . '.pdf')) {
					$this->view->pdfReporte = '/siswebrceo/application/modules/siscrh/reports/'. $pdfReporte.'.pdf';
				}else{
					echo "No se encuentra el archivo.";
					exit();
				}
			} catch (Exception $ex) {
				echo $ex->getMessage();
			}
		}else{
			echo "PARAMETROS INCORRECTOS";
			exit();
		}
	}
	
	public function rptsalcortasAction()
	{
	}
	public function buscarpermisosxfechaAction()
	{
		$fechadesde   =$this->getRequest()->getParam('fechadesde');
		$fechahasta   =$this->getRequest()->getParam('fechahasta');
			
		$permisoModel = new Siscrh_Model_Table_Permiso();
		$data = new Zend_Dojo_Data ( 'perm_id',$permisoModel->getPermisosxrangofechas($fechadesde,$fechahasta));
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
	public function imprptsalcortasAction()
	{
		//$this->_helper->layout()->disableLayout();
		$fd = null;
		$fa = null;
		$print = false;
		if($this->_hasParam('fd')){
			$fd = $this->getRequest()->getParam('fd');
			if($this->_hasParam('fh')){
				$fh = $this->getRequest()->getParam('fh');
			$print = true;
			}
		}
		$feci = new Zend_Date($fd);
		$fecf = new Zend_Date($fh);
		$namemes = 'DESDE '.$feci->toString('MM/dd/y').' HASTA '.$fecf->toString('MM/dd/y');
		if($print){
			$dirReporte = APPLICATION_PATH .'/modules/siscrh/reports/';
			$jrDirLib = APPLICATION_PATH .'/lib_reports/';
			$pdfReporte = 'rptsalidasc';
			$archivo = '';
			$directorio = opendir($jrDirLib);
		
			while (($lib = readdir($directorio)) !== false) {
				$archivo .= 'file:' . $jrDirLib . '/' . $lib . ';';
			}
		
			try {
				java_require($archivo);
				$connexion = new Java('org.altic.jasperReports.JdbcConnection');
				$crearReporte = new JavaClass('net.sf.jasperreports.engine.JasperFillManager');
				$exportaRepote = new JavaClass('net.sf.jasperreports.engine.JasperExportManager');
				$parametro = new Java("java.util.HashMap");
				$connexion->setDriver('org.postgresql.Driver');
				$connexion->setConnectString('jdbc:postgresql://10.7.6.250:5432/bdswrceo1');
				$connexion->setUser('postgres');
				$connexion->setPassword('Magna2011');
				$parametro->put('SUBREPORT_DIR', new Java('java.lang.String', $dirReporte));
				$parametro->put('DIRECCION_LOGO', new Java('java.lang.String', 'c:/xampp/htdocs/siswebrceo/public/imagenes/logo_main1.jpg'));
				$parametro->put('FECI', new Java('java.util.Date', $feci->toString('MM/dd/y')));
	            $parametro->put('FECF', new Java('java.util.Date', $fecf->toString('MM/dd/y')));
	            $parametro->put('MES', New Java('java.lang.String',$namemes));
				$irptFactura = $crearReporte->fillReportToFile($dirReporte . $pdfReporte . '.jasper', $parametro, $connexion->getConnection());
				$exportaRepote->exportReportToPdfFile($irptFactura, $dirReporte . $pdfReporte . '.pdf');
				if (file_exists($dirReporte . $pdfReporte . '.pdf')) {
					$this->view->pdfReporte = '/siswebrceo/application/modules/siscrh/reports/'. $pdfReporte.'.pdf';
				}else{
					echo "No se encuentra el archivo.";
					exit();
				}
			} catch (Exception $ex) {
				echo $ex->getMessage();
			}
		}else{
			echo "PARAMETROS INCORRECTOS";
			exit();
		}
	}
}