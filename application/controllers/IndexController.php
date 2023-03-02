<?php
require_once APPLICATION_PATH . '/models/Model_Table_Usuarios.php';
class IndexController extends Zend_Controller_Action
{
 	public function init()
    {
        Zend_Dojo::enableView($this->view);
    }
	/*CONTROL DE LOGIN*/
    public function indexAction()
    {
        $form = new Zend_Dojo_Form ( );
		$this->view->form = $form;
    }
	public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('index');
    }
	public function logeoAction()
    {
        $usuario = $this->getRequest()->getParam('login');
    	$clave = $this->getRequest()->getParam('pass');
    	$respuesta = null;
    	if(Zend_Auth::getInstance()->hasIdentity()){
    		$respuesta['error']=0;
	        $respuesta['msg']=utf8_encode("El usuario ya tiene una sesión activa.");
	        $respuesta['direccion']=utf8_encode($this->getDireccionUsuario());
    	}else{
    		$respuesta['error']=0;
	    	$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
            $authAdapter ->setTableName('public.usuario')              // Nombre de la tabla
                         ->setIdentityColumn('usu_username')             // Campo de identificación
                         ->setCredentialColumn('usu_pass')       // Campo de contraseña
                         ->setIdentity($usuario)          // Valor de identificación
                         ->setCredential($clave);
	        $auth = Zend_Auth::getInstance();
	        $result = $auth->authenticate($authAdapter);
	        if($result->isValid()){
	        	$identity = $authAdapter->getResultRowObject();
	        	$authStorage = $auth->getStorage();
	        	$authStorage->write($identity);
	        	$respuesta['error']=0;
	        	$respuesta['msg']=utf8_encode("Datos de usuario aceptados.");
	        	$respuesta['direccion']=utf8_encode($this->getDireccionUsuario());
	        }else{
	        	$respuesta['error']=1;
	        	$respuesta['msg']=utf8_encode("Los datos de usuario no son válidos.");
	        }
    	}
    	 echo Zend_Json::encode($respuesta);
    	 exit();
    	
    }
     public function getDireccionUsuario(){
    	$rol = $this->gettiporol();
    	$dir = null;
    	switch($rol){
    		case 'Produccion':$dir="siscp";break;
    		case 'Recursos Humanos':$dir="siscrh";break;
    		case 'Lider':$dir="siscinf";break;
    		case 'Brigada':$dir="siscinf";break;
    		case 'Operador':$dir="sisced";break;
    		case 'Express':$dir="sisexp";break;
    		//case 'DOCTOR':$dir="doctor";break;
    		//case 'ESTUDIANTE':$dir="estudiante";break;
    	}
    	return $dir;
    }
    
    public function gettiporol(){
    	$sesion = Zend_Auth::getInstance();
        $dataSesion = $sesion->getStorage()->read();
        $usu_codigo = $dataSesion->usu_rol;
        return $usu_codigo;
    }
    
	public function getAuthAdapter(){
    	$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
    	$authAdapter->setTableName('public.usuario')
    		->setIdentityColumn('usu_username')
    		->setCredentialColumn('usu_lastname');
    	return $authAdapter;
    }
}

