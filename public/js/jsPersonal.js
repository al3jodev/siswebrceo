	var cont=1;
	function cancelarOperadoring()
	{
		window.location.assign("/siswebrceo/public/siscp/operador/ingoperador");
	}
	
	function guardarOperador()
	{	
			//if((dijit.byId("razon").value != ""))
			//{
				//if((dijit.byId("razon").isValid()))
				//{
					//if(bandexiste == true)
					//{
					dojo.xhrPost({
						handleAs:"text",
					    url    :  "/siswebrceo/public/siscp/operador/guardaroperador", 
					    load   :  function(response, ioArgs)
					              {
									if(response=='Grabado Exitosamente')
									{
										alert(response);
										var band = confirm("Desea grabar otro Operador?");
					    				if(band){
					    					window.location.assign("/siswebrceo/public/siscp/operador/ingoperador");
					    				}else{
					    					window.location.assign("/siswebrceo/public/siscp/operador/ingoperador");
					    				}
									}else{
										alert(response);
									}
								   return response;
					              },
					    error  :  function(response, ioArgs)
					              { 
					            	  alert(response);
					                return response;
					              },
					    content: 
					     		{ 
					    	      "cedula"          		:dijit.byId("cedula").value,
					    	      "nombresop"      	        :dijit.byId("nombresop").value,
					    	      "apellidosop"       		:dijit.byId("apellidosop").value,
					    	      "ciudad"       	  		:dijit.byId("ciudad").value
					     		}
					  });
					/*}else{
						alert("Cooperativa ya existe. Ingrese una nueva cooperativa");
					}*/
				//}else{
				//	dojo.style('aviso','display','block');
				//}
			//}else{
			//	dojo.style('aviso','display','block');
			//}
	}
	//////////CONSULTAR OPERADOR ///////////
	function mostrarciudad(valor)
	{
		if(valor == "Por ciudad"){
			dojo.style('lblciudad','display','');
			dojo.style('txtciudad','display','');
		}else{
			dojo.style('lblciudad','display','none');
			dojo.style('txtciudad','display','none');
		}
	}	
	function buscarOperadores()
	{	
		dojo.style('idEspera','display','block');
		if(dijit.byId("buscarpor").value == 'Todos'){
			dojo.xhrPost({
				handleAs:"json",
			    url    :  "/siswebrceo/public/siscp/operador/buscaroperadores",
			    load   :  function(response, ioArgs)
			              {
							if(response.items.length > 0){
								dojo.style('idEspera','display','none');
								var newStore = new dojo.data.ItemFileReadStore({data:response});
								dijit.byId("grilla").setStore(newStore);
							}else{
								dojo.style('idEspera','display','none');
								alert("No se encuentran Proveedores");
							}
							return response;
			              },
			    error  :  function(response, ioArgs)
			              { 
			                return response;
			              },
			    content:
			              { 
			    	      }
			  });
		
		}else{
			dojo.xhrPost({
				handleAs:"json",
			    url    :  "/siswebrceo/public/siscp/operador/buscaroperadoresxciudad",
			    load   :  function(response, ioArgs)
			              {
							if(response.items.length > 0){
								dojo.style('idEspera','display','none');
								var newStore = new dojo.data.ItemFileReadStore({data:response});
								dijit.byId("grilla").setStore(newStore);
							}else{
								dojo.style('idEspera','display','none');
								alert("No se encuentran Operadores en la ciudad de "+dijit.byId("ciudad").value);
							}
							return response;
			              },
			    error  :  function(response, ioArgs)
			              { 
			                return response;
			              },
			    content:
			              { 
			            	  "ciudad"       :dijit.byId("ciudad").value
			    	      }
			  });
			
		}
	}
	function cancelarOperadoring()
	{
		window.location.assign("/siswebrceo/public/siscp/operador/ingoperador");
	}
	
	function guardarOperador()
	{	
			//if((dijit.byId("razon").value != ""))
			//{
				//if((dijit.byId("razon").isValid()))
				//{
					//if(bandexiste == true)
					//{
					dojo.xhrPost({
						handleAs:"text",
					    url    :  "/siswebrceo/public/siscp/operador/guardaroperador", 
					    load   :  function(response, ioArgs)
					              {
									if(response=='Grabado Exitosamente')
									{
										alert(response);
										var band = confirm("Desea grabar otro Operador?");
					    				if(band){
					    					window.location.assign("/siswebrceo/public/siscp/operador/ingoperador");
					    				}else{
					    					window.location.assign("/siswebrceo/public/siscp/operador/ingoperador");
					    				}
									}else{
										alert(response);
									}
								   return response;
					              },
					    error  :  function(response, ioArgs)
					              { 
					            	  alert(response);
					                return response;
					              },
					    content: 
					     		{ 
					    	      "cedula"          		:dijit.byId("cedula").value,
					    	      "nombresop"      	        :dijit.byId("nombresop").value,
					    	      "apellidosop"       		:dijit.byId("apellidosop").value,
					    	      "ciudad"       	  		:dijit.byId("ciudad").value
					     		}
					  });
					/*}else{
						alert("Cooperativa ya existe. Ingrese una nueva cooperativa");
					}*/
				//}else{
				//	dojo.style('aviso','display','block');
				//}
			//}else{
			//	dojo.style('aviso','display','block');
			//}
	}
	//////////CONSULTAR OPERADOR ///////////
	function mostrarciudad(valor)
	{
		if(valor == "Por ciudad"){
			dojo.style('lblciudad','display','');
			dojo.style('txtciudad','display','');
		}else{
			dojo.style('lblciudad','display','none');
			dojo.style('txtciudad','display','none');
		}
	}
	function buscarOperadores()
	{	
		cont=1;
		dojo.style('idEspera','display','block');
		if(dijit.byId("buscarpor").value == 'Todos'){
			dojo.xhrPost({
				handleAs:"json",
			    url    :  "/siswebrceo/public/siscp/operador/buscaroperadores",
			    load   :  function(response, ioArgs)
			              {
							if(response.items.length > 0){
								dojo.style('idEspera','display','none');
								var newStore = new dojo.data.ItemFileReadStore({data:response});
								dijit.byId("grilla").setStore(newStore);
							}else{
								dojo.style('idEspera','display','none');
								alert("No se encuentran Proveedores");
							}
							return response;
			              },
			    error  :  function(response, ioArgs)
			              { 
			                return response;
			              },
			    content:
			              { 
			    	      }
			  });
		
		}else{
			dojo.xhrPost({
				handleAs:"json",
			    url    :  "/siswebrceo/public/siscp/operador/buscaroperadoresxciudad",
			    load   :  function(response, ioArgs)
			              {
							if(response.items.length > 0){
								dojo.style('idEspera','display','none');
								var newStore = new dojo.data.ItemFileReadStore({data:response});
								dijit.byId("grilla").setStore(newStore);
							}else{
								dojo.style('idEspera','display','none');
								alert("No se encuentran Operadores en la ciudad de "+dijit.byId("ciudad").value);
							}
							return response;
			              },
			    error  :  function(response, ioArgs)
			              { 
			                return response;
			              },
			    content:
			              { 
			            	  "ciudad"       :dijit.byId("ciudad").value
			    	      }
			  });
			
		}
	}
	
	var checkFormatter = function(data, rowIndex){
    	return cont++;
	};
	function buscarmodificaroperador()
	{	
		var idop;
		  var items = grilla.selection.getSelected();
		  if (items.length) {
		      dojo.forEach(items, function(selectedItem) {
		          if (selectedItem !== null) {
		        	  idop      = grilla.store.getValues(selectedItem, 'op_id');
		          }
		      }); 
		        dojo.style('idEspera','display','block');
				dojo.xhrPost({
					handleAs:"json",
				    url    :  "/siswebrceo/public/siscp/operador/buscaroperadorid",
				    load   :  function(response, ioArgs)
				              {
								if(response.items.length > 0){
									dojo.fx.wipeOut({
							            node: "wipeDisplayNode",
							            duration: 600
							        }).play();
									dojo.style('mostraroperador','display','block');
									dijit.byId("idop").setValue(response.items[0].op_id);
									dijit.byId("cedula").setValue(response.items[0].op_cedula);
									dijit.byId("apellidosop").setValue(response.items[0].op_apellidos);
									dijit.byId("nombresop").setValue(response.items[0].op_nombres);
									dijit.byId("ciudad1").setValue(response.items[0].op_ciudad);
									dojo.style('idEspera','display','none');
								}else{
									dojo.style('idEspera','display','none');
									alert("Operador no existe");
								}
					          return response;
				              },
				    error  :  function(response, ioArgs)
				              { 
				                return response;
				              },
				    content:
				              { 
				            	 "idop"        :idop
				    	      }
				  });
		  }
		  else{
			  alert('Debe seleccionar algun operador para modificarlo');
		  }
	}
	function cancelarActOperador()
	{
		dojo.style('mostraroperador','display','none');
		dojo.fx.wipeIn({
            node: "wipeDisplayNode",
            duration: 600
        }).play();
	}
	function actualizarOperador()
	{	
	    dojo.xhrPost({
			handleAs:"text",
		    url    :  "/siswebrceo/public/siscp/operador/actualizaroperador", 
		    load   :  function(response, ioArgs)
		              {
				    	if(response=='Actualizado Exitosamente')
						{
				    		alert(response);
				    		dojo.style('mostraroperador','display','none');
		    				dojo.style('aviso','display','none');
		    				dojo.fx.wipeIn({
		    		            node: "wipeDisplayNode",
		    		            duration: 600
		    		        }).play();
		    				buscarOperadores();
						}else{
							alert(response);
						}
					   return response;
		              },
		    error  :  function(response, ioArgs)
		              { 
		            	  alert(response);
		                return response;
		              },
		    content: 
		     		{ 
		            	  "cedula"          		:dijit.byId("cedula").value,
			    	      "apellidosop"      	    :dijit.byId("apellidosop").value,
			    	      "nombresop"       		:dijit.byId("nombresop").value,
			    	      "ciudad"       	  		:dijit.byId("ciudad1").value,
			    	      "idop"      	  		    :dijit.byId("idop").value
		     		}
		  });
	}
	function eliminarOperador() 
	{
		var idop;
		  var items = grilla.selection.getSelected();
		  if (items.length) {
		      dojo.forEach(items, function(selectedItem) {
		          if (selectedItem !== null) {
		        	  idop      = grilla.store.getValues(selectedItem, 'op_id');
		          }
		      });  
			  dojo.xhrPost({
			 	handleAs:"text",
			    url    :  "/siswebrceo/public/siscp/operador/eliminaroperador",
			    load   :  function(response, ioArgs)
			              {
						    if(response=='Eliminado Exitosamente')
							{
						    	alert(response);
						    	buscarOperadores();
							}else{
								alert(response);
							}
		    				 
						    return response;
			              },
			    error  :  function(response, ioArgs)
			              { 
			            	  alert(response);
			                return response;
			              },
			    content: 
			     		{ 
			    	      "idop":idop
			     		}
			  });
		  }
		  else{
			  alert('Debe seleccionar algun operador para eliminarlo');
		  }
	}