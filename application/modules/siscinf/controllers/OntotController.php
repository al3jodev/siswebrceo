<?php
require_once APPLICATION_PATH . '/modules/siscinf/models/Siscinf_Model_Table_Ontot.php';
require_once (APPLICATION_PATH . "/bridge/JavaBridge/java/Java.inc");
class Siscinf_OntotController extends Zend_Controller_Action
{
	public $usuid;
	public $lugar;
    public $apenom;
    public $ced;
    public $num;
    public $rol;
    public $dec;
	
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
    public function setDec($dec) {
		$this->dec = $dec;
	}
	public function getDec() {
		return $this->dec;
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
	public function setNum($num) {
		$this->num = $num;
	}
	public function setCed($ced) {
		$this->ced = $ced;
	}
	public function setApenom($apenom) {
		$this->apenom = $apenom;
	}
	public function setLugar($lugar) {
		$this->lugar = $lugar;
	}
	public function getNum() {
		return $this->num;
	}
	public function getCed() {
		return $this->ced;
	}
	public function getApenom() {
		return $this->apenom;
	}
	public function getLugar() {
		return $this->lugar;
	}


    public function form001Action()
    {
    	//$this->view->var = 'a'.' '.'as';
		/*for($i=1;$i<=962;$i++){
		 echo "INSERT INTO ontot (ot_id, ot_lugar, ot_apenom, ot_tipo, ot_desicion, id_usu, ot_num, ot_cedula, ot_fecha, ot_cedularp, ot_apenomrp) VALUES ($i, 'Machala', NULL, 'D0001', NULL, NULL, NULL, NULL, NULL, NULL, NULL);";
		}
		exit;*/
    }
    public function divisionterritorialAction(){
    }
	public function vercronogramaAction()
    {
        //$this->_helper->layout()->disableLayout();
        $this->view->pdfReporte = '/siswebrceo/application/modules/siscinf/anuncios/cronograma.pdf';
    }
	public function verform001Action()
    {
        $this->_helper->layout()->disableLayout();
        $print = false;
       if($this->_hasParam('lf')){
            $this->setLugar($this->getRequest()->getParam('lf'));
	        if($this->_hasParam('dp')){
	            $this->setApenom(utf8_encode($this->getRequest()->getParam('dp')));
	            if($this->_hasParam('c')){
	                $this->setCed($this->getRequest()->getParam('c'));
	                if($this->_hasParam('num')){
	                	$this->setNum($this->getRequest()->getParam('num'));
		                if($this->_hasParam('dec')){
		                	$this->setDec($this->getRequest()->getParam('dec'));
		                	$print = true;
		                }
	                }
	            }
	        }
        }
        if($print){
	        $dirReporte = APPLICATION_PATH .'/modules/siscinf/reports/';
	        $jrDirLib = APPLICATION_PATH .'/lib_reports/';
	        $pdfReporte = 'rptformd001';
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
	            $connexion->setConnectString('jdbc:postgresql://localhost:5432/bdswrceo');
	            $connexion->setUser('postgres');
	            $connexion->setPassword('allsoft');
	            $parametro->put('SUBREPORT_DIR', new Java('java.lang.String', $dirReporte));
	            $parametro->put('DIRECCION_LOGO', new Java('java.lang.String', 'c:/xampp/htdocs/siswebrceo/public/imagenes/footer.png'));
	            $parametro->put('LUGFEC', new Java('java.lang.String', $this->getLugar()));
	            $parametro->put('APENOM', new Java('java.lang.String',$this->getApenom()));
	            $parametro->put('CEDULA', new Java('java.lang.String', $this->getCed()));
	            $parametro->put(''.$this->getDec(), new Java('java.lang.String', 'X'));
	        	if($this->getRol() == 'Brigada'){
	        		$parametro->put('NUM', new Java('java.lang.String', '07.06.'.$this->getNum()));
			 	}else{
			 		$parametro->put('NUM', new Java('java.lang.String', '07.01.'.$this->getNum()));	
			 	}
	            $irptFactura = $crearReporte->fillReportToFile($dirReporte . $pdfReporte . '.jasper', $parametro, $connexion->getConnection());
	            $exportaRepote->exportReportToPdfFile($irptFactura, $dirReporte . $pdfReporte . '.pdf');
	            if (file_exists($dirReporte . $pdfReporte . '.pdf')) {
	                 $this->view->pdfReporte = '/siswebrceo/application/modules/siscinf/reports/'. $pdfReporte.'.pdf';
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
    
	public function form002Action()
    {
    }
    
	public function guardarform1Action() 
	{
	  $lugar           =$this->getRequest()->getParam('lugar');
	  $fecha           =$this->getRequest()->getParam('fecha');
	  $cedula          =$this->getRequest()->getParam('cedula');
	  $apellidosopnom  =$this->getRequest()->getParam('apellidosopnom');
	  $tipo            =$this->getRequest()->getParam('tipo');
	  $decision        =$this->getRequest()->getParam('decision');
	  
	  $ontotmodel = new Siscinf_Model_Table_Ontot();
	  if($this->getRol() == 'Brigada'){
	  	$lugar='Brigada';
	  	$numfilas = $ontotmodel->numregistros($tipo,$lugar);
	  }else{
	  	$numfilas = $ontotmodel->numregistros($tipo,$lugar);
	  }
	  
	  $num = count($numfilas)+1;
	  
	  $numreg = $ontotmodel->getformxnum($cedula);
	  $max = count($numreg);
	  if($max == 0){
	  	$msj = $ontotmodel->createOntot($lugar,$fecha,$cedula,$apellidosopnom,$tipo,$decision,$num,$this->getUsuid(),'','');
	  	echo $msj.':'.$num;
	  }else{
	  	echo "Registro ya existe";
	  }
	  exit;
	}
	
	public function guardarform2Action() 
	{
	  $lugar           =$this->getRequest()->getParam('lugar');
	  $fecha           =$this->getRequest()->getParam('fecha');
	  $cedula          =$this->getRequest()->getParam('cedula');
	  $apellidosopnom  =$this->getRequest()->getParam('apellidosopnom');
	  $tipo            =$this->getRequest()->getParam('tipo');
	  $decision        =$this->getRequest()->getParam('decision');
	  $cedulare        =$this->getRequest()->getParam('cedularp');
	  $apellidosopnomre=$this->getRequest()->getParam('apellidosopnomrp');
	  
	  $ontotmodel = new Siscinf_Model_Table_Ontot();
	  if($this->getRol() == 'Brigada'){
	  	$lugar='Brigada';
	  	$numfilas = $ontotmodel->numregistros($tipo,$lugar);
	  }else{
	  	$numfilas = $ontotmodel->numregistros($tipo,$lugar);
	  }
	  $num = count($numfilas)+1;
		
	  $ontotModel = new Siscinf_Model_Table_Ontot();				
	  $msj = $ontotModel->createOntot($lugar,$fecha,$cedula,$apellidosopnom,$tipo,$decision,$num,$this->getUsuid(),$cedulare,$apellidosopnomre);
	  echo $msj.':'.$num;
	  exit;
	}
	
	public function verform002Action()
    {
        $this->_helper->layout()->disableLayout();
        $print = false;
        $lugar = null;
        $apenom = null;
        $ced = null;
        $apenomre = null;
        $cedre = null;
        $num = null;
	    if($this->_hasParam('lf2')){
	            $lugar = $this->getRequest()->getParam('lf2');
		        if($this->_hasParam('dp2')){
		            $apenom = $this->getRequest()->getParam('dp2');
		            if($this->_hasParam('c2')){
		                $ced = $this->getRequest()->getParam('c2');
		                if($this->_hasParam('num2')){
		                	$num = $this->getRequest()->getParam('num2');
			                if($this->_hasParam('dprp2')){
			                	$apenomre = $this->getRequest()->getParam('dprp2');
			                	if($this->_hasParam('crp2')){
			                		$cedre = $this->getRequest()->getParam('crp2');
			                		if($this->_hasParam('dec')){
					                	$this->setDec($this->getRequest()->getParam('dec'));
					                	$print = true;
					                }
			                	}
			                }
		                }
		            }
		        }
	        }
        if($print){
	        $dirReporte = APPLICATION_PATH .'/modules/siscinf/reports/';
	        $jrDirLib = APPLICATION_PATH .'/lib_reports/';
	        $pdfReporte = 'rptformd002';
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
	            $parametro->put('DIRECCION_LOGO', new Java('java.lang.String', 'c:/xampp/htdocs/siswebrceo/public/imagenes/footer.png'));
	            $parametro->put('LUGFEC', new Java('java.lang.String', $lugar));
	            $parametro->put('APENOM', new Java('java.lang.String', utf8_encode($apenom)));
	            $parametro->put('CEDULA', new Java('java.lang.String', $ced));
	            $parametro->put('APENOMRP', new Java('java.lang.String', utf8_encode($apenomre)));
	            $parametro->put('CEDULARP', new Java('java.lang.String', $cedre));
	            $parametro->put(''.$this->getDec(), new Java('java.lang.String', 'X'));
	        	if($this->getRol() == 'Brigada'){
	        		$parametro->put('NUM', new Java('java.lang.String', '07.06.'.$num));
			 	}else{
			 		$parametro->put('NUM', new Java('java.lang.String', '07.01.'.$num));	
			 	}
	            $irptFactura = $crearReporte->fillReportToFile($dirReporte . $pdfReporte . '.jasper', $parametro, $connexion->getConnection());
	            $exportaRepote->exportReportToPdfFile($irptFactura, $dirReporte . $pdfReporte . '.pdf');
	            if (file_exists($dirReporte . $pdfReporte . '.pdf')) {
	                 $this->view->pdfReporte = '/siswebrceo/application/modules/siscinf/reports/'. $pdfReporte.'.pdf';
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
	
	
	
	public function consultarAction()
    {
    	
    }
    
    public function buscarontotxopAction()
    {
    	$fecha  = $this->getRequest()->getParam('fecha');		
		$ontotoModel = new Siscinf_Model_Table_Ontot();
		$data = $ontotoModel->getformxfecyidusu($fecha,$this->getUsuid());
		$max = count($data);
		$data1 = new Zend_Dojo_Data ('ot_id', $data);
		if(count($data1) > 0){
			$json = new Zend_Json ( );
			echo $json->encode ($data1);
		}else{
			$data1->clearItems();
			$json = new Zend_Json ( );
			echo $json->encode ($data1);
		}
		exit();
    }
    
	public function buscarontoidAction()
    {
    	$idontot  = $this->getRequest()->getParam('idontot');		
		$ontotoModel = new Siscinf_Model_Table_Ontot();
		$data = $ontotoModel->getontotxid($idontot);
		$max = count($data);
		$data1 = new Zend_Dojo_Data ('ot_id', $data);
		if(count($data1) > 0){
			$json = new Zend_Json ( );
			echo $json->encode ($data1);
		}else{
			$data1->clearItems();
			$json = new Zend_Json ( );
			echo $json->encode ($data1);
		}
		exit();
    }
    
	public function actualizarform1Action() 
	{
	  $lugar           =$this->getRequest()->getParam('lugar');
	  $fecha           =$this->getRequest()->getParam('fecha');
	  $cedula          =$this->getRequest()->getParam('cedula');
	  $apellidosopnom  =$this->getRequest()->getParam('apellidosopnom');
	  $tipo            =$this->getRequest()->getParam('tipo');
	  $decision        =$this->getRequest()->getParam('decision');
	  $idontot         =$this->getRequest()->getParam('id');
	  
	  $ontotModel = new Siscinf_Model_Table_Ontot();				
	  $msj = $ontotModel->actualizarOntot($lugar,$fecha,$cedula,$apellidosopnom,$tipo,$decision,$this->getUsuid(),'','',$idontot);
	  echo $msj;
	  exit;
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