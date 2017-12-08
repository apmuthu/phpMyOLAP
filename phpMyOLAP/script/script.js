var xmlhttp;
var img_minus;
var img_plus;
var sort_col;
var sort_type;
var svuotaGlobale;
var dim;
var hie;
var lev;
var pro;
var cub;
var mea;
var stateDMbool;

function exec_pivoting()
{

found=false;
var elSel = document.getElementById('cols_pivoting');
n=elSel.options.length;
for(i=0;i<n;i++)
{
if (elSel.options[i].selected==true)
  found=true;
}
if(found==false) {alert("Select a level in the columns");return;}


found=false;
elSel = document.getElementById('rows_pivoting');
n=elSel.options.length;
for(i=0;i<n;i++)
{
if (elSel.options[i].selected==true)
  found=true;
}
if(found==false) {alert("Select a level in the rows");return;}



var selectitems = document.getElementById("sd");
var items = selectitems.getElementsByTagName("option");
var n=items.length;
sd="";
for(i=0;i<n;i++)
  sd=document.getElementById("sd").options[i].value+"--"+sd;
document.getElementById("slice_pivoting").value=sd;

//alert(sd);
document.getElementById('divPivoting').style.visibility='hidden';
invia('form_pivoting');

}

function toCols()
{

rows_pivoting=document.getElementById('rows_pivoting');
d=rows_pivoting.options.selectedIndex;
if (d==-1) {alert("Select a value");return;}


var elOptNew = document.createElement('option');
var elSel = document.getElementById('cols_pivoting');
try {
    elSel.add(elOptNew, null);
}
catch(ex) {
    elSel.add(elOptNew);
}

elOptNew.text = rows_pivoting.options[d].text;
elOptNew.value = rows_pivoting.options[d].value;
rows_pivoting.remove(d);

}



function toRows()
{
//alert(1);

cols_pivoting=document.getElementById('cols_pivoting');
d=cols_pivoting.options.selectedIndex;
if (d==-1) {alert("Select a value");return;}


var elOptNew = document.createElement('option');
var elSel = document.getElementById('rows_pivoting');
try {
    elSel.add(elOptNew, null);
}
catch(ex) {
    elSel.add(elOptNew);
}

//alert(cols_pivoting.options[d].text);
//alert(cols_pivoting.options[d].value);

elOptNew.text = cols_pivoting.options[d].text;
elOptNew.value = cols_pivoting.options[d].value;
cols_pivoting.remove(d);

}

function send_email2()
{

cubename=document.getElementById('hidden_cubename').value;
levels=document.getElementById('hidden_levels').value;
sort_col=document.getElementById('hidden_colonna').value;
sort_type=document.getElementById('hidden_ordinamento').value;
sd=document.getElementById('hidden_slice').value;
//shareurl=document.getElementById('hidden_shareurl').value;
email=document.getElementById('email').value;
oggetto=document.getElementById('oggetto').value;
testo=document.getElementById('testo').value;

var parametri="?cubename="+cubename+"&levels="+levels+"&ordinamento_col="+sort_col+"&ordinamento_type="+sort_type+"&slice="+sd+"&email="+email+"&oggetto="+oggetto+"&testo="+testo;
//var parametri="?shareurl="+shareurl+"&email="+email+"&oggetto="+oggetto+"&testo="+testo;    
    
var filephp="../olap/send_email2.php";
var url=filephp+parametri;

xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateSend2;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


function stateSend2()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById('DIVsend_email').innerHTML=testo;
}
}


function send_email(cubename,levels)
{
document.getElementById('DIVsend_email').style.visibility='visible';

var selectitems = document.getElementById("sd");
var items = selectitems.getElementsByTagName("option");
var n=items.length;
sd="";
for(i=0;i<n;i++)
  sd=document.getElementById("sd").options[i].value+"--"+sd;

var parametri="?cubename="+cubename+"&levels="+levels+"&ordinamento_col="+sort_col+"&ordinamento_type="+sort_type+"&slice="+sd;    
var filephp="../olap/send_email.php";
var url=filephp+parametri;

xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateSend;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


function stateSend()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById('DIVsend_email').innerHTML=testo;
}
}

