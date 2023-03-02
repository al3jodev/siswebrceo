<?php
require_once APPLICATION_PATH . '/modules/siscp/models/Siscp_Model_Table_TError.php';
class Siscp_ReportesController extends Zend_Controller_Action
{
	public function init()
	{
		$session = Zend_Auth::getInstance();
		$dataSesion = $session->getStorage()->read();
		$nombre = $dataSesion->usu_firstname;
		$apellido = $dataSesion->usu_lastname;
		$this->view->nameuser = $nombre." ".$apellido;
	}

	public function rptmenmachAction(){}
	
	public function verrptmenmachAction() 
	{
	 require_once (APPLICATION_PATH . "/bridge/JavaBridge/java/Java.inc");
        $this->_helper->layout()->disableLayout();
        $print = false;
        $anio = null;
        $mes = null;
        $tipo = null;
        $fd = null;
        $fa = null;
        
        if($this->_hasParam('tipo')){
            $tipo = $this->getRequest()->getParam('tipo');
	        $print = true;
        }
        if($print){
	        $dirReporte = APPLICATION_PATH .'/modules/siscp/reports/';
	        $jrDirLib = APPLICATION_PATH .'/lib_reports/';
	        $pdfReporte = 'rptmenmach';
	        $archivo = '';
	        $directorio = opendir($jrDirLib);
	        
	        while (($lib = readdir($directorio)) !== false) {
	            $archivo .= 'file:' . $jrDirLib . '/' . $lib . ';';
	        }
	        if($tipo == 'd'){
	        	$fd = $this->getRequest()->getParam('fd');
	        	$mesi = new Zend_Date($fd);
			    $mesf = new Zend_Date($fd);
	        	$namemes = 'DEL '.$mesi->toString('MM/dd/y');
	        }else if($tipo == 's'){
	        	$fd = $this->getRequest()->getParam('fi');
	        	$fa = $this->getRequest()->getParam('ff');
	        	$mesi = new Zend_Date($fd);
			    $mesf = new Zend_Date($fa);
	        	$namemes = 'DESDE  EL '.$mesi->toString('MM/dd/y').' HASTA EL '.$mesf->toString('MM/dd/y');
	        }else if($tipo == 'm'){
	        	$mes = $this->getRequest()->getParam('mes');
	        	$anio = $this->getRequest()->getParam('anio');
		        if($mes == 1){
		            $namemes = 'DEL MES DE ENERO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 2){
		            $namemes = 'DEL MES DE FEBRERO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
				     if($anio == '2012'){
			    		$mesf = new Zend_Date($anio.'-'.$mes.'-29');
			    	}else{
			    		$mesf = new Zend_Date($anio.'-'.$mes.'-28');
			    	}
		        }
		        if($mes == 3){
		            $namemes = 'DEL MES DE MARZO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 4){
		            $namemes = 'DEL MES DE ABRIL';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-30');
		        }
		        if($mes == 5){
		            $namemes = 'DEL MES DE MAYO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 6){
		            $namemes = 'DEL MES DE JUNIO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-30');
		        }
		        if($mes == 7){
		            $namemes = 'DEL MES DE JULIO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 8){
		            $namemes = 'DEL MES DE AGOSTO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 9){
		            $namemes = 'DEL MES DE SEPTIEMBRE';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-30');
		        }
		        if($mes == 10){
		            $namemes = 'DEL MES DE OCTUBRE';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 11){
		            $namemes = 'DEL MES DE NOVIEMBRE';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-30');
		        }
		        if($mes == 12){
		            $namemes = 'DEL MES DE DICIEMBRE';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
	        }
	        
	        try {
	            java_require($archivo);
	            $connexion = new Java('org.altic.jasperReports.JdbcConnection');
	            $crearReporte = new JavaClass('net.sf.jasperreports.engine.JasperFillManager');
	            $exportaRepote = new JavaClass('net.sf.jasperreports.engine.JasperExportManager');
	            $parametro = new Java("java.util.HashMap");
	            $connexion->setDriver('org.postgresql.Driver');
	            $connexion->setConnectString('jdbc:postgresql://10.7.6.250:5432/bdswrceo');
	            $connexion->setUser('postgres');
	            $connexion->setPassword('Magna2011');
	            $parametro->put('SUBREPORT_DIR', new Java('java.lang.String', $dirReporte));
	            $parametro->put('FECI', new Java('java.util.Date', $mesi->toString('MM/dd/y')));
	            $parametro->put('FECF', new Java('java.util.Date', $mesf->toString('MM/dd/y')));
	            $parametro->put('MES', New Java('java.lang.String',$namemes));
	            $parametro->put('DIRECCION_LOGO', new Java('java.lang.String', 'c:/xampp/htdocs/siswebrceo/public/imagenes/logo.png'));
	            $irptFactura = $crearReporte->fillReportToFile($dirReporte . $pdfReporte . '.jasper', $parametro, $connexion->getConnection());
	            $exportaRepote->exportReportToPdfFile($irptFactura, $dirReporte . $pdfReporte . '.pdf');
	            if (file_exists($dirReporte . $pdfReporte . '.pdf')) {
	                 $this->view->pdfReporte = '/siswebrceo/application/modules/siscp/reports/'. $pdfReporte.'.pdf';
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
	public function rptmencentAction()
    {
    }
    
	public function verrptcentroAction() 
	{
	 require_once (APPLICATION_PATH . "/bridge/JavaBridge/java/Java.inc");
        //$this->_helper->layout()->disableLayout();
        $print = false;
        $anio = null;
        $mes = null;
        $tipo = null;
        $fd = null;
        $fa = null;
        
        if($this->_hasParam('tipo')){
            $tipo = $this->getRequest()->getParam('tipo');
	        $print = true;
        }
        if($print){
	        $dirReporte = APPLICATION_PATH .'/modules/siscp/reports/';
	        $jrDirLib = APPLICATION_PATH .'/lib_reports/';
	        $pdfReporte = 'rptcentroides';
	        $archivo = '';
	        $directorio = opendir($jrDirLib);
	        
	        while (($lib = readdir($directorio)) !== false) {
	            $archivo .= 'file:' . $jrDirLib . '/' . $lib . ';';
	        }
	        if($tipo == 'd'){
	        	$fd = $this->getRequest()->getParam('fd');
	        	$mesi = new Zend_Date($fd);
			    $mesf = new Zend_Date($fd);
	        	$namemes = 'DEL '.$mesi->toString('MM/dd/y');
	        }else if($tipo == 's'){
	        	$fd = $this->getRequest()->getParam('fi');
	        	$fa = $this->getRequest()->getParam('ff');
	        	$mesi = new Zend_Date($fd);
			    $mesf = new Zend_Date($fa);
	        	$namemes = 'DESDE  EL '.$mesi->toString('MM/dd/y').' HASTA EL '.$mesf->toString('MM/dd/y');
	        }else if($tipo == 'm'){
	        	$mes = $this->getRequest()->getParam('mes');
	        	$anio = $this->getRequest()->getParam('anio');
		        if($mes == 1){
		            $namemes = 'DEL MES DE ENERO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 2){
		            $namemes = 'DEL MES DE FEBRERO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-28');
		        }
		        if($mes == 3){
		            $namemes = 'DEL MES DE MARZO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 4){
		            $namemes = 'DEL MES DE ABRIL';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-30');
		        }
		        if($mes == 5){
		            $namemes = 'DEL MES DE MAYO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 6){
		            $namemes = 'DEL MES DE JUNIO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-30');
		        }
		        if($mes == 7){
		            $namemes = 'DEL MES DE JULIO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 8){
		            $namemes = 'DEL MES DE AGOSTO';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 9){
		            $namemes = 'DEL MES DE SEPTIEMBRE';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-30');
		        }
		        if($mes == 10){
		            $namemes = 'DEL MES DE OCTUBRE';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
		        if($mes == 11){
		            $namemes = 'DEL MES DE NOVIEMBRE';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-30');
		        }
		        if($mes == 12){
		            $namemes = 'DEL MES DE DICIEMBRE';
			        $mesi = new Zend_Date($anio.'-'.$mes.'-01');
			        $mesf = new Zend_Date($anio.'-'.$mes.'-31');
		        }
	        }
	        
	        try {
	            java_require($archivo);
	            $connexion = new Java('org.altic.jasperReports.JdbcConnection');
	            $crearReporte = new JavaClass('net.sf.jasperreports.engine.JasperFillManager');
	            $exportaRepote = new JavaClass('net.sf.jasperreports.engine.JasperExportManager');
	            $parametro = new Java("java.util.HashMap");
	            $connexion->setDriver('org.postgresql.Driver');
	            $connexion->setConnectString('jdbc:postgresql://10.7.6.250:5432/bdswrceo');
	            $connexion->setUser('postgres');
	            $connexion->setPassword('Magna2011');
	            $parametro->put('SUBREPORT_DIR', new Java('java.lang.String', $dirReporte));
	            $parametro->put('FECI', new Java('java.util.Date', $mesi->toString('MM/dd/y')));
	            $parametro->put('FECF', new Java('java.util.Date', $mesf->toString('MM/dd/y')));
	            $parametro->put('MES', New Java('java.lang.String',$namemes));
	            $parametro->put('C1', New Java('java.lang.String','El Guabo'));
	            $parametro->put('C2', New Java('java.lang.String','Pasaje'));
	            $parametro->put('C3', New Java('java.lang.String','Huaquillas'));
	            $parametro->put('C4', New Java('java.lang.String','Pinas'));
	            $parametro->put('C5', New Java('java.lang.String','Santa Rosa'));
	            $parametro->put('C6', New Java('java.lang.String','Brigada'));
	            $parametro->put('DIRECCION_LOGO', new Java('java.lang.String', 'c:/xampp/htdocs/siswebrceo/public/imagenes/logo.png'));
	            $irptFactura = $crearReporte->fillReportToFile($dirReporte . $pdfReporte . '.jasper', $parametro, $connexion->getConnection());
	            $exportaRepote->exportReportToPdfFile($irptFactura, $dirReporte . $pdfReporte . '.pdf');
	            if (file_exists($dirReporte . $pdfReporte . '.pdf')) {
	                 $this->view->pdfReporte = '/siswebrceo/application/modules/siscp/reports/'. $pdfReporte.'.pdf';
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