	var conta=1;
	var msjtotal='';
	var totenmiendas=0;
	function habilitarCajas()
	{
		dijit.byId("fechaproduc").setDisabled(false);
		dijit.byId("totrenova").setDisabled(false);
		dijit.byId("totpvez").setDisabled(false);
		dijit.byId("totenmiendas").setDisabled(false);
		dijit.byId("totrechazos").setDisabled(false);
		dijit.byId("observacion").setDisabled(false);
		dijit.byId("lugarem").setDisabled(false);
		dijit.byId("fechaproduc").setValue('');
		dijit.byId("totrenova").setValue('0');
		dijit.byId("totpvez").setValue('0');
		dijit.byId("totenmiendas").setValue('0');
		dijit.byId("totrechazos").setValue('0');
		dijit.byId("observacion").setValue('');
		dijit.byId("cantidad").setValue('');
		//dijit.byId("terror").setValue('');
		dijit.byId("voperadoresenm").setDisplayedValue(dojo.byId("voperadores").value);

		dojo.xhrPost({
			handleAs:"json",
		    url    :  "/siswebrceo/public/siscp/operador/buscaroperadorid",
		    load   :  function(response, ioArgs)
		              {
						if(response.items.length > 0){
							dijit.byId("lugarem").setDisplayedValue(response.items[0].op_ciudad);
						}
			          return response;
		              },
		    error  :  function(response, ioArgs)
		              { 
		                return response;
		              },
		    content:
		              { 
		            	 "idop"        :dijit.byId("voperadores").value
		    	      }
		  });
	}
	function cancelarProduccioning()
	{
		window.location.assign("/siswebrceo/public/siscp/produccion/ingproducd");
	}
	
	function guardarProduccion()
	{	
		var errores='',cantidades='',codoperadores='';	
	    var a_errores = new Array(conta);
	    var a_cantidades = new Array(conta);
	    var a_codoperadores = new Array(conta);
	    for(i=0;i<conta-1;i++){
	    	a_errores[i] = grilla.store.getValue(grilla.getItem(i), 'te_id');
	    	a_cantidades[i] = grilla.store.getValue(grilla.getItem(i), 'cantidad');
	    	a_codoperadores[i] = grilla.store.getValue(grilla.getItem(i), 'codope');
	    }
	    errores = a_errores.join(";");
	    cantidades = a_cantidades.join(";");
	    codoperadores = a_codoperadores.join(";");
	    if((totenmiendas == 0))
		{
				//if((dijit.byId("razon").isValid()))
				//{
					//if(bandexiste == true)
					//{
					dojo.xhrPost({
						handleAs:"text",
					    url    :  "/siswebrceo/public/siscp/produccion/guardarproduc", 
					    load   :  function(response, ioArgs)
					              {
									if(response=='Grabado Exitosamente')
									{
										alert(response);
										var band = confirm("Desea grabar otro ?");
					    				if(band){
					    					window.location.assign("/siswebrceo/public/siscp/produccion/ingproducd");
					    				}else{
					    					window.location.assign("/siswebrceo/public/siscp/produccion/ingproducd");
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
					    	      "idop"            		:dijit.byId("voperadores").value,
					    	      "fechaproduc"      	    :dojo.byId("fechaproduc").value,
					    	      "totrenova"       		:dijit.byId("totrenova").value,
					    	      "observacion"       	  	:dijit.byId("observacion").value,
					    	      "totpvez"       	  		:dijit.byId("totpvez").value,
					    	      "totenmiendas"       	  	:dijit.byId("totenmiendas").value,
					    	      "totrechazos"       	  	:dijit.byId("totrechazos").value,
					    	      "lugarem"          	  	:dijit.byId("lugarem").value,
					    	      "errores"          	  	:errores,
					    	      "cantidades"          	:cantidades,
					    	      "codoperadores"          	:codoperadores
					     		}
					  });
					/*}else{
						alert("Cooperativa ya existe. Ingrese una nueva cooperativa");
					}*/
				//}else{
				//	dojo.style('aviso','display','block');
				//}
			}else{
				alert("Revisar el detalle de errores. Faltan errores por ingresar!!");
			}
	}
	/*AGREGA ERRORES A LA GRILLA*/
	function addError() 
	{
		conta=1;
		msjtotal = dojo.byId('tote');
		/*if(dijit.byId("autores").value == 0)
		{
			alert("Debe elegir un autor");
		}
		else
		{*/
		if(dijit.byId('cantidad').value != 0){
			if(dijit.byId('cantidad').value <= totenmiendas){
				jsonStore.newItem({te_id: ""+(dijit.byId('terror').value),tipo: ""+(dojo.byId('terror').value),cantidad: ""+dijit.byId('cantidad').value,codope:""+dijit.byId('voperadoresenm').value});
			    totenmiendas = totenmiendas - dijit.byId('cantidad').value;
			    msjtotal.innerHTML="Numero de errores a ingresar: "+totenmiendas;
			}else{
				alert("El total de errores ingresados es mayor al numero total de enmiendas!!");
				dijit.byId('cantidad').setValue('');
			}
		}else{
			alert("No se puede ingresar errores con cantidad igual a 0");
		}
		    
		    //varCodigo++;
		    //dojo.style('gridaut','display','block');
		    // dijit.byId("autores").setDisplayedValue("");
		//}
	}
	
	/*ELIMINAR ERRORES DE LA GRILLA*/
	function deleteError() 
	{
		conta=1;
		msjtotal = dojo.byId('tote');
		var items = grilla.selection.getSelected();
		  if (items.length) {
		      dojo.forEach(items, function(selectedItem) {
		          if (selectedItem !== null) {
		        	  cantidad      = grilla.store.getValues(selectedItem, 'cantidad');
		        	  grilla.removeSelectedRows();
		        	  totenmiendas = totenmiendas + parseInt(cantidad);
		        	  msjtotal.innerHTML="Numero de errores a ingresar: "+totenmiendas;
		          }
		      }); 
		  }
	}
		  
	var checkFormatter1 = function(data, rowIndex){
    	return conta++;
	};
	
	function mostrartotal(valor,band)
	{
		msjtotal = dojo.byId('tote');
		//dojo.style('msjcedula','display','none');
		if(band == 'enm')
			totenmiendas = parseInt(valor) + parseInt(dijit.byId("totrechazos").value);
		if(band == 'rec')
			totenmiendas = parseInt(valor) + parseInt(dijit.byId("totenmiendas").value);
		msjtotal.innerHTML="Numero de errores a ingresar: "+totenmiendas;
		if(totenmiendas != 0){
			dijit.byId("terror").setDisabled(false);
			dijit.byId("cantidad").setDisabled(false);
			dijit.byId("btnaddterror").setDisabled(false);
			dijit.byId("btnaddge").setDisabled(false);
			dijit.byId("btndelge").setDisabled(false);
			dijit.byId("mycheck").setDisabled(false);
		}else{
			dijit.byId("terror").setDisabled(true);
			dijit.byId("cantidad").setDisabled(true);
			dijit.byId("mycheck").setDisabled(true);
			dijit.byId("btnaddterror").setDisabled(true);
			dijit.byId("btnaddge").setDisabled(true);
			dijit.byId("btndelge").setDisabled(true);
		}
	}
	function cancelardlgingerror()
	{
		dijit.byId('newtError').hide();
		dijit.byId("tipoerror").setValue('');
		dijit.byId("descripcion").setValue('');
	}
	function guardarError()
	{	
			//if((dijit.byId("razon").value != ""))
			//{
				//if((dijit.byId("razon").isValid()))
				//{
					//if(bandexiste == true)
					//{
					dojo.xhrPost({
						handleAs:"text",
					    url    :  "/siswebrceo/public/siscp/terror/guardarerror", 
					    load   :  function(response, ioArgs)
					              {
									if(response=='Grabado Exitosamente')
									{
										alert(response);
										dijit.byId('newtError').hide();
										dijit.byId("tipoerror").setValue('');
										dijit.byId("descripcion").setValue('');
										dojo.xhrPost
										  ({
											handleAs:"json",
										    url    :  "/siswebrceo/public/siscp/terror/getterrores",
										    load   :  function(response, ioArgs)
										              {
											  			  var dato=new dojo.data.ItemFileReadStore({data:response});
											  			  dijit.byId("terror").store=dato;
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
										/*var band = confirm("Desea grabar otro Operador?");
					    				if(band){
					    					window.location.assign("/siswebrceo/public/siscp/operador/ingoperador");
					    				}else{
					    					window.location.assign("/siswebrceo/public/siscp/operador/ingoperador");
					    				}*/
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
					    	      "tipoerror"      	        :dijit.byId("tipoerror").value,
					    	      "descripcion"       		:dijit.byId("descripcion").value
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
	
	function mostraropenmienda(valor)
	{
		if(valor == true){
			dojo.style('lblopenm','display','');
			dojo.style('txtopenm','display','');
		}else{
			dojo.style('lblopenm','display','none');
			dojo.style('txtopenm','display','none');
		}
	}
	function mostrarmes(valor)
	{
		if(valor == "Mensual"){
			dojo.style('lblmes','display','');
			dojo.style('txtmes','display','');
			dojo.style('lblanio','display','');
			dojo.style('txtanio','display','');
			dojo.style('lblIngFechaDesde','display','none');
			dojo.style('txtIngFechaDesde','display','none');
			dojo.style('lblIngFechaHasta','display','none');
			dojo.style('txtIngFechaHasta','display','none');
		}else if(valor == "Rango"){
			dojo.style('lblIngFechaDesde','display','');
			dojo.style('txtIngFechaDesde','display','');
			dojo.style('lblIngFechaHasta','display','');
			dojo.style('txtIngFechaHasta','display','');
			dojo.style('lblmes','display','none');
			dojo.style('txtmes','display','none');
			dojo.style('lblanio','display','none');
			dojo.style('txtanio','display','none');
		}else{
			dojo.style('lblmes','display','none');
			dojo.style('txtmes','display','none');
			dojo.style('lblanio','display','none');
			dojo.style('txtanio','display','none');
			dojo.style('lblIngFechaDesde','display','none');
			dojo.style('txtIngFechaDesde','display','none');
			dojo.style('lblIngFechaHasta','display','none');
			dojo.style('txtIngFechaHasta','display','none');
		}
	}
	
	function buscarProdConsulta()
	{
		conta=1;
		if(dijit.byId("voperadores").isValid())
		{
			if(dijit.byId("buscarpor").value == 'Total')
			{
				dojo.style('idEspera','display','block');
				dojo.style('msjresumentotal','display','none');
				dojo.xhrPost({
					handleAs:"json",
				    url    :  "/siswebrceo/public/siscp/produccion/buscarproductotxop",
				    load   :  function(response, ioArgs)
				              {
								if(response.items.length > 0){
									dojo.style('idEspera','display','none');
									var newStore = new dojo.data.ItemFileReadStore({data:response});
									dijit.byId("grilladt").setStore(newStore);
								}else{
									dojo.style('idEspera','display','none');
									alert("No se encuentran registros para este operador");
								}
								return response;
				              },
				    error  :  function(response, ioArgs)
				              { 
				                return response;
				              },
				    content:
				              { 
				            	  "idop"  :dijit.byId("voperadores").value
				    	      }
				  });
			}else if(dijit.byId("buscarpor").value == 'Mensual'){
				if(dijit.byId("mes").isValid() && dijit.byId("mes").value != 0)
				{
					var msjresumentotal;
					msjresumentotal = dojo.byId('msjresumentotal');
					var totr=0,totpv=0,tote=0,totre=0,cont=0,i=0;
					dojo.style('idEspera','display','block');
					dojo.xhrPost({
						handleAs:"json",
					    url    :  "/siswebrceo/public/siscp/produccion/buscarproductotxopxmes",
					    load   :  function(response, ioArgs)
					              {
									if(response.items.length > 0){
										dojo.style('idEspera','display','none');
										dojo.style('msjresumentotal','display','block');
										var newStore = new dojo.data.ItemFileReadStore({data:response});
										dijit.byId("grilladt").setStore(newStore);
										cont = response.items.length;
										for(i=0;i<cont;i++){
											totr +=parseInt(response.items[i].pd_tot_renovacion);
											totpv+=parseInt(response.items[i].pd_tot_primeravez);
											tote +=parseInt(response.items[i].pd_tot_enmiendas);
											totre+=parseInt(response.items[i].pd_tot_rechazos);
										}
										msjresumentotal.innerHTML="<div class='recuadroColor'><div align='center'><b style='size:50px;' ><label class='letraSubtitulo'>Resumen del Mes de "+dojo.byId("mes").value+" del Operador "+dojo.byId("voperadores").value+"</label></b></div></div>";
										msjresumentotal.innerHTML+="<div class='Informacion'><div id='left' align='left' class='letraNormal'><b style='size: 100px;'><ul><li>Total de Renovaciones: "+totr+"</li><li>Total Primera vez: "+totpv+"</li><li>Total Enmiendas: "+tote+" </li><li>Total Rechazos: "+totre+"</li></b></div></div>";
									}else{
										dojo.style('idEspera','display','none');
										alert("No se encuentran registros en el mes de "+dojo.byId("mes").value+" del "+dojo.byId("anio").value+" para este operador");
									}
									return response;
					              },
					    error  :  function(response, ioArgs)
					              { 
					                return response;
					              },
					    content:
					              { 
					            	  "idop"  :dijit.byId("voperadores").value,
					            	  "numes" :dijit.byId("mes").value,
					            	  "anio"  :dijit.byId("anio").value
					    	      }
					  });
				}else{
					alert("Por favor..Elija un mes");
				}
			}else if(dijit.byId("buscarpor").value == 'Rango'){
				if((dojo.byId("fechadesde").value != '')&&(dojo.byId("fechahasta").value != ''))
				{
					dojo.style('idEspera','display','block');
					dojo.style('msjresumentotal','display','none');
					dojo.xhrPost({
					handleAs:"json",
				    url    :  "/siswebrceo/public/siscp/produccion/buscarproductotxopxrango",
				    load   :  function(response, ioArgs)
				              {
								if(response.items.length > 0){
									dojo.style('idEspera','display','none');
									var newStore = new dojo.data.ItemFileReadStore({data:response});
									dijit.byId("grilladt").setStore(newStore);
								}else{
									dojo.style('idEspera','display','none');
									alert("No se encuentran registros en este rango de fechas");
								}
								return response;
				              },
				    error  :  function(response, ioArgs)
				              { 
				                return response;
				              },
				    content:
				              { 
				            	  "idop"  :dijit.byId("voperadores").value,
				                  "fechadesde"  :dojo.byId("fechadesde").value,
				                  "fechahasta"  :dojo.byId("fechahasta").value
				    	      }
				  });
				}else{
					alert("Debe ingresar la fecha desde y la fecha hasta");
				}
			}else{
				alert("Por favor..Elija un criterio de busqueda");
			}
		}else{
			alert("Por favor..Elija un operador");
		}
	 }
	//MODIFICAR LA PRODUCCION DIARIA DE UN OPERADOR
	function modificarproduccion()
	{	
		var pd_id;
		  var items = grilladt.selection.getSelected();
		  if (items.length) {
		      dojo.forEach(items, function(selectedItem) {
		          if (selectedItem !== null) {
		        	  pd_id      = grilladt.store.getValues(selectedItem, 'pd_id');
		          }
		      }); 
		        dojo.style('idEspera','display','block');
				dojo.xhrPost({
					handleAs:"json",
				    url    :  "/siswebrceo/public/siscp/produccion/buscarproducxid",
				    load   :  function(response, ioArgs)
				              {
								if(response.items.length > 0){
									dojo.fx.wipeOut({
							            node: "wipeDisplayNode",
							            duration: 600
							        }).play();
									dojo.style('mostrarproduc','display','block');
									dijit.byId("codpd").setValue(response.items[0].pd_id);
									dijit.byId("voperadoresmod").setValue(dijit.byId("voperadores").value);
									dojo.attr("fechaproduc",{value: response.items[0].pd_fecha});
									dijit.byId("lugarem").setValue(response.items[0].pd_lugar_emision);
									dijit.byId("totrenova").setValue(response.items[0].pd_tot_renovacion);
									dijit.byId("totpvez").setValue(response.items[0].pd_tot_primeravez);
									dijit.byId("observacion").setValue(response.items[0].pd_observacion);
									dijit.byId("totenmiendas").setValue(response.items[0].pd_tot_enmiendas);
									dijit.byId("totrechazos").setValue(response.items[0].pd_tot_rechazos);
									dijit.byId("totenmiendas").focus();
									dijit.byId("totrechazos").focus();
									dijit.byId("observacion").focus();
									dojo.style('idEspera','display','none');
								}else{
									dojo.style('idEspera','display','none');
									alert("Registro no existe");
								}
					          return response;
				              },
				    error  :  function(response, ioArgs)
				              { 
				                return response;
				              },
				    content:
				              { 
				            	 "pdid"        :pd_id
				    	      }
				  });
		  }
		  else{
			  alert('Debe seleccionar el registro que desea modificar');
		  }
	}
	
	function actualizardatProduc()
	{
		var errores='',cantidades='',codoperadores='';	
	    var a_errores = new Array(conta);
	    var a_cantidades = new Array(conta);
	    var a_codoperadores = new Array(conta);
	    if(dijit.byId("totenmiendas").value > 0 || dijit.byId("totrechazos").value >0){
		    for(i=0;i<conta-1;i++){
		    	a_errores[i] = grilla.store.getValue(grilla.getItem(i), 'te_id');
		    	a_cantidades[i] = grilla.store.getValue(grilla.getItem(i), 'cantidad');
		    	a_codoperadores[i] = grilla.store.getValue(grilla.getItem(i), 'codope');
		    }
		    errores = a_errores.join(";");
		    cantidades = a_cantidades.join(";");
		    codoperadores = a_codoperadores.join(";");
	    }
	    if((totenmiendas == 0))
		{
		dojo.xhrPost({
			handleAs:"text",
		    url    :  "/siswebrceo/public/siscp/produccion/actproduccion", 
		    load   :  function(response, ioArgs)
		              {
				    	if(response=='Grabado Exitosamente')
						{
				    		alert("Actualizado Exitosamente");
				    		window.location.assign("/siswebrceo/public/siscp/produccion/conproducd");
				    		//dojo.style('mostrarproduc','display','none');
		    				/*dojo.fx.wipeIn({
		    		            node: "wipeDisplayNode",
		    		            duration: 600
		    		        }).play();*/
		    				//buscarProdConsulta();
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
		            	  "idop"            		:dijit.byId("voperadoresmod").value,
			    	      "fechaproduc"      	    :dojo.byId("fechaproduc").value,
			    	      "totrenova"       		:dijit.byId("totrenova").value,
			    	      "observacion"       	  	:dijit.byId("observacion").value,
			    	      "totpvez"       	  		:dijit.byId("totpvez").value,
			    	      "totenmiendas"       	  	:dijit.byId("totenmiendas").value,
			    	      "totrechazos"       	  	:dijit.byId("totrechazos").value,
			    	      "lugarem"          	  	:dijit.byId("lugarem").value,
			    	      "errores"          	  	:errores,
			    	      "cantidades"          	:cantidades,
			    	      "codoperadores"          	:codoperadores,
			    	      "codpd"            		:dijit.byId("codpd").value
		     		}
		  });
		}else{
			alert("Revisar el detalle de errores. Faltan errores por ingresar!!");
		}
		
	}
	function eliminarProduccion()
	{
		var pdid;
		  var items = grilladt.selection.getSelected();
		  if (items.length) {
		      dojo.forEach(items, function(selectedItem) {
		          if (selectedItem !== null) {
		        	  pdid      = grilladt.store.getValues(selectedItem, 'pd_id');
		          }
		      }); 
					dojo.xhrPost({
						handleAs:"text",
					    url    :  "/siswebrceo/public/siscp/produccion/eliproduccion", 
					    load   :  function(response, ioArgs)
					              {
							    	if(response=='Eliminado Exitosamente')
									{
							    		alert(response);
					    				buscarProdConsulta();
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
						    	      "pdid"            		:pdid
					     		}
					  });
		  }
		  else{
			  alert('Debe seleccionar algun registro para eliminarlo');
		  }
	}
	
	function cancelarDatosProduc()
	{
		/*dojo.style('mostrarproduc','display','none');
		dojo.fx.wipeIn({
            node: "wipeDisplayNode",
            duration: 600
        }).play();*/
		window.location.assign("/siswebrceo/public/siscp/produccion/conproducd");
	}
	
	function verificarDuplicado()
	{
		dojo.style('idEspera','display','block');
		dojo.style('idOk','display','none');
		dojo.style('idX','display','none');
		dojo.xhrPost({
		handleAs:"json",
	    url    :  "/siswebrceo/public/siscp/produccion/buscarproductotxopxrango",
	    load   :  function(response, ioArgs)
	              {
					if(response.items.length > 0){
						dojo.style('idEspera','display','none');
						dojo.style('idX','display','');
						alert('El operador ya tiene ingresada una produccion en esta fecha.');
					}else{
						dojo.style('idEspera','display','none');
						dojo.style('idOk','display','');
					}
					return response;
	              },
	    error  :  function(response, ioArgs)
	              { 
	                return response;
	              },
	    content:
	              { 
	            	  "idop"  :dijit.byId("voperadores").value,
	                  "fechadesde"  :dojo.byId("fechaproduc").value,
	                  "fechahasta"  :dojo.byId("fechaproduc").value
	    	      }
	  });
	}