function check_cube2()
{
var cube = document.getElementById("check_cube").value;
if (cube=="") return;
//alert(cube);

var elSel = document.getElementById('level_selected');
n=elSel.options.length;
if(n==0) return;
//alert(n);

invia("form_report");

}


function exec_change_dim(nome_form)
{

var selectitems = document.getElementById("sd");
var items = selectitems.getElementsByTagName("option");
var n=items.length;
sd="";                                             
for(i=0;i<n;i++)
  sd=document.getElementById("sd").options[i].value+"--"+sd;
//alert("sd="+sd);

document.getElementById('colonna3').value=sort_col;
document.getElementById('ordinamento3').value=sort_type;
document.getElementById('slice3').value=sd;

l1=document.getElementById('level_cd');
level_f=document.getElementById('hidden_level_found_cd').value;
//alert("hidden level found " + level_f);

var elSel = document.getElementById('level_selected3');

n=elSel.options.length;
for(i=0;i<n;i++)
{
var stringa=elSel.options[i].value;
var q=stringa.indexOf(level_f);
//alert(stringa + "------" + level_f + "-------" + q);
if(q!=-1) elSel.options[i].selected=false;
}


var elOptNew = document.createElement('option');
try {                     
    elSel.add(elOptNew, null);
  }
  catch(ex) {
    elSel.add(elOptNew);
  }

elOptNew.text = l1.value;
elOptNew.value = l1.value;
elOptNew.selected=true;

//return;

invia(nome_form);


}



function change_dim(cubename,tabella,colonna)
{
document.getElementById('divChangeDim').style.visibility='visible';
var parametri="?tabella="+tabella+"&colonna="+colonna+"&cubename="+cubename;    
var filephp="../olap/dim/dim_levels.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateCD;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateCD()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divChangeDim2").innerHTML=testo;
}
}




function exec_change_hier(nome_form)
{

var selectitems = document.getElementById("sd");
var items = selectitems.getElementsByTagName("option");
var n=items.length;
sd="";                                             
for(i=0;i<n;i++)
  sd=document.getElementById("sd").options[i].value+"--"+sd;
//alert("sd="+sd);

document.getElementById('colonna2').value=sort_col;
document.getElementById('ordinamento2').value=sort_type;
document.getElementById('slice2').value=sd;

l1=document.getElementById('level_ch');
level_f=document.getElementById('hidden_level_found_ch').value;
//alert("hidden level found " + level_f);

var elSel = document.getElementById('level_selected2');

n=elSel.options.length;
for(i=0;i<n;i++)
{
var stringa=elSel.options[i].value;
var q=stringa.indexOf(level_f);
//alert(stringa + "------" + level_f + "-------" + q);
if(q!=-1) elSel.options[i].selected=false;
}


var elOptNew = document.createElement('option');
try {                     
    elSel.add(elOptNew, null);
  }
  catch(ex) {
    elSel.add(elOptNew);
  }

elOptNew.text = l1.value;
elOptNew.value = l1.value;
elOptNew.selected=true;

//return;

invia(nome_form);


}



function change_hier(cubename,tabella,colonna)
{
document.getElementById('divChangeHier').style.visibility='visible';
var parametri="?tabella="+tabella+"&colonna="+colonna+"&cubename="+cubename;    
var filephp="../olap/hier/hier_levels.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateCH;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateCH()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divChangeHier2").innerHTML=testo;
}
}





function share_fb(cubename,levels)
{
document.getElementById('share_fb').style.visibility='visible';

var selectitems = document.getElementById("sd");
var items = selectitems.getElementsByTagName("option");
var n=items.length;
sd="";
for(i=0;i<n;i++)
  sd=document.getElementById("sd").options[i].value+"--"+sd;

var parametri="?cubename="+cubename+"&levels="+levels+"&ordinamento_col="+sort_col+"&ordinamento_type="+sort_type+"&slice="+sd;    
var filephp="../olap/share_fb.php";
var url=filephp+parametri;

xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateShare_fb;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


function stateShare_fb()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById('share_fb').innerHTML=testo;
}
}



