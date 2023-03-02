<?php
require_once 'Zend/Db/Table/Abstract.php';

class Siscp_Model_Table_Operador extends Zend_Db_Table_Abstract 
{
	protected $_name = 'operador';
	protected $_schema = 'public';
	protected $_primary = 'op_id';
	
	public function createOperador($cedula,$nombresop,$apellidosop,$ciudad,$estado) 
	{
		 try {
         $dataOperador=array('op_cedula'=>$cedula,
         					 'op_nombres'=>$nombresop,
         					 'op_apellidos'=>$apellidosop,
         					 'op_ciudad'=>$ciudad,
         					 'op_estado'=>$estado
			        );
            $this->_db->beginTransaction();
            $this->_db->insert("public.operador",$dataOperador);
			$this->_db->commit();
			return 'Grabado Exitosamente';
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}
	
	public function getTodosOperadores() 
        {
        	$var1 = "(op_apellidos||' '||op_nombres)"; 
            $query=$this->_db->select()
                      ->from('public.operador',array('op_id','op_cedula','nombreape'=>$var1,'op_ciudad','op_estado'),$this->_schema)
                      ->where( 'op_estado = ?','Activo')->order('nombreape');
             $dato = $this->_db->fetchAll($query);
            return $dato; 
        }	
	public function getOperadoresxciudad($ciudad) 
        {
        	$var1 = "(op_nombres||' '||op_apellidos)";
            $query=$this->_db->select()
                      ->from('public.operador',array('op_id','op_cedula','nombreape'=>$var1,'op_ciudad','op_estado'),$this->_schema)
                      ->where( 'op_estado = ?','Activo')
                      ->where( 'op_ciudad = ?',$ciudad)->order('nombreape');
             $dato = $this->_db->fetchAll($query);
            return $dato; 
        }
	public function getOperadorxId($codigoop) 
        {
            $query=$this->_db->select()
                      ->from('public.operador',array('op_id','op_cedula','op_nombres','op_apellidos','op_ciudad','op_estado'),$this->_schema)
                      ->where( 'op_estado = ?','Activo')
                      ->where( 'op_id = ?',$codigoop);
             $dato = $this->_db->fetchAll($query);
            return $dato; 
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
        }  
}