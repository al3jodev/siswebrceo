<?php
require_once 'Zend/Db/Table/Abstract.php';

class Siscp_Model_Table_TError extends Zend_Db_Table_Abstract 
{
	protected $_name = 'tip_error';
	protected $_schema = 'public';
	protected $_primary = 'te_id';
	
	public function createError($tipoerror,$descripcion)
	{
		 try {
         $dataError=array(  
         					 'te_descripcion'=>$descripcion,
         					 'te_tipo'=>$tipoerror,
			        );
            $this->_db->beginTransaction();
            $this->_db->insert("public.tip_error",$dataError);
			$this->_db->commit();
			return 'Grabado Exitosamente';
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}
	
	public function getTodosErrores() 
        {
            $query=$this->_db->select()
                      ->from('public.tip_error',array('te_id','te_tipo','te_descripcion'),$this->_schema)
                      ->order('te_tipo');
             $dato = $this->_db->fetchAll($query);
            return $dato; 
        }	
}