	var cont=1;
	function habilitarCajasUsuario(valor)
	{
		if(valor == false){
			dojo.style('lblusu1','display','none');
			dojo.style('lblusu2','display','none');
			dojo.style('cmbusu1','display','none');
			dojo.style('cmbusu2','display','none');
		}else{
			dojo.style('lblusu1','display','');
			dojo.style('lblusu2','display','');
			dojo.style('cmbusu1','display','');
			dojo.style('cmbusu2','display','');
		}
	}
	function habilitarCajasMatrimonio(valor)
	{
		if(valor == false){
			dojo.style('cmbmat','display','none');
			dojo.style('lblusu3','display','none');
			dojo.style('cmbusu3','display','none');
		}else{
			dojo.style('cmbmat','display','');
			dojo.style('lblusu3','display','');
			dojo.style('cmbusu3','display','');
		}
	}
	function habilitarCajasPadre(valor)
	{
		dijit.byId("cedpadre").setDisabled(!valor);
		dijit.byId("apenompadre").setDisabled(!valor);
		dijit.byId("provpadre").setDisabled(!valor);
		dijit.byId("tipocipadre").setDisabled(!valor);
		dijit.byId("aspadre").setDisabled(!valor);
		dijit.byId("cedpadre").setValue('');
		dijit.byId("apenompadre").setValue('');
		dijit.byId("provpadre").setValue('0');
		dijit.byId("tipocipadre").setValue('0');
		dijit.byId("aspadre").setValue('');
		if(valor == false)
			dojo.style('datpadre','display','none');
		else
			dojo.style('datpadre','display','block');
	}
	function habilitarCajasMadre(valor)
	{
		dijit.byId("cedmadre").setDisabled(!valor);
		dijit.byId("apenommadre").setDisabled(!valor);
		dijit.byId("provmadre").setDisabled(!valor);
		dijit.byId("tipocimadre").setDisabled(!valor);
		dijit.byId("asmadre").setDisabled(!valor);
		dijit.byId("cedmadre").setValue('');
		dijit.byId("apenommadre").setValue('');
		dijit.byId("provmadre").setValue('0');
		dijit.byId("tipocimadre").setValue('0');
		dijit.byId("asmadre").setValue('');
		if(valor == false)
			dojo.style('datmadre','display','none');
		else
			dojo.style('datmadre','display','block');
	}
	function habilitarCajasConyuge(valor)
	{
		dijit.byId("cedconyuge").setDisabled(!valor);
		dijit.byId("apenomconyuge").setDisabled(!valor);
		dijit.byId("provconyuge").setDisabled(!valor);
		dijit.byId("tipociconyuge").setDisabled(!valor);
		dijit.byId("asconyuge").setDisabled(!valor);
		dijit.byId("cedconyuge").setValue('');
		dijit.byId("apenomconyuge").setValue('');
		dijit.byId("provconyuge").setValue('0');
		dijit.byId("tipociconyuge").setValue('0');
		dijit.byId("asconyuge").setValue('');
		if(valor == false)
			dojo.style('datconyuge','display','none');
		else
			dojo.style('datconyuge','display','block');
	}
	function habilitarCajasval()
	{
			dojo.style('lblusu','display','none');
			dojo.style('txtusu','display','none');
			mostrarfecharespuesta();
	}
	function habilitarCajasval1()
	{
			dojo.style('lblusu','display','');
			dojo.style('txtusu','display','');
			mostrarfecharespuesta();
	}
	function mostrarfecharespuesta(){
			hoy = new Date();
			i=0;
			while (i<8) {
				hoy.setTime(hoy.getTime()+24*60*60*1000);
				if (hoy.getDay() != 6 && hoy.getDay() != 0)
					i++;
			}
			mes = hoy.getMonth()+1;
			if (mes<10) 
				mes = '0'+mes;

			fecha = hoy.getFullYear()+ '-'+ mes + '-' + hoy.getDate();
			dijit.byId("fechares").setValue(fecha);
	}
	function cancelarSolicitudPartida()
	{
		alert(dijit.byId("piusuario").checked);
	    alert(dijit.byId("pipadre").checked);
	    alert(dijit.byId("pimadre").checked);
	    alert(dijit.byId("piconyuge").checked);
		window.location.assign("/siswebrceo/public/sisced/validar/ingsolicitud");
	}
	var cedula='';
	function eliminarspace(cedula){
		var aux = '',ced='';
		aux = cedula.replace(/\s/g,"");
		ced = aux.replace('-',"");
		return ced;
	}
	function guardarSolicitudPartida()
	{	
		
		var tipced="";
		   if(dijit.byId("pvez").checked){
			   tipced = dijit.byId("pvez").value;
		   }else{
			   tipced = dijit.byId("renova").value;
		   }
		   
		dojo.xhrPost({
			handleAs:"text",
		    url    :  "/siswebrceo/public/sisced/validar/guardarsolicitud", 
		    load   :  function(response, ioArgs)
		              {
						if(response=='Grabado Exitosamente')
						{
							alert(response);
		    				window.location.assign("/siswebrceo/public/sisced/validar/ingsolicitud");
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
		    	      "piusuario"            	:dijit.byId("piusuario").checked,
		    	      "pipadre"      	        :dijit.byId("pipadre").checked,
		    	      "pimadre"       		    :dijit.byId("pimadre").checked,
		    	      "piconyuge"       	  	:dijit.byId("piconyuge").checked,
		    	      "valusuario"            	:dijit.byId("piusuario").value,
		    	      "valpadre"      	        :dijit.byId("pipadre").value,
		    	      "valmadre"       		    :dijit.byId("pimadre").value,
		    	      "valconyuge"       	  	:dijit.byId("piconyuge").value,
		    	      "tipocedulacion"         	:tipced,
		    	      "cedusuario"       	  	:eliminarspace(dijit.byId("cedusuario").value),
		    	      "apenomusu"       	  	:dijit.byId("apenomusu").value,
		    	      "provusuario"       	  	:dijit.byId("provusuario").value,
		    	      "tipociusuario"          	:dijit.byId("tipociusuario").value,
		    	      "cedpadre"       	  		:eliminarspace(dijit.byId("cedpadre").value),
		    	      "apenompadre"       	  	:dijit.byId("apenompadre").value,
		    	      "provpadre"       	  	:dijit.byId("provpadre").value,
		    	      "tipocipadre"          	:dijit.byId("tipocipadre").value,
		    	      "cedmadre"       	  		:eliminarspace(dijit.byId("cedmadre").value),
		    	      "apenommadre"       	  	:dijit.byId("apenommadre").value,
		    	      "provmadre"       	  	:dijit.byId("provmadre").value,
		    	      "tipocimadre"          	:dijit.byId("tipocimadre").value,
		    	      "cedconyuge"       	  	:eliminarspace(dijit.byId("cedconyuge").value),
		    	      "apenomconyuge"      	  	:dijit.byId("apenomconyuge").value,
		    	      "provconyuge"       	  	:dijit.byId("provconyuge").value,
		    	      "tipociconyuge"          	:dijit.byId("tipociconyuge").value,
		    	      "telefono"       	  		:dijit.byId("telefono").value,
		    	      "observacion"       	  	:dijit.byId("observacion").value,
		    	      "correoe"       	  	    :dijit.byId("correoe").value,
		    	      "fechares"          	  	:dijit.byId("fechares").value,
		    	      "numsol"          	  	:dijit.byId("numsol").value,
		    	      "asusuario"       	  	:dijit.byId("asusu").value,
		    	      "aspadre"       	  	    :dijit.byId("aspadre").value,
		    	      "asmadre"          	  	:dijit.byId("asmadre").value,
		    	      "asconyuge"          	  	:dijit.byId("asconyuge").value,
		     		}
		  });
	}
	
	function buscarSolicitudes()
	{
		cont=1;
		dojo.style('idEspera','display','block');
		dojo.xhrPost({
			handleAs:"json",
		    url    :  "/siswebrceo/public/sisced/validar/buscarsolicitudes",
		    load   :  function(response, ioArgs)
		              {
						if(response.items.length > 0){
							dojo.style('idEspera','display','none');
							var newStore = new dojo.data.ItemFileReadStore({data:response});
							dijit.byId("grilla").setStore(newStore);
			    	    }else{
						    dojo.style('idEspera','display','none');
						    alert("No existen solicitudes el dia de hoy.");
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
	}
	var checkFormatter1 = function(data, rowIndex){
		return cont++;
	};
	
	function buscarsolicitudxfecha()
	{
		cont=1;
		dojo.style('idEspera','display','block');
		dojo.xhrPost({
			handleAs:"json",
		    url    :  "/siswebrceo/public/sisced/validar/buscarsolicitudxfecha",
		    load   :  function(response, ioArgs)
		              {
						if(response.items.length > 0){
							dojo.style('idEspera','display','none');
							var newStore = new dojo.data.ItemFileReadStore({data:response});
							dijit.byId("grilla").setStore(newStore);
			    	    }else{
						    dojo.style('idEspera','display','none');
						    alert("No existen permisos en el rango de fechas seleccionados.");
						}
			          return response;
		              },
		    error  :  function(response, ioArgs)
		              { 
		                return response;
		              },
		    content:
		              { 
		    				"fechadesde"          :dojo.byId("fechadesde").value,
		    				"fechahasta"          :dojo.byId("fechahasta").value
		    	      }
		  });
	}
	function imprimirRptsolicitudes()
	{
		var fd,fh;
		fd=dojo.byId("fechadesde").value;
		fh=dojo.byId("fechahasta").value;
		window.location.assign("/siswebrceo/public/sisced/validar/imprptsolicitudes?fd="+fd+"&fh="+fh);
	}
	function verificarDuplicado()
	{
		dojo.style('idEspera','display','block');
		dojo.style('idOk','display','none');
		dojo.style('idX','display','none');
		dojo.xhrPost({
		handleAs:"json",
	    url    :  "/siswebrceo/public/sisced/validar/buscarsolicituxced",
	    load   :  function(response, ioArgs)
	              {
					if(response.items.length > 0){
						dojo.style('idEspera','display','none');
						dojo.style('idX','display','');
						alert('El usuario ya ha realizado una solicitud de partida.');
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
	            	  "cedula"  :eliminarspace(dijit.byId("cedusuario").value)
	    	      }
	  });
	}
	/*AGREGA ERRORES A LA GRILLA
	function addError() 
	{
		conta=1;
		msjtotal = dojo.byId('tote');
		if(dijit.byId("autores").value == 0)
		{
			alert("Debe elegir un autor");
		}
		else
		{
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
	
	ELIMINAR ERRORES DE LA GRILLA
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
					    	      "tipoerror"      	        :dijit.byId("tipoerror").value,
					    	      "descripcion"       		:dijit.byId("descripcion").value
					     		}
					  });
					}else{
						alert("Cooperativa ya existe. Ingrese una nueva cooperativa");
					}
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
		    				dojo.fx.wipeIn({
		    		            node: "wipeDisplayNode",
		    		            duration: 600
		    		        }).play();
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
		dojo.style('mostrarproduc','display','none');
		dojo.fx.wipeIn({
            node: "wipeDisplayNode",
            duration: 600
        }).play();
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
	}*/