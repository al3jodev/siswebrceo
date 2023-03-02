<?php
require_once 'Zend/Db/Table/Abstract.php';

class Siscp_Model_Table_Produccion extends Zend_Db_Table_Abstract 
{
	protected $_name = 'prod_diaria';
	protected $_schema = 'public';
	protected $_primary = 'pd_id';
	
	public function createProducd($idop,$fechaproduc,$totrenova,$observacion,$totpvez,$totenmiendas,$lugarem,$totrechazos)
	{
		 try {
         $dataProduc=array(  'pd_fecha'=>$fechaproduc,
         					 'pd_tot_renovacion'=>$totrenova,
         					 'pd_tot_primeravez'=>$totpvez,
         					 'pd_tot_enmiendas'=>$totenmiendas,
         					 'pd_tot_rechazos'=>$totrechazos,
         					 'pd_observacion'=>$observacion,
         					 'pd_lugar_emision'=>$lugarem,
         					 'op_id'=>$idop
			        );
            $this->_db->beginTransaction();
            $this->_db->insert("public.prod_diaria",$dataProduc);
			$this->_db->commit();
			$id = $this->_db->lastInsertId("public.prod_diaria","pd_id");			
			return $id;
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}
	
	public function updateProducd($idop,$fechaproduc,$totrenova,$observacion,$totpvez,$totenmiendas,$lugarem,$totrechazos,$codpd) {
		 try {
         		$dataProduc=array(   'pd_fecha'=>$fechaproduc,
		         					 'pd_tot_renovacion'=>$totrenova,
		         					 'pd_tot_primeravez'=>$totpvez,
		         					 'pd_tot_enmiendas'=>$totenmiendas,
		         					 'pd_tot_rechazos'=>$totrechazos,
		         					 'pd_observacion'=>$observacion,
		         					 'pd_lugar_emision'=>$lugarem,
		         					 'op_id'=>$idop
					        );
			        
            $this->_db->beginTransaction();
            $this->_db->update("public.prod_diaria",$dataProduc,"pd_id=$codpd");
			$this->_db->commit();
			return 'Actualizado Exitosamente';
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}
	
	public function getProducTotxId($codigoop) 
        {
            $query=$this->_db->select()
                      ->from('public.prod_diaria',array('pd_id','pd_fecha','pd_tot_renovacion','pd_tot_primeravez','pd_tot_enmiendas','pd_observacion','pd_lugar_emision','op_id','pd_tot_rechazos'),$this->_schema)
                      ->where( 'op_id = ?',$codigoop)
                      ->order('pd_fecha');
             $dato = $this->_db->fetchAll($query);
            return $dato; 
        }
        
	public function getProducTotxIdxfec($codigoop,$fechai,$fechaf) 
        {
            $query=$this->_db->select()
                      ->from('public.prod_diaria',array('pd_id','pd_fecha','pd_tot_renovacion','pd_tot_primeravez','pd_tot_enmiendas','pd_observacion','pd_lugar_emision','op_id','pd_tot_rechazos'),$this->_schema)
                      ->where( 'pd_fecha >= ?',$fechai)
                      ->where( 'pd_fecha <= ?',$fechaf)
                      ->where( 'op_id = ?',$codigoop)->order('pd_fecha');
             $dato = $this->_db->fetchAll($query);
            return $dato; 
        }
        
    public function getdetalleProduc($codpd) 
        {
        	$query =    $this->_db
      	                    ->select()
      	                    ->from(array('prod'=>'prod_diaria'),array('pd_id','pd_tot_enmiendas','pd_tot_rechazos'),$this->_schema)
      	                    ->join(array('detp'=>'det_produc'),'prod.pd_id = detp.pd_id',array('pd_id','dp_cantidad','te_id'),$this->_schema)
      	                    ->join(array('tipe'=>'tip_error'),'detp.te_id = tipe.te_id',array('te_id','te_tipo'),$this->_schema)
      	                    ->where('prod.pd_id = ?', $codpd);
            $dato = $this->_db->fetchAll($query);
      	    return $dato;  
        }  
	public function getProducxId($idpro) 
        {
            $query=$this->_db->select()
                      ->from('public.prod_diaria',array('pd_id','pd_fecha','pd_tot_renovacion','pd_tot_primeravez','pd_tot_enmiendas','pd_observacion','pd_lugar_emision','op_id','pd_tot_rechazos'),$this->_schema)
                      ->where( 'pd_id = ?',$idpro);
             $dato = $this->_db->fetchAll($query);
            return $dato; 
        }   
	public function deleteProduccion($id) 
	{
		 try {
            $this->_db->beginTransaction();
            $this->_db->delete("public.prod_diaria","pd_id=$id");
			$this->_db->commit();
			return 'Eliminado Exitosamente';
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}
}