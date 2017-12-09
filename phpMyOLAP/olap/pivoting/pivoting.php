<?php

include("../../config.php");
include("../../functions.php");
include("../utility.php");

print "<script type='text/javascript' src='pivoting.js' language='javascript'></script>";

//print "OK";
$cubename_p=$_POST["cubename"];
$slice_p=$_POST["slice_pivoting"];
$measure_p=$_POST["measure_p"];

$cols_pivoting=$_POST["cols_pivoting"];
$rows_pivoting=$_POST["rows_pivoting"];

//$n_cols_piv=count($cols_pivoting);
//$n_rows_piv=count($rows_pivoting);

//print "CU $cubename_p SLICE $slice_p COLSP $cols_pivoting ROWSP $rows_pivoting<br>";

list($dim1,$hier1,$lev1,$prop1)=explode(".",$measure_p);

print "<b>Cube</b>: $cubename_p<br>";
print "<b>Measure</b>: $prop1<br>";
print "<b>Column Level</b>: $cols_pivoting<br>";
print "<b>Row Level</b>: $rows_pivoting<br>";
print "<br>";

$level_pivoting_col=$cols_pivoting;
$res_col=extract_data_level($cubename_p,$level_pivoting_col,$slice_p);

//for($i=0;$i<$n_cols_piv;$i++){}
//for($i=0;$i<$n_rows_piv;$i++){}

$level_pivoting_row=$rows_pivoting;
$res_row=extract_data_level($cubename_p,$level_pivoting_row,$slice_p);


printTablePivot($res_col,$res_row,$cubename_p,$slice_p,$measure_p,$cols_pivoting,$rows_pivoting);


function extract_data_level($cubename_p,$level_pivoting,$slice_p)
{

global $xmlfile;
$xml=simplexml_load_file($xmlfile);
list($dim1,$hier1,$lev1,$prop1)=explode(".",$level_pivoting);
//print "LP $dim1,$hier1,$lev1,$prop1<br>"; 

  foreach($xml->Cube as $cube)
  {
    //print "OK<br>";
    $cubename=(string) $cube['name'];
    //print "CU $cubename<br>";
    if($cubename==$cubename_p)
    {
      //print "CU FOUND $cubename_p<br>";
      foreach($cube->DimensionUsage as $dimension)
      {
        $dimensionname=(string) $dimension['name'];
        if($dimensionname==$dim1) 
        {
          //print "D FOUND1 $dim1<br>";
          foreach($xml->Dimension as $dimensioncube)
          {
              $dimensionname2=(string) $dimensioncube['name'];
              if($dimensionname2==$dim1)
              {
                //print "D FOUND2 $dim1<br>";
                foreach($dimensioncube->Hierarchy as $hier)
                {      
                    $hiername=$hier['name'];
                    $pk_hiertable=$hier['primaryKeyTable'];
                    if($hiername==$hier1)
                    {
                       //print "H FOUND $hier1<br>";
                       foreach($hier->Level as $level)
                       {
                          $levelname=$level['name'];
                          $level_col=$level['column'];
                          $level_table=$level['table'];
                          if($level_table=="") $level_table=$pk_hiertable;
                          if($levelname==$lev1)
                          {                                                                        
                              //print "L FOUND $lev1 COL $level_col TAB $level_table<br>";
                              
                              ///***************where
                              
                                $n=strlen($slice_p);
                                $slice_p=substr($slice_p,0,$n-2);
                                $cond=explode("--",$slice_p);
                                $nc=count($cond);

                                $where="";
                                for($i=0;$i<$nc;$i++) {
									$dim_c = strtok($cond[$i], '.');
									$hier_c = strtok('.');
									$lev_c = strtok('.');
									$prop_c = strtok('.');
									$cond1 = substr($cond[$i], strlen($dim_c)+strlen($hier_c)+strlen($lev_c)+strlen($prop_c)+4);
									// list($dim_c,$hier_c,$lev_c,$prop_c,$cond1)=explode(".",$cond[$i]);
                                    if($dim_c==$dim1 && $hier_c==$hier1 && $lev_c==$lev1) {
                                      $cond1=trasforma($cond1);
                                      $where="$level_table.$level_col $cond1";
                                    }
                                  }

                              //**********************
                              
                              $dataset=read_data($level_table,$level_col,$where);
                              return $dataset;
                          }
                       }
                    }
                }
              }
          }
        }
      }      
    }
  }

}

function read_data($level_table,$level_col,$where)
{
if($where!="")
$where="WHERE $where";
$query="select distinct $level_col from $level_table $where order by $level_col asc";
//print "$query<br>"; 
$result=exec_query($query);

$i=0;   
while ($row = mysql_fetch_array($result))
{
$riga[$i]=$row[0];
$i=$i+1;
}
  
return $riga;

}



function printTablePivot($res_col,$res_row,$cubename_p,$slice_p,$measure_p,$cols_pivoting,$rows_pivoting)
{
global $img_plus,$img_minus;

print "<table border=1>";
//**************************************COLONNE
print "<tr>";
print "<td>";
print "</td>";
      $riga_col=$res_col;
      $n_celle_col=count($riga_col);
      for($j=0;$j<$n_celle_col;$j++)
      {
        $valore=$riga_col[$j];
        $espandi="<a href='#' onclick='espandi(\"$img_minus\",\"$img_plus\",\"col_$j\",\"$cols_pivoting\",\"$valore\",\"$cubename_p\")'><img id='img_col_$j' src='$img_plus' width=13px height=13px></a>";
        print "<td align=left valign=top>$espandi<b>$valore</b>";
        print "<input type=hidden id='hidden_col_$j' value=closed>";
        print "<div id='div_col_$j'></div>";
        print "</td>";
      }
print "</tr>";      

$riga_row=$res_row;
$n_celle_row=count($riga_row);

      for($j=0;$j<$n_celle_row;$j++)
      {
        print "<tr>";
        $valore=$riga_row[$j];
        $espandi="<a href='#' onclick='espandi(\"$img_minus\",\"$img_plus\",\"row_$j\",\"$rows_pivoting\",\"$valore\",\"$cubename_p\")'><img id='img_row_$j' src='$img_plus' width=13px height=13px></a>";
        print "<td valign=middle>$espandi<b>$valore</b>";
        print "<input type=hidden id='hidden_row_$j' value=closed>";
        print "<div id='div_row_$j'></div>";
        print "</td>";
        
        for($z=0;$z<$n_celle_col;$z++)
        {
          $cell_value=read_cell_value($cubename_p,$slice_p,$measure_p,$riga_col[$z],$riga_row[$j],$cols_pivoting,$rows_pivoting);
          print "<td>$cell_value</td>";
        }
        
        print "</tr>";
      }

print "</table>";
}

function read_cell_value($cubename_p,$slice_p,$measure_p,$riga_col,$riga_row,$cols_pivoting,$rows_pivoting)
{
$level_ser="$measure_p" . "-" . "$cols_pivoting" . "-" . "$rows_pivoting";
$slice_temp="$cols_pivoting.=$riga_col" . "--". "$rows_pivoting.=$riga_row--";

if($slice_p!="")
$slice_p="$slice_p"."$slice_temp";
else
$slice_p="$slice_temp";

$query=SQLgenerator2($cubename_p,$level_ser,$slice_p,"","");
//print "LEV $level_ser<br>";
//print "SLICE $slice_p<br>";
//print "$query<br>";
$result=exec_query($query);
$row = mysql_fetch_array($result);
return $row[0];
}


?>
