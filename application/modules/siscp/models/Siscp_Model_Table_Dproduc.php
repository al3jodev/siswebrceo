<?php
require_once 'Zend/Db/Table/Abstract.php';

class Siscp_Model_Table_Dproduc extends Zend_Db_Table_Abstract 
{
	protected $_name = 'det_produc';
	protected $_schema = 'public';
	
	public function createDproduc($codproduc,$codterror,$cantidad,$codop)
	{
		 try {
         $dataError=array(  'pd_id'=>$codproduc,
         					'te_id'=>$codterror,
         					'dp_cantidad'=>$cantidad,
         					'op_id'=>$codop,
			        );
            $this->_db->beginTransaction();
            $this->_db->insert("public.det_produc",$dataError);
			$this->_db->commit();
			return 'Grabado Exitosamente';
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}
	public function deleteDetalle($id) 
	{
		 try {
            $this->_db->beginTransaction();
            $this->_db->delete("public.det_produc","pd_id=$id");
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