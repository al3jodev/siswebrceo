//VARIABLES GLOBALES
var id=0,idper=0;
var codsep = '';
var cont=1;
function cancelingpermiso()
{
	window.location.assign("/siswebrceo/public/siscinf/permiso/salcortas");
}

function guardardatospermiso()
{	
				dojo.xhrPost({
					handleAs:"text",
				    url    :  "/siswebrceo/public/siscinf/permiso/savepermiso", 
				    load   :  function(response, ioArgs)
				              {
								if(response=='Grabado Exitosamente')
								{
									   alert("Su solicitud ha sido "+response+"\nPor favor acerquese a la ventanilla de RRHH para retirar su ticket de permiso.");
				    			       window.location.assign("/siswebrceo/public/siscinf/index");
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
				    	      "horasalida"          :dojo.byId("horasalida").value,
				    	      "fechapermiso"      	:dojo.byId("fechapermiso").value,
				    	      "apellidosper"       	:dojo.byId("voperadores").value,
				    	      "cedula"              :dijit.byId("voperadores").value,
				    	      "observaciones"       :dijit.byId("observaciones").value
				     		}
				  });
}

function buscarpermisos()
{
	cont=1;
	dojo.style('idEspera','display','block');
	dojo.xhrPost({
		handleAs:"json",
	    url    :  "/siswebrceo/public/siscrh/permiso/buscarpermisos",
	    load   :  function(response, ioArgs)
	              {
					if(response.items.length > 0){
						dojo.style('idEspera','display','none');
						var newStore = new dojo.data.ItemFileReadStore({data:response});
						dijit.byId("grilla").setStore(newStore);
		    	    }else{
					    dojo.style('idEspera','display','none');
					    alert("No existen permisos el dia de hoy.");
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
function cierrepermisos()
{
	cont=1;
	dojo.style('idEspera','display','block');
	dojo.xhrPost({
		handleAs:"json",
	    url    :  "/siswebrceo/public/siscrh/permiso/cierrepermisos",
	    load   :  function(response, ioArgs)
	              {
					if(response.items.length > 0){
						dojo.style('idEspera','display','none');
						var newStore = new dojo.data.ItemFileReadStore({data:response});
						dijit.byId("grilla").setStore(newStore);
		    	    }else{
					    dojo.style('idEspera','display','none');
					    alert("No existen permisos el dia de hoy.");
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

var estadoFormatter = function(data, rowIndex){
	   if (data == 'Pendiente') {
	        return "<img  src='/siswebrceo/public/imagenes/abierto.png' height='32px' width='32px'/>";
	   }
	   if (data == 'Impreso') {
	        return "<img  src='/siswebrceo/public/imagenes/abierto.png' height='32px' width='32px'/> <img  src='/siswebrceo/public/imagenes/impresora.png' height='32px' width='32px'/>";
	   }
	   if (data == 'Cerrado') {
	        return "<img  src='/siswebrceo/public/imagenes/cerrado.png' height='32px' width='32px'/>";
	   }
};

var checkFormatter1 = function(data, rowIndex){
	return cont++;
};

function imprimirpermiso()
{
	var idperm=0;
	var items = grilla.selection.getSelected();
	  if (items.length) {
	      dojo.forEach(items, function(selectedItem) {
	          if (selectedItem !== null) {
	        	  idperm      = grilla.store.getValues(selectedItem, 'perm_id');
	          }
	      });
	      dojo.xhrPost({
		  		handleAs:"text",
		  	    url    :  "/siswebrceo/public/siscrh/permiso/cambiarestper",
		  	    load   :  function(response, ioArgs)
		  	              {
		  	    				if(response == 'Actualizado Exitosamente'){
		  	    					window.location.assign("/siswebrceo/public/siscrh/permiso/impticket?id="+idperm);
		  	    				}else{
		  	    					alert("Problemas con el servidor");
		  	    				}
		  	    				
		  		          	return response;
		  	              },
		  	    error  :  function(response, ioArgs)
		  	              { 
		  	                return response;
		  	              },
		  	    content:
		  	              { 
		  	    				"idperm"          :idperm,
		  	    				"estado"          :'Impreso'
		  	    	      }
		  	  });
	      
     }else{
   	  	alert("Debe seleccionar un registro para poder imprimir");
     }
}
/*CIERRA EL PERMISO EL LIDER DE AREA CAMBIANDO EL ESTADO*/
function cerrarpermiso()
{
	var idperm=0;
	var items = grilla.selection.getSelected();
	  if (items.length) {
	      dojo.forEach(items, function(selectedItem) {
	          if (selectedItem !== null) {
	        	  idperm      = grilla.store.getValues(selectedItem, 'perm_id');
	        	  dojo.xhrPost({
	      	  		handleAs:"text",
	      	  	    url    :  "/siswebrceo/public/siscrh/permiso/cambiarestper",
	      	  	    load   :  function(response, ioArgs)
	      	  	              {
	      	  	    			alert(response);
	      	  	    		    cierrepermisos();
	      	  		          	return response;
	      	  	              },
	      	  	    error  :  function(response, ioArgs)
	      	  	              { 
	      	  	                return response;
	      	  	              },
	      	  	    content:
	      	  	              { 
	      	  	    				"idperm"          :idperm,
	      	  	    				"estado"          :'Cerrado'
	      	  	    	      }
	      	  	  });
	          }
	      });
	      
     }else{
   	  	alert("Debe seleccionar un registro para poder cerrar ticket");
     }
	  
}

function buscarpermisosxfecha()
{
	cont=1;
	dojo.style('idEspera','display','block');
	dojo.xhrPost({
		handleAs:"json",
	    url    :  "/siswebrceo/public/siscrh/permiso/buscarpermisosxfecha",
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

function imprimirRptsalidascortas()
{
	var fd,fh;
	fd=dojo.byId("fechadesde").value;
	fh=dojo.byId("fechahasta").value;
	window.location.assign("/siswebrceo/public/siscrh/permiso/imprptsalcortas?fd="+fd+"&fh="+fh);
}