<?php
require_once 'Zend/Db/Table/Abstract.php';

class Siscrh_Model_Table_Permiso extends Zend_Db_Table_Abstract 
{
	protected $_name = 'permiso';
	protected $_schema = 'public';
	protected $_primary = 'perm_id';
	
	public function createPermiso($horasolicitada,$fpermiso,$apelnom,$cedula,$observacion,$estado,$autorizadopor)
	{
		
		 try {
         $dataPermiso=array( 'perm_fecha'=>$fpermiso,
         					 'perm_cedula'=>$cedula,
         					 'perm_apenom'=>$apelnom,
         					 'perm_observacion'=>$observacion,
         					 'perm_hora_solicitada'=>$horasolicitada,
         					 'perm_estado'=>$estado,
         		             'perm_autorizadopor'=>$autorizadopor,
			        );
            $this->_db->beginTransaction();
            $this->_db->insert("public.permiso",$dataPermiso);
			$this->_db->commit();
			//$idper = $this->_db->lastInsertId("public.permisos","perm_id");
			return 'Grabado Exitosamente';
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}
	
	public function getPermisosfecxestado($fecha){
		$query=$this->select()
		->from('permiso','*',$this->_schema)
		->where( 'perm_fecha = ?',$fecha);
		$dato =    $this->_fetch($query);
		return $dato;
	}
	public function getPermisosfecxestadocerrado($fecha,$autorizado){
		$query=$this->select()
		->from('permiso','*',$this->_schema)
		->where( 'perm_fecha = ?',$fecha)
		->where( 'perm_autorizadopor = ?',$autorizado);
		$dato =    $this->_fetch($query);
		return $dato;
	}
	public function getPermisosxrangofechas($fechadesde,$fechahasta){
		$query=$this->select()
		->from('permiso','*',$this->_schema)
		->where( 'perm_fecha >= ?',$fechadesde)
		->where( 'perm_fecha <= ?',$fechahasta);
		$dato =    $this->_fetch($query);
		return $dato;
	}
	
	public function updatePermiso($idperm,$estado,$hora)
	{
		try {
			$dataPermiso   =array('perm_estado'=>$estado,
			                      'perm_hora_salida'=>$hora,);
			$this->_db->beginTransaction();
			$this->_db->update("public.permiso",$dataPermiso,"perm_id=$idperm");
			$this->_db->commit();
			return 'Actualizado Exitosamente';
		}
		catch (Exception $e)
		{
			$this->_db->rollBack();
			return $e->getMessage();
		}
	}
	public function updatePermisoCierre($idperm,$estado,$hora)
	{
		try {
			$dataPermiso   =array('perm_estado'=>$estado,
			                      'perm_hora_regreso'=>$hora,);
			$this->_db->beginTransaction();
			$this->_db->update("public.permiso",$dataPermiso,"perm_id=$idperm");
			$this->_db->commit();
			return 'Actualizado Exitosamente';
		}
		catch (Exception $e)
		{
			$this->_db->rollBack();
			return $e->getMessage();
		}
	}
}