//----------DHTML Menu Created using AllWebMenus PRO ver 5.3-#850---------------
//C:\Users\alejo\Desktop\Proyecto - Control de Produccion\Menuinf.awm
var awmMenuName='menu';
var awmLibraryBuild=850;
var awmLibraryPath='/awmdata';
var awmImagesPath='/awmdata/menu';
var awmSupported=(navigator.appName + navigator.appVersion.substring(0,1)=="Netscape5" || document.all || document.layers || navigator.userAgent.indexOf('Opera')>-1 || navigator.userAgent.indexOf('Konqueror')>-1)?1:0;
if (awmAltUrl!='' && !awmSupported) window.location.replace(awmAltUrl);
if (awmSupported){
var nua=navigator.userAgent,scriptNo=(nua.indexOf('Chrome')>-1)?2:((nua.indexOf('Safari')>-1)?7:(nua.indexOf('Gecko')>-1)?2:((nua.indexOf('Opera')>-1)?4:1));
var mpi=document.location,xt="";
var mpa=mpi.protocol+"//"+mpi.host;
var mpi=mpi.protocol+"//"+mpi.host+mpi.pathname;
if(scriptNo==1){oBC=document.all.tags("BASE");if(oBC && oBC.length) if(oBC[0].href) mpi=oBC[0].href;}
while (mpi.search(/\\/)>-1) mpi=mpi.replace("\\","/");
mpi=mpi.substring(0,mpi.lastIndexOf("/")+1);
var e=document.getElementsByTagName("SCRIPT");
for (var i=0;i<e.length;i++){if (e[i].src){if (e[i].src.indexOf(awmMenuName+".js")!=-1){xt=e[i].src.split("/");if (xt[xt.length-1]==awmMenuName+".js"){xt=e[i].src.substring(0,e[i].src.length-awmMenuName.length-3);if (e[i].src.indexOf("://")!=-1){mpi=xt;}else{if(xt.substring(0,1)=="/")mpi=mpa+xt; else mpi+=xt;}}}}}
while (mpi.search(/\/\.\//)>-1) {mpi=mpi.replace("/./","/");}
var awmMenuPath=mpi.substring(0,mpi.length-1);
while (awmMenuPath.search("'")>-1) {awmMenuPath=awmMenuPath.replace("'","%27");}
document.write("<SCRIPT SRC='"+awmMenuPath+awmLibraryPath+"/awmlib"+scriptNo+".js'><\/SCRIPT>");
var n=null;
awmzindex=1000;
}

var awmImageName='';
var awmPosID='';
var awmSubmenusFrame='';
var awmSubmenusFrameOffset;
var awmOptimize=0;
var awmHash='QXVMTGGTYEYMVKSIQGNEGI';
var awmNoMenuPrint=1;
var awmUseTrs=0;
var awmSepr=["0","","",""];
var awmMarg=[0,0,0,0];
function awmBuildMenu(){
if (awmSupported){
awmImagesColl=["v5_bullets_26a.gif",11,10,"v5_bullets_26b.gif",11,10,"SlidingAqua-main-button-tile.gif",12,41,"SlidingAqua-main-buttonOver-tile.gif",12,41];
awmCreateCSS(0,1,0,n,n,n,n,n,'none solid solid solid','0px 1px 1px 1','#000000 #2883A4 #2883A4 #2883A4',0,0);
awmCreateCSS(1,2,0,'#FFFFFF','#D6EDF5',2,'bold 11px Tahoma',n,'none','0','#000000','13px 10px 13px 10',1);
awmCreateCSS(0,2,0,'#004064','#D6EDF5',3,'bold 11px Tahoma',n,'none','0','#000000','13px 10px 13px 10',1);
awmCreateCSS(1,2,0,'#FFFFFF','#D6EDF5',2,'bold 11px Tahoma',n,'none','0','#000000','13px 10px 13px 10',0);
awmCreateCSS(0,2,0,'#004064','#D6EDF5',3,'bold 11px Tahoma',n,'none','0','#000000','13px 10px 13px 10',0);
awmCreateCSS(0,1,0,n,n,n,n,n,'solid','0','#000066',0,0);
awmCreateCSS(1,2,0,'#004064','#D6F0FC',n,'11px Tahoma',n,'solid','1','#72CCEE','6px 10px 6px 10',0);
awmCreateCSS(0,2,0,'#004064','#D6F0FC',n,'bold 11px Tahoma',n,'solid','1','#72CCEE','6px 10px 6px 10',0);
awmCreateCSS(1,2,0,'#004064','#D6F0FC',n,'11px Tahoma',n,'solid','1','#72CCEE','6px 10px 6px 10',1);
awmCreateCSS(0,2,0,'#004064','#D6F0FC',n,'bold 11px Tahoma',n,'solid','1','#72CCEE','6px 10px 6px 10',1);
var s0=awmCreateMenu(0,0,0,0,1,0,0,0,0,10,10,0,0,0,0,1,0,n,n,100,0,0,10,10,200,-1,1,200,200,0,0,0,"0,0,0",n,n,n,n,n,n,n,n,0,0,0,0,1,0,0,0,1);
it=s0.addItemWithImages(1,2,2,"Inicio",n,n,"",n,n,n,3,3,3,n,n,n,"/siswebrceo/public/siscinf/index",n,n,n,"/siswebrceo/public/siscinf/index",n,0,0,2,n,n,n,n,n,n,1,1,1,0,0,n,n,n,0,0,0,0,n);
it=s0.addItemWithImages(3,4,4,"ONTOT (Donacion)",n,n,"",n,n,n,3,3,3,0,0,1,"",n,n,n,n,n,0,0,2,n,n,n,n,n,n,1,1,1,0,0,n,n,n,0,0,0,1,n);
var s1=it.addSubmenu(0,0,0,1,3,0,0,5,1,1,0,n,n,100,0,0,0,-1,1,200,200,0,0,"0,0,0",0,"1,0,1,1,1,1,15,0,1,1",1);
it=s1.addItemWithImages(6,7,7,"Formulario D001",n,n,"",n,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,0,2,n,n,n,n,n,n,0,0,0,0,0,n,n,n,0,0,0,2,n);
it=s1.addItemWithImages(6,7,7,"Formulario D002",n,n,"",n,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,0,2,n,n,n,n,n,n,0,0,0,0,0,n,n,n,0,0,0,3,n);
it=s1.addItemWithImages(6,7,7,"Consultar y reimprimir",n,n,"",n,n,n,3,3,3,n,n,n,"",n,n,n,n,n,0,0,2,n,n,n,n,n,n,0,0,0,0,0,n,n,n,0,0,0,4,n);
it=s0.addItemWithImages(3,4,4,"Validacion",n,n,"",n,n,n,3,3,3,0,0,1,"",n,n,n,n,n,0,0,2,n,n,n,n,n,n,1,1,1,0,0,n,n,n,0,0,0,11,n);
var s1=it.addSubmenu(0,0,0,1,3,0,0,5,1,1,0,n,n,100,0,3,0,-1,1,200,200,0,0,"0,0,0",0,"1,0,1,1,1,1,15,0,1,1",1);
it=s1.addItemWithImages(8,9,9,"Solicitar Copia Integra",n,n,"",n,n,n,3,3,3,n,n,n,"/siswebrceo/public/sisced/validar/ingsolicitud",n,n,n,"/siswebrceo/public/sisced/validar/ingsolicitud",n,0,0,2,n,n,n,n,n,n,0,0,0,0,0,n,n,n,0,0,0,13,n);
it=s1.addItemWithImages(8,9,9,"Consultar",n,n,"",n,n,n,3,3,3,n,n,n,"/siswebrceo/public/sisced/validar/consulsolicitud",n,n,n,"/siswebrceo/public/sisced/validar/consulsolicitud",n,0,0,2,n,n,n,n,n,n,0,0,0,0,0,n,n,n,0,0,0,14,n);
it=s0.addItemWithImages(3,4,4,"Resoluciones y disposiciones",n,n,"",n,n,n,3,3,3,0,0,1,"",n,n,n,n,n,0,0,2,n,n,n,n,n,n,1,1,1,0,0,n,n,n,0,0,0,9,n);
var s1=it.addSubmenu(0,0,0,1,3,0,0,5,1,1,0,n,n,100,0,1,0,-1,1,200,200,0,0,"0,0,0",0,"1,0,1,1,1,1,15,0,1,1",1);
it=s1.addItemWithImages(8,9,9,"Pago de Horas Extras",n,n,"",n,n,n,3,3,3,n,n,n,"/siswebrceo/public/sisced/resol/hextras",n,n,n,"/siswebrceo/public/sisced/resol/hextras",n,0,0,2,n,n,n,n,n,n,0,0,0,0,0,n,n,n,0,0,0,10,n);
it=s1.addItemWithImages(8,9,9,"Ayuda a familiares o amigos",n,n,"",n,n,n,3,3,3,n,n,n,"/siswebrceo/public/sisced/resol/afamiliares",n,n,n,"/siswebrceo/public/sisced/resol/afamiliares",n,0,0,2,n,n,n,n,n,n,0,0,0,0,0,n,n,n,0,0,0,6,n);
it=s1.addItemWithImages(8,9,9,"Salidas Cortas",n,n,"",n,n,n,3,3,3,n,n,n,"/siswebrceo/public/sisced/resol/scortas",n,n,n,"/siswebrceo/public/sisced/resol/scortas",n,0,0,2,n,n,n,n,n,n,0,0,0,0,0,n,n,n,0,0,0,5,n);
it=s1.addItemWithImages(8,9,9,"Procedimiento Validacion",n,n,"",n,n,n,3,3,3,n,n,n,"/siswebrceo/public/sisced/resol/proval",n,n,n,"/siswebrceo/public/sisced/resol/proval",n,0,0,2,n,n,n,n,n,n,0,0,0,0,0,n,n,n,0,0,0,8,n);
s0.pm.buildMenu();
}}
