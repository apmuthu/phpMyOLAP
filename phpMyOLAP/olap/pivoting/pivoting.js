var xmlhttp;


function espandi(img_minus,img_plus,cellobj,level,dato,cubename)
{

var valore= document.getElementById("hidden_"+cellobj).value;
var rif= document.getElementById("img_"+cellobj);

//alert(valore);
//alert(level);

if(valore=="open")
{
  rif.setAttribute("src",img_plus);
  document.getElementById("hidden_"+cellobj).value="closed";
  document.getElementById("div_"+cellobj).innerHTML="";
}
else
{
  rif.setAttribute("src",img_minus);
  document.getElementById("hidden_"+cellobj).value="open";
  
  var parametri="?livello="+level+"&dato="+dato+"&cubename="+cubename;
  //alert(parametri);
  var filephp="header_values.php";
  var url=filephp+parametri;
  //alert(url);
  xmlhttp=GetXmlHttpObject();
  xmlhttp.onreadystatechange=function() 
    { 
      if (xmlhttp.readyState==4) 
        {
          testo=xmlhttp.responseText;//"test";
          //alert(testo);
          document.getElementById("div_"+cellobj).innerHTML=testo;
        }
    }
  xmlhttp.open("GET",url,true);
  xmlhttp.send(null);
  
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
