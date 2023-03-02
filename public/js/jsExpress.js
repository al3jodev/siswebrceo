	var cont=1;
	
	function llenarCombo() 
	{  	
		  dojo.xhrPost
		  ({
			handleAs:"json",
		    url    :  "/siswebrceo/public/sisexp/partidas/getprovinciaxfecha",
		    load   :  function(response, ioArgs)
		              {
			  			  var dato=new dojo.data.ItemFileReadStore({data:response});
			  				dijit.byId("provincia").store=dato;  
			          return response;
		              },
		    error  :  function(response, ioArgs)
		              { 
		                return response;
		              },
		    content:
		              { 
		    				"fecha"          :dojo.byId("fecha").value,
		    	      }
		   
		  });
	}
	
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