/*
function export_csv(nome_form)
{
var selectitems = document.getElementById("sd");
var items = selectitems.getElementsByTagName("option");
var n=items.length;
sd="";
for(i=0;i<n;i++)
  sd=document.getElementById("sd").options[i].value+"--"+sd;

document.getElementById('colonna_csv').value=sort_col;
document.getElementById('ordinamento_csv').value=sort_type;
document.getElementById('slice_csv').value=sd;

invia(nome_form);
}

*/


function export_set(nome_form)
{
var selectitems = document.getElementById("sd");
var items = selectitems.getElementsByTagName("option");
var n=items.length;
sd="";
for(i=0;i<n;i++)
  sd=document.getElementById("sd").options[i].value+"--"+sd;

document.getElementById('colonna_exp').value=sort_col;
document.getElementById('ordinamento_exp').value=sort_type;
document.getElementById('slice_exp').value=sd;

invia(nome_form);
}




function save(cubename,levels)
{
var nomereport=prompt("Nome report");
if(nomereport=="") return;

var selectitems = document.getElementById("sd");
var items = selectitems.getElementsByTagName("option");
var n=items.length;
sd="";
for(i=0;i<n;i++)
  sd=document.getElementById("sd").options[i].value+"--"+sd;

var parametri="?nomereport="+nomereport+"&cubename="+cubename+"&levels="+levels+"&ordinamento_col="+sort_col+"&ordinamento_type="+sort_type+"&slice="+sd;    
var filephp="../olap/save.php";
var url=filephp+parametri;

xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateSave;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


function stateSave()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
alert(testo);
}
}


function init_report(colonna,ordinamento)
{
sort_col=colonna;
sort_type=ordinamento;
}

function init_images(php_img_minus,php_img_plus)
{
img_minus=php_img_minus;
img_plus=php_img_plus;
}

function invia(nome_form)
{
document.forms[nome_form].submit();
}



function exec_drill(nome_form)
{

var selectitems = document.getElementById("sd");
var items = selectitems.getElementsByTagName("option");
var n=items.length;
sd="";                                             
for(i=0;i<n;i++)
  sd=document.getElementById("sd").options[i].value+"--"+sd;


document.getElementById('colonna').value=sort_col;
document.getElementById('ordinamento').value=sort_type;
document.getElementById('slice').value=sd;

l1=document.getElementById('level_drill');
level_f=document.getElementById('hidden_level_found').value;

var elSel = document.getElementById('level_selected');

n=elSel.options.length;
for(i=0;i<n;i++)
{
var stringa=elSel.options[i].value;
var q=stringa.indexOf(level_f);
if(q!=-1) elSel.options[i].selected=false;
}


var elOptNew = document.createElement('option');
try {
    elSel.add(elOptNew, null);
  }
  catch(ex) {
    elSel.add(elOptNew);
  }

elOptNew.text = l1.value;
elOptNew.value = l1.value;
elOptNew.selected=true;

invia(nome_form);


}

function drill(cubename,tabella,colonna)
{
document.getElementById('divDrill').style.visibility='visible';
var parametri="?tabella="+tabella+"&colonna="+colonna+"&cubename="+cubename;    
var filephp="../olap/drill/drill_levels.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateDrill;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function stateDrill()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divDrill2").innerHTML=testo;
}
}



function buildTree(cubename,svuota)
{
var parametri="?cube="+cubename;    
var filephp="../builder/tree.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateTree;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
if(svuota==true)
svuotaGlobale=true;
else
svuotaGlobale=false;
}


function stateTree()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divTree").innerHTML=testo;

if(svuotaGlobale==true) svuotaReport();
}
}

