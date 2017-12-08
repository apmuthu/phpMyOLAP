
function slice(levels,cubename)
{

var selectitems = document.getElementById("sd");
var items = selectitems.getElementsByTagName("option");
var n=items.length;
sd="";
for(i=0;i<n;i++)
  sd=document.getElementById("sd").options[i].value+"--"+sd;


var parametri="?slice="+sd+"&colonna="+sort_col+"&ordinamento="+sort_type+"&levels="+levels+"&cubename="+cubename;    

//alert(parametri);

var filephp="slice/slice.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateSlice;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


function stateSlice()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById('divSD').style.visibility='hidden'
document.getElementById("divReport").innerHTML=testo;
}
}



function delSD()
{
var temp=document.getElementById("sd").options.selectedIndex;
if (temp==-1) {alert("Select a value");return;}
document.getElementById("sd").remove(temp);

}

function addSD()
{
var prop=document.getElementById('prop').value;
var level=document.getElementById('level').value;
var hier=document.getElementById('hier').value;
var dimension=document.getElementById('dimension').value;

var op=document.getElementById('op').value;
var cost=document.getElementById('cost').value;

var attr1=dimension+"."+hier+"."+level+"."+prop+"."+op+cost;

var elOptNew = document.createElement('option');
var elSel = document.getElementById('sd');
try {
    elSel.add(elOptNew, null);
  }
  catch(ex) {
    elSel.add(elOptNew);
  }
elOptNew.text = attr1;
elOptNew.value = attr1;
elOptNew.id = attr1;

}





function selValore()
{

var prop=document.getElementById('prop');
document.getElementById("a").value=prop.value;
}



function discoverProp2()
{
var level=document.getElementById('level').value;
var dimension=document.getElementById('dimension').value;
var hier=document.getElementById('hier').value;
var parametri="?dimension="+dimension+"&hier="+hier+"&level="+level;
var filephp="slice/properties.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateProp2;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


function stateProp2()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divProp").innerHTML=testo;
}
}


function discoverLev2()
{
document.getElementById("divProp").innerHTML="";

var dimension=document.getElementById('dimension').value;
var hier=document.getElementById('hier').value;
var parametri="?dimension="+dimension+"&hier="+hier;
var filephp="slice/levels.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateLev2;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


function stateLev2()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divLev").innerHTML=testo;
}
}




function discoverHier3()
{

document.getElementById("divLev_drill").innerHTML="";
document.getElementById("divProp_drill").innerHTML="";
  
var dimension=document.getElementById('dimension_drill').value;
var parametri="?dimension="+dimension;
var filephp="slice/hier.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateH3;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


function stateH3()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divHier_drill").innerHTML=testo;
}
}


function discoverHier2()
{

document.getElementById("divLev").innerHTML="";
document.getElementById("divProp").innerHTML="";
  
var dimension=document.getElementById('dimension').value;
var parametri="?dimension="+dimension;
var filephp="slice/hier.php";
var url=filephp+parametri;
xmlhttp=GetXmlHttpObject();
xmlhttp.onreadystatechange=stateH2;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}


function stateH2()
{
if (xmlhttp.readyState==4)
{
testo=xmlhttp.responseText;
document.getElementById("divHier").innerHTML=testo;
}
}


