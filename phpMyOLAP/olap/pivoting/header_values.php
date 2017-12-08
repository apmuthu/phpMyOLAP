<?php

include("../../config.php");
include("../../functions.php");
include("../utility.php");

$level_pivoting=$_GET['livello'];
$dato=$_GET['dato'];
$cubename_p=$_GET['cubename'];

//print "$level_pivoting $dato";
//print "OK";

$xml=simplexml_load_file($xmlfile);
list($dim1,$hier1,$lev1,$prop1)=explode(".",$level_pivoting);


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
                    $hiername=(string) $hier['name'];
                    $pk_hiertable=$hier['primaryKeyTable'];
                    if($hiername==$hier1)
                    {
                       //print "H FOUND $hier1<br>";
                       foreach($hier->Level as $level)
                       {
                          $levelname=(string) $level['name'];
                          $level_col=(string) $level['column'];
                          $level_table=(string) $level['table'];
                          if($level_table=="") $level_table=$pk_hiertable;
                          if($levelname==$lev1)
                          {                                                                        
                              //print "L FOUND $lev1 COL $level_col TAB $level_table<br>";
                              //$dataset=read_data($level_table,$level_col,$where);
                              foreach($level->Property as $prop)
                              {
                                $propname=(string) $prop['name'];
                                  if($propname!=$prop1)
                                  {
                                    $prop_col=(string) $prop['column'];
                                    $target_list.="$level_table.$prop_col,";
                                  } 
                              }
                              
                              
                              $lungh=strlen($target_list);
                              $target_list=substr($target_list,0,$lungh-1);
                                
                              $dataset=read_data($level_table,$level_col,$target_list,$dato);
                              
                              //$n_celle_col=count($dataset);
                              //for($j=0;$j<$n_celle_col;$j++)
                              //{
                              //  print "$dataset[$j]<br>";
                              //}
                                     
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


function read_data($level_table,$level_col,$target_list,$dato)
{
   if(is_numeric($dato))
      $where="WHERE $level_table.$level_col=$dato";
    else
      $where="WHERE $level_table.$level_col='$dato'";

if ($target_list=="")
exit;

$query="select distinct $target_list from $level_table $where";
//print "$query<br>"; 
$result=exec_query($query);

$ncols=mysql_num_fields($result);
    
$i=0;   
while ($row = mysql_fetch_array($result))
{

for($j=0;$j<$ncols;$j++)
{
  $colname=mysql_fetch_field($result);
  print "<b>$colname->name</b>:<br>$row[$j]<br>";
}
  
$i=$i+1;
}
  
return $riga;

}


?>
