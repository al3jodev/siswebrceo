<?php 
require_once 'Zend/Db/Table/Abstract.php'; 

class Model_Table_Usuarios extends Zend_Db_Table_Abstract 
{
    protected $_name = 'usuario';
    protected $_primary = 'id';
    protected $_schema	= 'public';
    
   public function getTipoRol($usu_codigo){
    	try {
    		$query = $this->_db->select()
    			->from('public.usuario',array('usu_id','usu_username','usu_pass','usu_rol'),$this->_schema)
    			->where('usu_id =?',$usu_codigo);
    		$res = $this->_db->fetchRow($query);
    		return $res;
    	} catch (Exception $e) {
    	}
    }
    
   /* public function createUser($username, $password, $firstName, $lastName, $role) 
	{ 
	    // create a new row 
	    $rowUser = $this->createRow(); 
	    if($rowUser) { 
	        // update the row values 
	        $rowUser->usu_username = $username; 
	        $rowUser->usu_pass = md5($password); 
	        $rowUser->first_name = $firstName; 
	        $rowUser->last_name = $lastName; 
	        $rowUser->rol = $role; 
	        $rowUser->save(); 
	        //return the new user 
	        return $rowUser; 
	    } else { 
	        throw new Zend_Exception("Could not create user!"); 
	    } 
	}
	
	public function createUsuarios($username,$password,$nameuser,$apeuser,$rol) 
	{
		 try {
           $dataUsuarios=array(		'username'=>$username,
         							'password'=>$password,
         							'first_name'=>$nameuser,
         							'last_name'=>$apeuser,
         							'rol'=>$rol,
			);			        
            $this->_db->beginTransaction();
            $this->_db->insert("public.usuarios",$dataUsuarios);
			$this->_db->commit();
			return 'Grabado Exitosamente';
		 } 
        catch (Exception $e) 
        {
            $this->_db->rollBack();
            return $e->getMessage();
        }
	}

	public static function getUsers() 
	{ 
	    $userModel = new self(); 
	    $select = $userModel->select(); 
	    $select->order(array('last_name', 'first_name')); 
	    return $userModel->fetchAll($select); 
	} 
	
	public function updateUser($id, $username, $firstName, $lastName, $role) 
	{ 
	    // fetch the user's row 
	    $rowUser = $this->find($id)->current(); 
	    if($rowUser) { 
	        // update the row values 
	        $rowUser->username = $username; 
	        $rowUser->first_name = $firstName; 
	        $rowUser->last_name = $lastName; 
	        $rowUser->role = $role; 
	        $rowUser->save(); 
	        //return the updated user 
	        return $rowUser; 
	    }else{ 
	        throw new Zend_Exception("User update failed.  User not found!"); 
	    } 
	} 
	
	public function updatePassword($id, $password) 
	{ 
	    // fetch the user's row 
	    $rowUser = $this->find($id)->current(); 
	    if($rowUser) { 
	        //update the password 
	        $rowUser->password = md5($password); 
	        $rowUser->save(); 
	    }else{ 
	        throw new Zend_Exception("Password update failed.  User not found!"); 
	    } 
	} 
	
	public function deleteUser($id) 
	{ 
	    // fetch the user's row 
	    $rowUser = $this->find($id)->current(); 
	    if($rowUser) { 
	        $rowUser->delete(); 
	    }else{ 
	        throw new Zend_Exception("Could not delete user.  User not found!"); 
	    } 
	} */
	
/*public function logout()
    {
        Zend_Auth::getInstance()->clearIdentity();
        return $this;
    }
    public static function getIdentity()
    {
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            return $auth->getIdentity();
        }
        return null;
    }
    public static function isLoggedIn()
    {
        return Zend_Auth::getInstance()->hasIdentity();
    }*/
	
} 