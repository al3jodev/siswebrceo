<?php
require_once APPLICATION_PATH . '/modules/sisced/models/Sisced_Model_Table_Validacion.php';
require_once (APPLICATION_PATH . "/bridge/JavaBridge/java/Java.inc");

class Sisexp_PartidasController extends Zend_Controller_Action
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
		$this->year = date("y");
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
    
    public function rptsolicitudAction()
    {
    }
    public function getprovinciaxfechaAction()
    {
    	$fecha   =$this->getRequest()->getParam('fecha');
    
    	$valModel = new Sisced_Model_Table_Validacion();
    	$data = new Zend_Dojo_Data ( 'val_id',$valModel->getProvinciaxfecha($fecha));
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
    public function imprptsolicitudesAction()
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
    		$dirReporte = APPLICATION_PATH .'/modules/sisced/reports/';
    		$jrDirLib = APPLICATION_PATH .'/lib_reports/';
    		$pdfReporte = 'rptsolicitudes';
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
    			$connexion->setConnectString('jdbc:postgresql://localhost:5432/bd_swrceo');
    			$connexion->setUser('postgres');
    			$connexion->setPassword('allsoft');
    			$parametro->put('SUBREPORT_DIR', new Java('java.lang.String', $dirReporte));
    			$parametro->put('DIRECCION_LOGO', new Java('java.lang.String', 'c:/xampp/htdocs/siswebrceo/public/imagenes/logo_main1.jpg'));
    			$parametro->put('FECI', new Java('java.util.Date', $feci->toString('MM/dd/y')));
    			$parametro->put('FECF', new Java('java.util.Date', $fecf->toString('MM/dd/y')));
    			$parametro->put('MES', New Java('java.lang.String',$namemes));
    			$irptFactura = $crearReporte->fillReportToFile($dirReporte . $pdfReporte . '.jasper', $parametro, $connexion->getConnection());
    			$exportaRepote->exportReportToPdfFile($irptFactura, $dirReporte . $pdfReporte . '.pdf');
    			if (file_exists($dirReporte . $pdfReporte . '.pdf')) {
    				$this->view->pdfReporte = '/siswebrceo/application/modules/sisced/reports/'. $pdfReporte.'.pdf';
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