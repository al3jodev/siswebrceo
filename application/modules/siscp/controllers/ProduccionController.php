<?php
require_once APPLICATION_PATH . '/modules/siscp/models/Siscp_Model_Table_Operador.php';
require_once APPLICATION_PATH . '/modules/siscp/models/Siscp_Model_Table_Produccion.php';
require_once APPLICATION_PATH . '/modules/siscp/models/Siscp_Model_Table_Dproduc.php';
class Siscp_ProduccionController extends Zend_Controller_Action
{
	public function init()
	{
		$session = Zend_Auth::getInstance();
		$dataSesion = $session->getStorage()->read();
		$nombre = $dataSesion->usu_firstname;
		$apellido = $dataSesion->usu_lastname;
		$this->view->nameuser = $nombre." ".$apellido;
	}

    public function ingproducdAction()
    {
    	$this->view->voperadores= "/siswebrceo/public/siscp/operador/buscaroperadores";
    	$this->view->terror= "/siswebrceo/public/siscp/terror/getterrores";
    }
    
	public function guardarproducAction() 
	{
	  $idop                  =$this->getRequest()->getParam('idop');
	  $fechaproduc           =$this->getRequest()->getParam('fechaproduc');
	  $totrenova             =$this->getRequest()->getParam('totrenova');
	  $observacion           =$this->getRequest()->getParam('observacion');
	  $totpvez               =$this->getRequest()->getParam('totpvez');
	  $totenmiendas          =$this->getRequest()->getParam('totenmiendas');
	  $totrechazos           =$this->getRequest()->getParam('totrechazos');
	  $lugarem               =$this->getRequest()->getParam('lugarem');
	  $errores               =$this->getRequest()->getParam('errores');
	  $cantidades            =$this->getRequest()->getParam('cantidades');
	  $codoperadores         =$this->getRequest()->getParam('codoperadores');
	  
	  $operadorModel = new Siscp_Model_Table_Produccion();
	  $codproduc = $operadorModel->createProducd($idop,$fechaproduc,$totrenova,$observacion,$totpvez,$totenmiendas,$lugarem,$totrechazos);
	  
      $deterrorModel = new Siscp_Model_Table_Dproduc();
      $det_errores = explode(";",$errores);
      $det_cantidades = explode(";",$cantidades);
      $det_codoperadores = explode(";",$codoperadores);
      $max = count($det_errores);
      if($max > 1){
	      for ($i=0; $i<$max-1; $i++) {
	 	 	$msj = $deterrorModel->createDproduc($codproduc,$det_errores[$i],$det_cantidades[$i],$det_codoperadores[$i]);
	      } 
		  echo $msj;
	  }else{
		echo "Grabado Exitosamente";
	  }
	  exit;
	}
	public function conproducdAction(){
		$this->view->voperadores= "/siswebrceo/public/siscp/operador/buscaroperadores";
		$this->view->terror= "/siswebrceo/public/siscp/terror/getterrores";
	}
	//BUSCAR PRODUCCION X OPERADOR
	public function buscarproductotxopAction()
    {
			$codigoop  = $this->getRequest()->getParam('idop');		
			$producModel = new Siscp_Model_Table_Produccion();
			$data = $producModel->getProducTotxId($codigoop);
			$max = count($data);
			for($i=0;$i < $max; $i++){
				$datadetalle = $producModel->getdetalleProduc($data[$i]['pd_id']);
				$max1 = count($datadetalle);
				$errores='';$aux='';
				for($x=0; $x<$max1; $x++){
				    $aux = $datadetalle[$x]['te_tipo'].'('.$datadetalle[$x]['dp_cantidad'].')';
		        	$errores = $aux.';'.$errores;
		    	}
		    	$data[$i]['errores'] = $errores;
			}
			
			$data1 = new Zend_Dojo_Data ('pd_id', $data);
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
	//BUSCAR PRODUCCION X OPERADOR X MES
	public function buscarproductotxopxmesAction()
    {
		$codigoop    = $this->getRequest()->getParam('idop');
		$numes       = $this->getRequest()->getParam('numes');
		$anio        = $this->getRequest()->getParam('anio');
		//$this->fecha = new Zend_Date();
	    //$anio = date("Y", $this->fecha->getTimestamp());
    	if($numes == '1'){
	    	$fechai='01-01-'.$anio;
	    	$fechaf='31-01-'.$anio;
	    }else if($numes == '2'){
	    	$fechai='01-02-'.$anio;
	    	if($anio == '2012'){
	    	    $fechaf='29-02-'.$anio;
	    	}else{
	    	    $fechaf='28-02-'.$anio;
	    	}
	    }else if($numes == '3'){
	    	$fechai='01-03-'.$anio;
	    	$fechaf='31-03-'.$anio;
	    }else if($numes == '4'){
	    	$fechai='01-04-'.$anio;
	    	$fechaf='30-04-'.$anio;
	    }else if($numes == '5'){
	    	$fechai='01-05-'.$anio;
	    	$fechaf='31-05-'.$anio;
	    }else if($numes == '6'){
	    	$fechai='01-06-'.$anio;
	    	$fechaf='30-06-'.$anio;
	    }else if($numes == '7'){
	    	$fechai='01-07-'.$anio;
	    	$fechaf='31-07-'.$anio;
	    }else if($numes == '8'){
	    	$fechai='01-08-'.$anio;
	    	$fechaf='31-08-'.$anio;
	    }else if($numes == '9'){
	    	$fechai='01-09-'.$anio;
	    	$fechaf='30-09-'.$anio;
	    }else if($numes == '10'){
	    	$fechai='01-10-'.$anio;
	    	$fechaf='31-10-'.$anio;
	    }else if($numes == '11'){
	    	$fechai='01-11-'.$anio;
	    	$fechaf='30-11-'.$anio;
	    }else if($numes == '12'){
	    	$fechai='01-12-'.$anio;
	    	$fechaf='31-12-'.$anio;
	    }	
		$producModel = new Siscp_Model_Table_Produccion( );
		$data = $producModel->getProducTotxIdxfec($codigoop,$fechai,$fechaf);
		$max = count($data);
			for($i=0;$i < $max; $i++){
				$datadetalle = $producModel->getdetalleProduc($data[$i]['pd_id']);
				$max1 = count($datadetalle);
				$errores='';$aux='';
				for($x=0; $x<$max1; $x++){
				    $aux = $datadetalle[$x]['te_tipo'].'('.$datadetalle[$x]['dp_cantidad'].')';
		        	$errores = $aux.';'.$errores;
		    	}
		    	$data[$i]['errores'] = $errores;
			}
			
			$data1 = new Zend_Dojo_Data ('pd_id', $data);
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
	//BUSCAR PRODUCCION X OPERADOR X RANGO DE FECHAS
	public function buscarproductotxopxrangoAction()
    {
		$codigoop         = $this->getRequest()->getParam('idop');
		$fechadesde       = $this->getRequest()->getParam('fechadesde');
		$fechahasta       = $this->getRequest()->getParam('fechahasta');
		$producModel = new Siscp_Model_Table_Produccion( );
		$data = $producModel->getProducTotxIdxfec($codigoop,$fechadesde,$fechahasta);
		$max = count($data);
			for($i=0;$i < $max; $i++){
				$datadetalle = $producModel->getdetalleProduc($data[$i]['pd_id']);
				$max1 = count($datadetalle);
				$errores='';$aux='';
				for($x=0; $x<$max1; $x++){
				    $aux = $datadetalle[$x]['te_tipo'].'('.$datadetalle[$x]['dp_cantidad'].')';
		        	$errores = $aux.';'.$errores;
		    	}
		    	$data[$i]['errores'] = $errores;
			}
			
			$data1 = new Zend_Dojo_Data ('pd_id', $data);
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
//	BUSCAR PRODUCCION X ID DE PRODUCCION
	public function buscarproducxidAction()
    {
			$pdid  = $this->getRequest()->getParam('pdid');		
			$producModel = new Siscp_Model_Table_Produccion();
			$data = $producModel->getProducxId($pdid);
			$max = count($data);
			for($i=0;$i < $max; $i++){
				$datadetalle = $producModel->getdetalleProduc($data[$i]['pd_id']);
				$max1 = count($datadetalle);
				$errores='';$aux='';
				for($x=0; $x<$max1; $x++){
				    $aux = $datadetalle[$x]['te_tipo'].'('.$datadetalle[$x]['dp_cantidad'].')';
		        	$errores = $aux.';'.$errores;
		    	}
		    	$data[$i]['errores'] = $errores;
			}
			
			$data1 = new Zend_Dojo_Data ('pd_id', $data);
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
	public function actproduccionAction() 
	{
	  $idop                  =$this->getRequest()->getParam('idop');
	  $fechaproduc           =$this->getRequest()->getParam('fechaproduc');
	  $totrenova             =$this->getRequest()->getParam('totrenova');
	  $observacion           =$this->getRequest()->getParam('observacion');
	  $totpvez               =$this->getRequest()->getParam('totpvez');
	  $totenmiendas          =$this->getRequest()->getParam('totenmiendas');
	  $totrechazos           =$this->getRequest()->getParam('totrechazos');
	  $lugarem               =$this->getRequest()->getParam('lugarem');
	  $errores               =$this->getRequest()->getParam('errores');
	  $cantidades            =$this->getRequest()->getParam('cantidades');
	  $codoperadores         =$this->getRequest()->getParam('codoperadores');
	  $codpd                 =$this->getRequest()->getParam('codpd');
	  $deterrorModel = new Siscp_Model_Table_Dproduc();
	  $deterrorModel->deleteDetalle($codpd);
	  
	  $operadorModel = new Siscp_Model_Table_Produccion();
	  $operadorModel->updateProducd($idop,$fechaproduc,$totrenova,$observacion,$totpvez,$totenmiendas,$lugarem,$totrechazos,$codpd);
	  
      $deterrorModel = new Siscp_Model_Table_Dproduc();
      $det_errores = explode(";",$errores);
      $det_cantidades = explode(";",$cantidades);
      $det_codoperadores = explode(";",$codoperadores);
      $max = count($det_errores);
      if($max > 1){
	      for ($i=0; $i<$max-1; $i++) {
	 	 	$msj = $deterrorModel->createDproduc($codpd,$det_errores[$i],$det_cantidades[$i],$det_codoperadores[$i]);
	      } 
	 	  echo $msj;
	  }else{
		echo "Grabado Exitosamente";
	  }
	  exit;
	}
	
	public function eliproduccionAction()
    {
    	$pdid = $this->getRequest()->getParam('pdid');
    	$deterrorModel = new Siscp_Model_Table_Dproduc();
	    $deterrorModel->deleteDetalle($pdid);
		$producModel = new Siscp_Model_Table_Produccion();
		$msj = $producModel->deleteProduccion($pdid);
		echo $msj;
		exit;
    }
}