<?php
require_once 'Zend/Db/Table/Abstract.php';

class Sisced_Model_Table_Validacion extends Zend_Db_Table_Abstract 
{
	protected $_name = 'validacion';
	protected $_schema = 'public';
	protected $_primary = 'val_id';
	
	public function numsolicitud()
	{
		$query=$this->_db->select()
		      ->from('public.validacion','val_num_solicitud',$this->_schema)
		      ->distinct('val_num_solicitud');
		$dato = $this->_db->fetchAll($query);
		return $dato;
	}
	
	 public function createSolicitud($numsol,$tipocedulacion,$valusuario,$cedusuario,$apenomusu,$provusuario,
	 		                         $tipociusuario,$telefono,$correoe,$fechasol,$fechares,$observacion,
	 		                         $estado,$usuid,$as)
	{
		 try {
         $dataOntot   =array('val_num_solicitud'=>$numsol,
         					 'val_tipocedulacion'=>$tipocedulacion,
         					 'val_copia_de'=>$valusuario,
         					 'val_cedula'=>$cedusuario,
         					 'val_apenom'=>$apenomusu,
         					 'val_provincia'=>$provusuario,
         					 'val_tipo'=>$tipociusuario,
         					 'val_telefono'=>$telefono,
         					 'val_correo'=>$correoe,
         					 'val_fecha_solicitud'=>$fechasol,
			         		 'val_fecha_respuesta'=>$fechares,
			         		 'val_observacion'=>$observacion,
			         		 'val_estado_partida'=>$estado,
			         		 'val_estado_usuario'=>'',
			         		 'usu_id'=>$usuid,
         					 'val_as'=>$as,
			        );
            $this->_db->beginTransaction();
            $this->_db->insert("public.validacion",$dataOntot);
			$this->_db->commit();
			return 'Grabado Exitosamente';
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}
	public function createSolicitudFam($numsol,$valusuario,$cedusuario,$apenomusu,$provusuario,
			$tipociusuario,$fechasol,$fechares,$estado,$usuid,$as)
	{
		try {
			$dataOntot   =array('val_num_solicitud'=>$numsol,
								'val_copia_de'=>$valusuario,
								'val_cedula'=>$cedusuario,
								'val_apenom'=>$apenomusu,
								'val_provincia'=>$provusuario,
								'val_tipo'=>$tipociusuario,
								'val_fecha_solicitud'=>$fechasol,
								'val_fecha_respuesta'=>$fechares,
								'val_estado_partida'=>$estado,
								'val_estado_usuario'=>'',
								'usu_id'=>$usuid,
								'val_as'=>$as,
			);
			$this->_db->beginTransaction();
			$this->_db->insert("public.validacion",$dataOntot);
			$this->_db->commit();
			return 'Grabado Exitosamente';
		}
		catch (Exception $e)
		{
			$this->_db->rollBack();
			return $e->getMessage();
		}
	}
	public function getSolicitudxfecha($fecha){
		$query=$this->select()
		->from('validacion','*',$this->_schema)
		->where( 'val_fecha_solicitud = ?',$fecha);
		$dato =    $this->_fetch($query);
		return $dato;
	}
	public function getSolicitudxcedula($cedula){
		$query=$this->select()
		->from('validacion','*',$this->_schema)
		->where( 'val_cedula = ?',$cedula);
		$dato =    $this->_fetch($query);
		return $dato;
	}
	
	public function getSolicitudxrangofechas($fechadesde,$fechahasta){
		$query=$this->select()
		->from('validacion','*',$this->_schema)
		->where( 'val_tipo != ?','REFERENCIA')
		->where( 'val_fecha_solicitud >= ?',$fechadesde)
		->where( 'val_fecha_solicitud <= ?',$fechahasta);
		$dato =    $this->_fetch($query);
		return $dato;
	}
	
	public function getPartidasxfecha($fecha){
		$query=$this->select()
		->from('validacion','*',$this->_schema)
		->where( 'val_tipo != ?','REFERENCIA')
		->where( 'val_fecha_solicitud = ?',$fecha);
		$dato =    $this->_fetch($query);
		return $dato;
	}
	
	public function getProvinciaxfecha($fecha)
	{
		$query=$this->_db->select()
		->from('public.validacion',array('val_id','val_provincia'),$this->_schema)
		->where( 'val_fecha_solicitud = ?',$fecha)
		->distinct('val_num_solicitud');
		$dato = $this->_db->fetchAll($query);
		return $dato;
	}
	
	/*public function numsolicitud($tipo,$lugar) 
        {
            $query=$this->_db->select()
                      ->from('public.validacion','*',$this->_schema)
                      ->where( 'ot_tipo = ?',$tipo)
                      ->where( 'ot_lugar = ?',$lugar);;
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
	} */
	
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