	function autenticarUsuario()
	{
		if(checkDatosUsuario()){
			dojo.xhrPost({
			handleAs:"json",
		    url    :  "/siswebrceo/public/index/logeo",
		    load   :  function(response, ioArgs)
		              {
							if(response.error == 0)
							{
								alert(response.msg);
								window.location.assign('/siswebrceo/public/'+response.direccion+'/index');
							}else{
								alert(response.msg);
							}
						return response;
		              },
		    error  :  function(response, ioArgs)
		              { 
		                return response;
		              },
		    content:
		              { 
		            	 "login"       :dijit.byId("login").value,
		            	 "pass"        :document.getElementById("clave").value
		    	      }
		  });
		}else{
			alert("Revise que los datos ingresados son correctos");
		}
		
	}
	function entrarsistema(event)
	{
		var key = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
		if (((document.all)?event.keyCode:event.which)=="13")
		{
			if(checkDatosUsuario()){
				dojo.xhrPost({
				handleAs:"json",
			    url    :  "/siswebrceo/public/index/logeo",
			    load   :  function(response, ioArgs)
			              {
								if(response.error == 0)
								{
									alert(response.msg);
									window.location.assign('/siswebrceo/public/'+response.direccion+'/index');
								}else{
									alert(response.msg);
								}
							return response;
			              },
			    error  :  function(response, ioArgs)
			              { 
			                return response;
			              },
			    content:
			              { 
			            	 "login"       :dijit.byId("login").value,
			            	 "pass"        :document.getElementById("clave").value
			    	      }
			  });
			}else{
				alert("Revise que los datos ingresados son correctos");
			}
		}
	}
	
	function checkDatosUsuario(){
		var bValid = true;
		if (dijit.byId("login").isValid()){
			bValid=true;
		}else {
			bValid=false;
		}
		return bValid;
	}

	function cancelarUser()
	{	
		window.location.assign("/siswebrceo/public/index");
	}