function svuotaReport()
{
lb=document.getElementById("level_selected");
n=lb.options.length;


row = document.getElementById('rep_header');

for(i=0;i<n;i++)
{
attr=lb.options[i].value;
cell_del = document.getElementById(attr);
row.removeChild(cell_del);
}

lb.options.length=0;

}








function ordina(cubename,levels,colonna,ordinamento)
{

sort_col=colonna;
sort_type=ordinamento;

var selectitems = document.getElementById("sd");
var items = selectitems.getElementsByTagName("option");
var n=items.length;
sd="";
for(i=0;i<n;i++)
  sd=document.getElementById("sd").options[i].value+"--"+sd;

var parametri="?cubename="+cubename+"&levels="+levels+"&slice="+sd+"&colonna="+colonna+"&ordinamento="+ordinamento;
var filephp="slice/slice.php";
var url=filephp+parametri;

xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateOrdina;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


function stateOrdina()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divReport").innerHTML=testo;
}
}


function checkMeasure(measure,funct)
{
var cb = document.getElementById(measure);
cb.checked=true;
var fcb = document.getElementById("f."+measure);
fcb.value=funct;
fcb.text=funct;
}

function delCol(attr)
{
var row = document.getElementById('rep_header');
var cell_del = document.getElementById(attr);
row.removeChild(cell_del);


// Remove from selected levels
var elSel = document.getElementById('level_selected');
var items2 = elSel.getElementsByTagName("option");
var n2=items2.length;

for(i=0;i<n2;i++)
{ 
if(document.getElementById("level_selected").options[i].value==attr)
cc=i;
}
document.getElementById("level_selected").remove(cc);

for(i=0;i<n2;i++)
{document.getElementById("level_selected").options[i].selected=true; }
}

function addCol(img_del,dimension,hier,level,prop)
{


var attr=dimension+"."+hier+"."+level+"."+prop;

if (level=="aggregate")
var attr2=prop;
else
var attr2=level+"."+prop;

var tbl = document.getElementById('report');
var row = document.getElementById('rep_header');

var cell = document.createElement("th");
cell.id=attr;
cell.setAttribute("id",attr);


var rif= document.createElement("a");
rif.href="#";
rif.onclick=function() {delCol(attr);}

var immagine = document.createElement("img");
immagine.src=img_del;
immagine.border=0;
immagine.width=20;
immagine.height=20;
rif.appendChild(immagine);

cell.innerHTML=attr2;
cell.appendChild(rif);
row.appendChild(cell);


//add to selected levels
var elOptNew = document.createElement('option');
var elSel = document.getElementById('level_selected');
try {
    elSel.add(elOptNew, null);
  }
  catch(ex) {
    elSel.add(elOptNew);
  }
elOptNew.text = attr;
elOptNew.value = attr;
elOptNew.id = "sel"+attr;
var items2 = elSel.getElementsByTagName("option");
var n2=items2.length;
for(i=0;i<n2;i++)
{ document.getElementById("level_selected").options[i].selected=true; }


}

function discoverProp(dimension,hier,level,cubename)
{
var valore= document.getElementById("hidden_"+dimension+"_"+hier+"_"+level).value;
//alert(valore);
if(valore=="open")
{
document.getElementById('divProp_'+dimension+"_"+hier+"_"+level).innerHTML=""; 
document.getElementById("hidden_"+dimension+"_"+hier+"_"+level).value="closed";
rif= document.getElementById(dimension+"-"+hier+"-"+level+"-img_plus");
rif.setAttribute("src",img_plus);
return; 
}

var parametri="?dimension="+dimension+"&hier="+hier+"&level="+level+"&cubename="+cubename;
var filephp="../builder/properties.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateProp;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);

dim=dimension;
hie=hier;
lev=level;
}


function stateProp()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divProp_"+dim+"_"+hie+"_"+lev).innerHTML=testo;

