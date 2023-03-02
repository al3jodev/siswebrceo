<?php
require_once 'Zend/Db/Table/Abstract.php';

class Siscinf_Model_Table_Ontot extends Zend_Db_Table_Abstract 
{
	protected $_name = 'ontot';
	protected $_schema = 'public';
	protected $_primary = 'ot_id';
	
	public function createOntot($lugar,$fecha,$cedula,$apellidosopnom,$tipo,$decision,$num,$idusu,$cedulare,$apellidosopnomre)
	{
		 try {
         $dataOntot   =array('ot_lugar'=>$lugar,
         					 'ot_fecha'=>$fecha,
         					 'ot_cedula'=>$cedula,
         					 'ot_apenom'=>$apellidosopnom,
         					 'ot_tipo'=>$tipo,
         					 'ot_desicion'=>$decision,
         					 'ot_num'=>$num,
         					 'id_usu'=>$idusu,
         					 'ot_cedularp'=>$cedulare,
         					 'ot_apenomrp'=>$apellidosopnomre,
			        );
            $this->_db->beginTransaction();
            $this->_db->insert("public.ontot",$dataOntot);
			$this->_db->commit();
			return 'Grabado Exitosamente';
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}
	
	public function numregistros($tipo,$lugar) 
        {
            $query=$this->_db->select()
                      ->from('public.ontot','*',$this->_schema)
                      ->where( 'ot_tipo = ?',$tipo)
                      ->where( 'ot_lugar = ?',$lugar);;
             $dato = $this->_db->fetchAll($query);
            return $dato; 
        }
    
	public function getformxnum($cedula) 
        {
            $query=$this->_db->select()
                      ->from('public.ontot','*',$this->_schema)
                      ->where( 'ot_cedula = ?',$cedula);
             $dato = $this->_db->fetchAll($query);
            return $dato; 
        }
	        
	public function getformxfecyidusu($fecha,$idusu) 
        {
            $query=$this->_db->select()
                      ->from('public.ontot','*',$this->_schema)
                      ->where( 'ot_fecha = ?',$fecha)
                      ->where( 'id_usu = ?',$idusu);
             $dato = $this->_db->fetchAll($query);
            return $dato; 
        }   
        
	public function getontotxid($idontot) 
        {
            $query=$this->_db->select()
                      ->from('public.ontot','*',$this->_schema)
                      ->where( 'ot_id = ?',$idontot);
             $dato = $this->_db->fetchAll($query);
            return $dato; 
        }
        
	public function actualizarOntot($lugar,$fecha,$cedula,$apellidosopnom,$tipo,$decision,$idusu,$cedulare,$apellidosopnomre,$id)
	{
		 try {
         $dataOntot   =array('ot_lugar'=>$lugar,
         					 'ot_fecha'=>$fecha,
         					 'ot_cedula'=>$cedula,
         					 'ot_apenom'=>$apellidosopnom,
         					 'ot_tipo'=>$tipo,
         					 'ot_desicion'=>$decision,
         					 'id_usu'=>$idusu,
         					 'ot_cedularp'=>$cedulare,
         					 'ot_apenomrp'=>$apellidosopnomre,
			        );
            $this->_db->beginTransaction();
            $this->_db->update("public.ontot",$dataOntot,"ot_id=$id");
			$this->_db->commit();
			return 'Grabado Exitosamente';
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}
public function updateOperador($cedula,$apellidosop,$nombresop,$ciudad,$idop) {
		 try {
         		$dataOperador=array(
	         					'op_cedula'=>$cedula,
	         					'op_apellidos'=>$apellidosop,
	         					'op_nombres'=>$nombresop,
	         					'op_ciudad'=>$ciudad,
				        );
			        
            $this->_db->beginTransaction();
            $this->_db->update("public.operador",$dataOperador,"op_id=$idop");
			$this->_db->commit();
			return 'Actualizado Exitosamente';
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}
	
	/*public function getTodosOperadores() 
        {
        	$var1 = "(op_nombres||' '||op_apellidos)"; 
            $query=$this->_db->select()
                      ->from('public.operador',array('op_id','op_cedula','nombreape'=>$var1,'op_ciudad','op_estado'),$this->_schema)
                      ->where( 'op_estado = ?','Activo')->order('nombreape');
             $dato = $this->_db->fetchAll($query);
            return $dato; 
        }	
	
	 
	
	public function eliminarOperador($idop) 
        {
	        try
	        {
	        	$dataOperador=array('op_estado'=>'Inactivo');
	            $this->_db->beginTransaction();
	            $this->_db->update("public.operador",$dataOperador,"op_id=$idop");
	            $this->_db->commit();
	            return 'Eliminado Exitosamente';
	        }catch(Exception $ex)
	        {
	            $this->_db->rollBack();
	            return  $ex->getMessage();        
	        } 
        }*/  
}