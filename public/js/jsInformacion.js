	var conta=1;
	var today = new Date();
	//arreglo de los meses
	var meses = new makeArray(12);
	meses[0]  = "Enero";
	meses[1]  = "Febrero";
	meses[2]  = "Marzo";
	meses[3]  = "Abril";
	meses[4]  = "Mayo";
	meses[5]  = "Junio";
	meses[6]  = "Julio";
	meses[7]  = "Agosto";
	meses[8]  = "Septiembre";
	meses[9]  = "Octubre";
	meses[10] = "Noviembre";
	meses[11] = "Deciembre";

	//arreglo de los dias
	var dias_de_la_semana = new makeArray(7);
	dias_de_la_semana[0]  = "Domingo";
	dias_de_la_semana[1]  = "Lunes";
	dias_de_la_semana[2]  = "Martes";
	dias_de_la_semana[3]  = "Miércoles";
	dias_de_la_semana[4]  = "Jueves";
	dias_de_la_semana[5]  = "Viernes";
	dias_de_la_semana[6]  = "Sábado";
	
	function makeArray(n)
	{
		this.length = n;
		for (i=1;i<=n;i++){this[i]=0;}
		return this;
	}		
	function getFecha()
	{
		var day   = today.getDate();
		var month = today.getMonth();
		var year  = today.getYear();
		var dia = today.getDay();
		if (year < 1000) {year += 1900; }
		dijit.byId("lugfec").setValue("Machala, "+ day + " de " + meses[month] + " del " + year);
	}
	
	function getFechamod(dia,mes,anio)
	{
		var day   = dia;
		var month = mes;
		var year  = anio;
		if (year < 1000) {year += 1900; }
		dijit.byId("lugfechacon").setValue("Machala, "+ day + " de " + meses[month] + " del " + year);
	}
	
	function mostrardp(valor)
	{
    	if(valor =='DonacionP' || valor =='RevocatoriaP')
    	{
    		dojo.style('lbldp','display','');
    		dojo.style('txtdp','display','');
    	}else{
    		dojo.style('lbldp','display','none');
    		dojo.style('txtdp','display','none');
    	}
	}
	function mostrarfecha(valor)
	{
		if(valor == "fecha"){
			dojo.style('lblfecha','display','');
			dojo.style('txtfecha','display','');
		}else{
			dojo.style('lblfecha','display','none');
			dojo.style('txtfecha','display','none');
		}
	}
	function cancelarformd1(){
		window.location.assign("/siswebrceo/public/siscinf/ontot/form001");
	}
	function cancelarformd2(){
		window.location.assign("/siswebrceo/public/siscinf/ontot/form002");
	}
	function cancelarconsulta(){
		window.location.assign("/siswebrceo/public/siscinf/ontot/consultar");
	}
	var lugar = '';
	var nomape = '';
	var cedula = '';
	var codsep = '';
	var decision = '';
	var aux = '';
	var ced = '';
	var aux1 = '';
	function verformulariod1()
	{
		lugar = dijit.byId("lugfec").value;
		nomape = dijit.byId("apellidosop").value;
		cedula = dijit.byId("cedula").value;
		decision = dijit.byId("decision").value;
		var day   = today.getDate();
		var month = today.getMonth();
		var year  = today.getFullYear();
		aux = cedula.replace(/\s/g,"");
		ced = aux.replace('-',"");
		if((dijit.byId("lugfec").value != "")&&(dijit.byId("cedula").value != "")&&(dijit.byId("apellidosop").value != "")&&(dijit.byId("decision").value != 0))
		{
			//if((dijit.byId("razon").isValid()))
			//{
				dojo.xhrPost({
					handleAs:"text",
				    url    :  "/siswebrceo/public/siscinf/ontot/guardarform1", 
				    load   :  function(response, ioArgs)
				              {
								var respuesta = response;
								codsep = respuesta.split(":");
								if(codsep[0]=='Grabado Exitosamente')
								{
									if(decision == 'Negativa'){
										window.location.assign("/siswebrceo/public/siscinf/ontot/verform001?lf="+lugar+"&dp="+nomape+"&c="+cedula+"&num="+codsep[1]+"&dec=V3");
									}
									else if(decision == 'DonacionP')
									{	 
										   if(document.getElementById("organos").checked){
											   window.location.assign("/siswebrceo/public/siscinf/ontot/verform001?lf="+lugar+"&dp="+nomape+"&c="+cedula+"&num="+codsep[1]+"&dec=V1");
										   }else if(document.getElementById("tejidos").checked){
											   window.location.assign("/siswebrceo/public/siscinf/ontot/verform001?lf="+lugar+"&dp="+nomape+"&c="+cedula+"&num="+codsep[1]+"&dec=V2");
										   }
									}else if(decision == 'Revocatoria'){
										window.location.assign("/siswebrceo/public/siscinf/ontot/verform001?lf="+lugar+"&dp="+nomape+"&c="+cedula+"&num="+codsep[1]+"&dec=V4");
									}else if(decision == 'RevocatoriaP'){
										if(document.getElementById("organos").checked){
											   window.location.assign("/siswebrceo/public/siscinf/ontot/verform001?lf="+lugar+"&dp="+nomape+"&c="+cedula+"&num="+codsep[1]+"&dec=V5");
										   }else if(document.getElementById("tejidos").checked){
											   window.location.assign("/siswebrceo/public/siscinf/ontot/verform001?lf="+lugar+"&dp="+nomape+"&c="+cedula+"&num="+codsep[1]+"&dec=V6");
										   }
									}
								}
								else if(codsep[0]=='Registro ya existe')
								{
									alert("Registro ya existe, porfavor ingrese al menu consultar y reimprima el formulario");
								}else{
									alert("No se pudo grabar el registro, intentelo nuevamente.");
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
				    	      "lugar"          		:'Machala',
				    	      "fecha"      	        :year+"-"+(month+1)+"-"+day,
				    	      "cedula"       	  	:ced,
				    	      "apellidosopnom"      :nomape,
				    	      "tipo"       	  		:'D0001',
				    	      "decision"       	  	:dijit.byId("decision").value
				     		}
				  });
		}else{
			alert("Verifique que todos los campos esten llenos!!!!");
		}
	}
	
	function verformulariod2()
	{
		var lugar = dijit.byId("lugfec").value;
		var nomape = dijit.byId("apellidosop").value;
		var cedula = dijit.byId("cedula").value;
		var nomapere = dijit.byId("apellidosopre").value;
		var cedulare = dijit.byId("cedulare").value;
		decision = dijit.byId("decision").value;
		var day   = today.getDate();
		var month = today.getMonth();
		var year  = today.getFullYear();
		dojo.xhrPost({
			handleAs:"text",
		    url    :  "/siswebrceo/public/siscinf/ontot/guardarform2", 
		    load   :  function(response, ioArgs)
		              {
						var respuesta = response;
						var codsep = respuesta.split(":");
						if(codsep[0]=='Grabado Exitosamente')
						{
							if(decision == 'Negativa'){
								window.location.assign("/siswebrceo/public/siscinf/ontot/verform002?lf2="+lugar+"&dp2="+nomape+"&c2="+cedula+"&num2="+codsep[1]+"&dprp2="+nomapere+"&crp2="+cedulare+"&dec=V3");
							}
							else if(decision == 'DonacionP')
							{	 
								   if(document.getElementById("organos").checked){
									   window.location.assign("/siswebrceo/public/siscinf/ontot/verform002?lf2="+lugar+"&dp2="+nomape+"&c2="+cedula+"&num2="+codsep[1]+"&dprp2="+nomapere+"&crp2="+cedulare+"&dec=V1");
								   }else if(document.getElementById("tejidos").checked){
									   window.location.assign("/siswebrceo/public/siscinf/ontot/verform002?lf2="+lugar+"&dp2="+nomape+"&c2="+cedula+"&num2="+codsep[1]+"&dprp2="+nomapere+"&crp2="+cedulare+"&dec=V2");
								   }
							}else if(decision == 'Revocatoria'){
								window.location.assign("/siswebrceo/public/siscinf/ontot/verform002?lf2="+lugar+"&dp2="+nomape+"&c2="+cedula+"&num2="+codsep[1]+"&dprp2="+nomapere+"&crp2="+cedulare+"&dec=V4");
							}else if(decision == 'RevocatoriaP'){
								if(document.getElementById("organos").checked){
									   window.location.assign("/siswebrceo/public/siscinf/ontot/verform002?lf2="+lugar+"&dp2="+nomape+"&c2="+cedula+"&num2="+codsep[1]+"&dprp2="+nomapere+"&crp2="+cedulare+"&dec=V5");
								   }else if(document.getElementById("tejidos").checked){
									   window.location.assign("/siswebrceo/public/siscinf/ontot/verform002?lf2="+lugar+"&dp2="+nomape+"&c2="+cedula+"&num2="+codsep[1]+"&dprp2="+nomapere+"&crp2="+cedulare+"&dec=V6");
								   }
							}
							
							
						}else{
							alert("No se pudo grabar el registro, intentelo nuevamente.");
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
		    	      "lugar"          		:'Machala',
		    	      "fecha"      	        :year+"-"+(month+1)+"-"+day,
		    	      "cedula"       	  	:dijit.byId("cedula").value,
		    	      "apellidosopnom"      :dijit.byId("apellidosop").value,
		    	      "tipo"       	  		:'D0002',
		    	      "decision"       	  	:dijit.byId("decision").value,
		    	      "cedularp"       	  	:dijit.byId("cedulare").value,
		    	      "apellidosopnomrp"    :dijit.byId("apellidosopre").value
		     		}
		  });
	}
	function buscarFormularios()
	{
		conta=1;
		if(dijit.byId("fecha").isValid())
		{
			if(dijit.byId("fecha").value != '')
			{
				dojo.style('idEspera','display','block');
				dojo.xhrPost({
					handleAs:"json",
				    url    :  "/siswebrceo/public/siscinf/ontot/buscarontotxop",
				    load   :  function(response, ioArgs)
				              {
								if(response.items.length > 0){
									dojo.style('idEspera','display','none');
									var newStore = new dojo.data.ItemFileReadStore({data:response});
									dijit.byId("grilla").setStore(newStore);
								}else{
									dojo.style('idEspera','display','none');
									alert("No se encuentran formularios ingresados");
								}
								return response;
				              },
				    error  :  function(response, ioArgs)
				              { 
				                return response;
				              },
				    content:
				              { 
				            	  "fecha"  :dojo.byId("fecha").value
				    	      }
				  });
			}else{
				alert("Por favor..Elija un criterio de busqueda");
			}
		}else{
			alert("Por favor..Elija un operador");
		}
	 }
	var checkFormatter1 = function(data, rowIndex){
    	return conta++;
	};
	
	function modificarFormulario()
	{	
		var otid,fec1,fec;
		  var items = grilla.selection.getSelected();
		  if (items.length) {
		      dojo.forEach(items, function(selectedItem) {
		          if (selectedItem !== null) {
		        	  otid      = grilla.store.getValues(selectedItem, 'ot_id');
		          }
		      }); 
		        dojo.style('idEspera','display','block');
				dojo.xhrPost({
					handleAs:"json",
				    url    :  "/siswebrceo/public/siscinf/ontot/buscarontoid",
				    load   :  function(response, ioArgs)
				              {
								if(response.items.length > 0){
									dojo.fx.wipeOut({
							            node: "wipeDisplayNode",
							            duration: 600
							        }).play();
									dojo.style('mostrardatos','display','block');
									dijit.byId("idontotcon").setValue(response.items[0].ot_id);
									dijit.byId("numformcon").setValue(response.items[0].ot_num);
									dijit.byId("cedulacon").setValue(response.items[0].ot_cedula);
									dijit.byId("apellidosopcon").setValue(response.items[0].ot_apenom);
									dijit.byId("decisioncon").setValue(response.items[0].ot_desicion);
									fec = response.items[0].ot_fecha.split("-");
									fec1 = getFechamod(fec[2],(parseInt(fec[1])-1),fec[0]);
									dojo.style('idEspera','display','none');
								}else{
									dojo.style('idEspera','display','none');
									alert("Formulario no existe");
								}
					          return response;
				              },
				    error  :  function(response, ioArgs)
				              { 
				                return response;
				              },
				    content:
				              { 
				            	 "idontot"        :otid
				    	      }
				  });
		  }
		  else{
			  alert('Debe seleccionar algun registro para modificar o reimprimir');
		  }
	}
	
	function grabarconsultar()
	{
		var lugarfec = dijit.byId("lugfechacon").value;
		var nomape = dijit.byId("apellidosopcon").value;
		var cedula = dijit.byId("cedulacon").value;
		var numform = dijit.byId("numformcon").value;
		var day   = today.getDate();
		var month = today.getMonth();
		var year  = today.getFullYear();
		if((dijit.byId("lugfechacon").value != "")&&(dijit.byId("cedulacon").value != "")&&(dijit.byId("apellidosopcon").value != "")&&(dijit.byId("decisioncon").value != 0))
		{
				dojo.xhrPost({
					handleAs:"text",
				    url    :  "/siswebrceo/public/siscinf/ontot/actualizarform1", 
				    load   :  function(response, ioArgs)
				              {
								if(response=='Grabado Exitosamente')
								{
									window.location.assign("/siswebrceo/public/siscinf/ontot/verform001?lf="+lugarfec+"&dp="+nomape+"&c="+cedula+"&num="+numform);
								}else{
									alert("No se pudo grabar el registro, intentelo nuevamente.");
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
				    	      "lugar"          		:'Machala',
				    	      "fecha"      	        :year+"-"+(month+1)+"-"+day,
				    	      "cedula"       	  	:dijit.byId("cedulacon").value,
				    	      "apellidosopnom"      :dijit.byId("apellidosopcon").value,
				    	      "tipo"       	  		:'D0001',
				    	      "decision"       	  	:dijit.byId("decisioncon").value,
				    	      "id"       	  	    :dijit.byId("idontotcon").value
				     		}
				  });
		}else{
			alert("Verifique que todos los campos esten llenos!!!!");
		}
	}
	
	/*
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
	}*/