var rif= document.getElementById(dim+"-"+hie+"-"+lev+"-img_plus");
rif.setAttribute("src",img_minus);
document.getElementById("hidden_"+dim+"_"+hie+"_"+lev).value="open";

}
}


function discoverLev(dimension,hier,cubename)
{
var valore= document.getElementById("hidden_"+dimension+"_"+hier).value;
//alert(valore);
if(valore=="open")
{
document.getElementById('divLev_'+dimension+"_"+hier).innerHTML=""; 
document.getElementById("hidden_"+dimension+"_"+hier).value="closed";
rif= document.getElementById(dimension+"-"+hier+"-img_plus");
rif.setAttribute("src",img_plus);
return; 
}


var parametri="?dimension="+dimension+"&hier="+hier+"&cubename="+cubename;
var filephp="../builder/levels.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateLev;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);

dim=dimension;
hie=hier;

}


function stateLev()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divLev_"+dim+"_"+hie).innerHTML=testo;

var rif= document.getElementById(dim+"-"+hie+"-img_plus");
rif.setAttribute("src",img_minus);
document.getElementById("hidden_"+dim+"_"+hie).value="open";

}
}


function discoverHier(dimension,cubename)
{
var valore= document.getElementById("hidden_"+dimension).value;
//alert(valore);
if(valore=="open")
{
document.getElementById('divHier_'+dimension).innerHTML=""; 
document.getElementById("hidden_"+dimension).value="closed";
rif= document.getElementById(dimension+"-img_plus");
rif.setAttribute("src",img_plus);
return; 
}

var parametri="?dimension="+dimension+"&cubename="+cubename;
var filephp="../builder/hier.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateH;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);

dim=dimension;
}


function stateH()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divHier_"+dim).innerHTML=testo;

var rif= document.getElementById(dim+"-img_plus");
rif.setAttribute("src",img_minus);
document.getElementById("hidden_"+dim).value="open";

}
}


function discoverMeasures(cube)
{
var valore= document.getElementById("hidden_"+cube).value;
//alert(valore);
if(valore=="open")
{
document.getElementById('divMeasure_'+cube).innerHTML=""; 
document.getElementById('divDim_'+cube).innerHTML=""; 
document.getElementById("hidden_"+cube).value="closed";
rif= document.getElementById(cube+"-img_plus");
rif.setAttribute("src",img_plus);
return; 
}

var parametri="?cube="+cube;
var filephp="../builder/measures.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateDM;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);

cub=cube;

}


function stateDM()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divMeasure_"+cub).innerHTML=testo;
discoverDim(cub);
var rif= document.getElementById(cub+"-img_plus");
rif.setAttribute("src",img_minus);
document.getElementById("hidden_"+cub).value="open";
}
}


function discoverDim(cube)
{
var parametri="?cube="+cube;
var filephp="../builder/dimensions.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateDim;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);

cub=cube;
}


function stateDim()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divDim_"+cub).innerHTML=testo;
}
}



function discoverCubes()
{
var parametri="";
var filephp="../builder/cubes.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateCubes;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}



function stateCubes()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divAllCubes").innerHTML=testo;
}
}



function meaFunctions(cube,measure)
{
var valore= document.getElementById("hidden_"+cube+"_"+measure).value;
//alert(valore);
if(valore=="open")
{
document.getElementById('divFunctions_'+cube+"_"+measure).innerHTML=""; 
document.getElementById("hidden_"+cube+"_"+measure).value="closed";
rif= document.getElementById(cube+"-"+measure+"-img_plus");
rif.setAttribute("src",img_plus);
return; 
}

var parametri="?cube="+cube+"&measure="+measure;
var filephp="../builder/functions_list.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateMea;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);

cub=cube;
mea=measure;
}


function stateMea()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divFunctions_"+cub+"_"+mea).innerHTML=testo;

var rif= document.getElementById(cub+"-"+mea+"-img_plus");
rif.setAttribute("src",img_minus);
document.getElementById("hidden_"+cub+"_"+mea).value="open";

}
}





//****************************************************************************
function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}

