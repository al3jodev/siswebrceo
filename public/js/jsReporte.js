
function mostrartipob(valor)
{
	if(valor == "d"){
		dojo.style('lblmes','display','none');
		dojo.style('txtmes','display','none');
		dojo.style('lblanio','display','none');
		dojo.style('txtanio','display','none');
		dojo.style('lblIngFechaHasta','display','none');
		dojo.style('txtIngFechaHasta','display','none');
		dojo.style('lblIngFechaDesde','display','none');
		dojo.style('lblIngFechaDesded','display','');
		dojo.style('txtIngFechaDesde','display','');
	}else if(valor == "s"){
		dojo.style('lblmes','display','none');
		dojo.style('txtmes','display','none');
		dojo.style('lblanio','display','none');
		dojo.style('txtanio','display','none');
		dojo.style('lblIngFechaHasta','display','');
		dojo.style('txtIngFechaHasta','display','');
		dojo.style('lblIngFechaDesde','display','');
		dojo.style('txtIngFechaDesde','display','');
		dojo.style('lblIngFechaDesded','display','none');
	}else{
		dojo.style('lblmes','display','');
		dojo.style('txtmes','display','');
		dojo.style('lblanio','display','');
		dojo.style('txtanio','display','');
		dojo.style('lblIngFechaDesde','display','none');
		dojo.style('txtIngFechaDesde','display','none');
		dojo.style('lblIngFechaHasta','display','none');
		dojo.style('txtIngFechaHasta','display','none');
		dojo.style('lblIngFechaDesded','display','none');
	}
}

/*PRESENTAR REPORTE POR MES*/
function verRptmenmach() 
{
	var tipo  = dijit.byId("tipor").attr("value");
	if(tipo == 'd'){//REPORTE DIARIO
		if(dijit.byId("fechadesde").isValid()){
			if(dojo.byId("fechadesde").value != ''){
				var fecd = dojo.byId("fechadesde").value;
				window.location.assign("/siswebrceo/public/siscp/reportes/verrptmenmach?fd="+fecd+"&tipo="+tipo);
			}else{
				alert("Los campos con (*) son obligatorios");
			}
		}else{
			alert("Los Datos Ingresados no son Validos");
		}
	}else if(tipo == 's'){//REPORTE SEMANAL
		if(dijit.byId("fechadesde").isValid() && dijit.byId("fechahasta").isValid()){
			if((dojo.byId("fechadesde").value != '') && (dojo.byId("fechahasta").value != '')){
				var feci = dojo.byId("fechadesde").value;
				var fecf = dojo.byId("fechahasta").value;
				window.location.assign("/siswebrceo/public/siscp/reportes/verrptmenmach?fi="+feci+"&ff="+fecf+"&tipo="+tipo);
			}else{
				alert("Los campos con (*) son obligatorios");
			}
		}else{
			alert("Los Datos Ingresados no son Validos");
		}
	}else if(tipo == 'm'){//REPORTE MENSUAL
		if((dijit.byId("anio").isValid()) && (dijit.byId("mes").isValid())){
			if((dijit.byId("anio").value != 0) && (dijit.byId("mes").value != 0)){
				var anio = dijit.byId("anio").attr("value");
				var mes  = dijit.byId("mes").attr("value");
				window.location.assign("/siswebrceo/public/siscp/reportes/verrptmenmach?anio="+anio+"&mes="+mes+"&tipo="+tipo);
			}else{
				alert("Los campos con (*) son obligatorios");
			}
		}else{
			alert("Los Datos Ingresados no son Validos");
		}
	}
}

/*PRESENTAR REPORTE DE LOS CENTROIDES*/
function verRptmencentro() 
{
	var tipo  = dijit.byId("tipor").attr("value");
	if(tipo == 'd'){//REPORTE DIARIO
		if(dijit.byId("fechadesde").isValid()){
			if(dojo.byId("fechadesde").value != ''){
				var fecd = dojo.byId("fechadesde").value;
				window.location.assign("/siswebrceo/public/siscp/reportes/verrptcentro?fd="+fecd+"&tipo="+tipo);
			}else{
				alert("Los campos con (*) son obligatorios");
			}
		}else{
			alert("Los Datos Ingresados no son Validos");
		}
	}else if(tipo == 's'){//REPORTE SEMANAL
		if(dijit.byId("fechadesde").isValid() && dijit.byId("fechahasta").isValid()){
			if((dojo.byId("fechadesde").value != '') && (dojo.byId("fechahasta").value != '')){
				var feci = dojo.byId("fechadesde").value;
				var fecf = dojo.byId("fechahasta").value;
				window.location.assign("/siswebrceo/public/siscp/reportes/verrptcentro?fi="+feci+"&ff="+fecf+"&tipo="+tipo);
			}else{
				alert("Los campos con (*) son obligatorios");
			}
		}else{
			alert("Los Datos Ingresados no son Validos");
		}
	}else if(tipo == 'm'){//REPORTE MENSUAL
		if((dijit.byId("anio").isValid()) && (dijit.byId("mes").isValid())){
			if((dijit.byId("anio").value != 0) && (dijit.byId("mes").value != 0)){
				var anio = dijit.byId("anio").attr("value");
				var mes  = dijit.byId("mes").attr("value");
				window.location.assign("/siswebrceo/public/siscp/reportes/verrptcentro?anio="+anio+"&mes="+mes+"&tipo="+tipo);
			}else{
				alert("Los campos con (*) son obligatorios");
			}
		}else{
			alert("Los Datos Ingresados no son Validos");
		}
	}
}