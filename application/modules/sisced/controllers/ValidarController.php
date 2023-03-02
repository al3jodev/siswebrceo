<?php
require_once APPLICATION_PATH . '/modules/sisced/models/Sisced_Model_Table_Validacion.php';
require_once (APPLICATION_PATH . "/bridge/JavaBridge/java/Java.inc");

class Sisced_ValidarController extends Zend_Controller_Action
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
    public function indexAction()
    {
		
    }
    public function ingsolicitudAction()
    {
    	$valmodel = new Sisced_Model_Table_Validacion();
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
		$asusuario = $this->getRequest ()->getParam ( 'asusuario' );
		$aspadre = $this->getRequest ()->getParam ( 'aspadre' );
		$asmadre = $this->getRequest ()->getParam ( 'asmadre' );
		$asconyuge = $this->getRequest ()->getParam ( 'asconyuge' );
    	
		$valmodel = new Sisced_Model_Table_Validacion();
		
    	if($piusuario == 'true'){
    		$msj = $valmodel->createSolicitud($numsol,$tipocedulacion,$valusuario,$cedusuario,$apenomusu,$provusuario,$tipociusuario,$telefono,$correoe,$this->getFecha(),$fechares,$observacion,'Pedida',$this->getUsuid(),$asusuario);
    	}
    	if($pipadre == 'true')
    	{
    		$msj = $valmodel->createSolicitudFam($numsol,$valpadre,$cedpadre,$apenompadre,$provpadre,$tipocipadre,$this->getFecha(),$fechares,'Pedida',$this->getUsuid(),$aspadre);
    	}
    	if($pimadre == 'true'){
    		$msj = $valmodel->createSolicitudFam($numsol,$valmadre,$cedmadre,$apenommadre,$provmadre,$tipocimadre,$this->getFecha(),$fechares,'Pedida',$this->getUsuid(),$asmadre);
    	}
    	if($piconyuge == 'true'){
    		$msj = $valmodel->createSolicitudFam($numsol,$valconyuge,$cedconyuge,$apenomconyuge,$provconyuge,$tipociconyuge,$this->getFecha(),$fechares,'Pedida',$this->getUsuid(),$asconyuge);
    		
    	}
    	echo $msj;
    	exit;
    }
    public function consulsolicitudAction()
    {
    }
    
    public function buscarsolicitudesAction()
    {
    	$validarModel = new Sisced_Model_Table_Validacion();
    	$data = new Zend_Dojo_Data ('val_id',$validarModel->getSolicitudxfecha($this->getFecha()));
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
    public function buscarsolicituxcedAction()
    {
    	$cedula = $this->getRequest ()->getParam ( 'cedula' );
    	$validarModel = new Sisced_Model_Table_Validacion();
    	$data = new Zend_Dojo_Data ('val_id',$validarModel->getSolicitudxcedula($cedula));
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
    public function rptsolicitudAction()
    {
    }
    public function buscarsolicitudxfechaAction()
    {
    	$fechadesde   =$this->getRequest()->getParam('fechadesde');
    	$fechahasta   =$this->getRequest()->getParam('fechahasta');
    		
    	$valModel = new Sisced_Model_Table_Validacion();
    	$data = new Zend_Dojo_Data ( 'val_id',$valModel->getSolicitudxrangofechas($fechadesde,$fechahasta));
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