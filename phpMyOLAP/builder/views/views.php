<?php

function restore($cubename_sel,$levels,$img_del)
{
  print "<input type=hidden name='cube' value='$cubename_sel'>";
  print "<script>buildTree(\"$cubename_sel\",false)</script>";
  $nl=count($levels);
  $nj=0;
  for($i=0;$i<$nl;$i++) 
  {
    list($dim1,$hier1,$lev1,$prop1)=explode(".",$levels[$i]);
    $valore="$dim1.$hier1.$lev1.$prop1";
    print "<script>addCol(\"$img_del\",\"$dim1\",\"$hier1\",\"$lev1\",\"$prop1\")</script>";
  }

}

function printProp($dimensionname,$lastD,$hiername,$lastH,$levelname,$propname,$lastL,$img_link,$img_lastlink,$img_prop,$img_del)
{
  $c=strcmp($dimensionname,$lastD);
  if($c!=0) print "<img src='$img_link' style='position:absolute;left:68px'>";
  
  $c=strcmp($hiername,$lastH);
  if($c!=0) print "<img src='$img_link' style='position:absolute;left:118px'>";
  
  $c=strcmp($levelname,$lastL);
  if($c!=0) print "<img src='$img_link' style='position:absolute;left:168px'>";
  
  print "<img src='$img_lastlink'> <img src='$img_prop' width='13px' height='13px'>";
  print "<a onclick='addCol(\"$img_del\",\"$dimensionname\",\"$hiername\",\"$levelname\",\"$propname\")'>$propname</a>";
  print "<br>";    

}


function printLevel($cubename_sel,$dimensionname,$hiername,$levelname,$lastH,$lastD,$img_link,$img_lastlink,$img_plus,$img_lev)
{
  $c=strcmp($dimensionname,$lastD);
  if($c!=0) print "<img src='$img_link' style='position:absolute;left:68px'>";
  $c=strcmp($hiername,$lastH);
  if($c!=0) print "<img src='$img_link' style='position:absolute;left:118px'>";
  print "<img src='$img_lastlink'><a  onclick='discoverProp(\"$dimensionname\",\"$hiername\",\"$levelname\",\"$cubename_sel\")'>";
  print "<img id='$dimensionname-$hiername-$levelname-img_plus' src='$img_plus' width=13px height=13px></a>";
  print "<img src='$img_lev' width='13px' height='13px'> $levelname";
  
  print "<input type=hidden id='hidden_" . $dimensionname . "_".$hiername."_"."$levelname' value=closed>";
  
  print "<div id='divProp_".$dimensionname."_"."$hiername"."_"."$levelname' style='margin-left:50px'></div>";
}

function printHier($cubename_sel,$dimensionname,$hiername,$lastD,$img_link,$img_lastlink,$img_plus,$img_hier)
{
  $c=strcmp($dimensionname,$lastD);
  if($c!=0) print "<img src='$img_link' style='position:absolute;left:68px'>";
  print "<img src='$img_lastlink'><a  onclick='discoverLev(\"$dimensionname\",\"$hiername\",\"$cubename_sel\")'>";
  print "<img id='$dimensionname-$hiername-img_plus' src='$img_plus' width=13px height=13px></a>";
  print "<img src='$img_hier' width='13px' height='13px'> $hiername";

  print "<input type=hidden id='hidden_" . $dimensionname . "_"."$hiername' value=closed>";
  
  print "<div id='divLev_".$dimensionname."_"."$hiername' style='margin-left:50px'></div>";
}

function printDimension($cubename,$dimensionname,$img_lastlink,$img_plus,$img_dim)
{
  print "<img src='$img_lastlink'><a  onclick='discoverHier(\"$dimensionname\",\"$cubename\")'>";
  print "<img id='$dimensionname-img_plus' src='$img_plus' width=13px height=13px>";
  print "</a><img src='$img_dim' width='13px' height='13px'> $dimensionname";
  
  print "<input type=hidden id='hidden_" . $dimensionname . "' value=closed>";
    
  print "<div id='divHier_$dimensionname' style='margin-left:50px'></div>";
}


function printAggFunct($aggregate,$img_lastlink,$img_mea,$img_del,$img_link)
{
  print "<img src='$img_link' style='position:absolute;left:68px'>";
  print "<img src='$img_lastlink'>";
  print "<a  onclick='addCol(\"$img_del\",\"cube\",\"cube\",\"aggregate\",\"$aggregate\")'>";
  print "<img src='$img_mea' width='13px' height='13px'> $aggregate</a>";
  print "<br>";
}


function printMeasure($cubename,$measurename,$img_plus,$img_lastlink,$img_mea,$img_del)
{
  print "<img src='$img_lastlink'><a  onclick='meaFunctions(\"$cubename\",\"$measurename\")'>";
  print "<img id='$cubename-$measurename-img_plus' src='$img_plus' width=13px height=13px></a>";
  print "<img src='$img_mea' width='13px' height='13px'> <a  onclick='addCol(\"$img_del\",\"cube\",\"cube\",\"$cubename\",\"$measurename\")'>$measurename</a><br>";
  print "<input type=hidden id='hidden_" . $cubename . "_" . "$measurename' value=closed>";
  print "<div id='divFunctions_" . $cubename . "_" . "$measurename' style='margin-left:50px; width=1800px'></div>";
}


function printTree($cubename,$img_cube,$img_plus)
{
  print "<a  onclick='discoverMeasures(\"$cubename\")'>";
  print "<img id='$cubename-img_plus' src='$img_plus' width=13px height=13px></a><img src='$img_cube' width='13px' height='13px'> $cubename";
  print "<input type=hidden id='hidden_" . $cubename . "' value=closed>";
  print "<div id='divMeasure_"."$cubename' style='margin-left:50px;visibility:visible'></div>";
  print "<div id='divDim_"."$cubename' style='margin-left:50px;visibility:visible'></div>";
  print "<input type=hidden name='cube' id=check_cube value='$cubename'>";
}    


function printCube($cubename,$img_cube)
{
  print "<a onclick='buildTree(\"$cubename\",true)'><img src='$img_cube'> $cubename</a> ";
      
}    


  
?>
