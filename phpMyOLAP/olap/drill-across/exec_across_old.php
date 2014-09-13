<?php

include("../../config.php");
include("../../functions.php");
include("../utility.php");

$rep1=$_POST["rep1"];
$rep2=$_POST["rep2"];

//print "$rep1 $rep2<br>";
//print "XML $xmlfile<br>";

$xmlfile1="../../saved/$rep1";
$xml=simplexml_load_file($xmlfile1);
$cubename1=$xml->cubename;
$colonna1=$xml->order_col;
$ordinamento1=$xml->order_type;
$slice1=$xml->slice;
$levels_ser1=$xml->levels;
//$levels1=explode("-",$levels_ser);

//print "$cubename1 $levels_ser1 $colonna1<br>";

$xmlfile2="../../saved/$rep2";
$xml=simplexml_load_file($xmlfile2);
$cubename2=$xml->cubename;
$colonna2=$xml->order_col;
$ordinamento2=$xml->order_type;
$slice2=$xml->slice;
$levels_ser2=$xml->levels;
//$levels2=explode("-",$levels_ser);

//print "A $cubename1 B $cubename2<br>";
$xml=simplexml_load_file($xmlfile);
$xml2=simplexml_load_file($xmlfile);

$cubename1=(string) $cubename1;
$cubename2=(string) $cubename2;

if($cubename1==$cubename2) die("Invalid Drill across: Select two different cubes.");

//*******************************************************************common dimensions
foreach($xml->Cube as $cubeA)
{
  $cubenameA=$cubeA['name'];
  //print "CUB1 $cubenameA<br>";
  $c=strcmp($cubenameA,$cubename1);
  if($c==0)
  {
    //print "FOUND1 $cubenameA - $cubename1<br>";
    foreach($xml->Cube as $cubeB)
    {
      $cubenameB=$cubeB['name'];
      //print "CUB2 $cubenameB<br>"; 
      $d=strcmp($cubenameB,$cubename2);
      $e=strcmp($cubenameB,$cubenameA);
      if($d==0)
      {
              //print "FOUND2 $cubenameB - $cubename2<br>";
              $i=0;
              foreach($cubeA->DimensionUsage as $dimensionA)
              {
                  $dimensionnameA=$dimensionA['name'];
                  $FKA=$dimensionA['foreignKey'];
                  foreach($cubeB->DimensionUsage as $dimensionB)
                  {
                    $dimensionnameB=$dimensionB['name'];
                    $FKB=$dimensionB['foreignKey'];
                    $f=strcmp($dimensionnameB,$dimensionnameA);
                    
                    if($f==0)
                    {
                      //print "common $dimensionnameA<br>";
                      $cubetableA=$cubeA->Table;
                      $cubetablenameA=$cubetableA['name'];
                      $cubetableB=$cubeB->Table;
                      $cubetablenameB=$cubetableB['name'];
                      $join[$i]="$cubetablenameA.$FKA=$cubetablenameB.$FKB";
                      $i++;                      
                    }
                  }
              }
      }
    }  
  }
}
$nj=$i;
//print "NJ = $nj<br>";
for($i=0;$i<$nj;$i++) 
{
  for($j=0;$j<$nj;$j++) 
  {
    if ($i!=$j && $join[$i]==$join[$j])
      $join[$j]="";
  }
}
for($i=0;$i<$nj;$i++) 
{
  if($join[$i]!="") $join_final.=" $join[$i] AND ";
 //print "$join_final"; 
}
$n=strlen($join_final);
$join_final=substr($join_final,0,$n-5);
//$join_across="$join_final";
//print "$join_across<br>";
///*********************************************************************************************************************************

//print "$cubename1 $levels_ser1 $colonna1<br>";
$query1=SQLgenerator2($cubename1,$levels_ser1,$slice1,$colonna1,$ordinamento1);
//print "Q1 $query1<br>";

$query2=SQLgenerator2($cubename2,$levels_ser2,$slice2,$colonna2,$ordinamento2);
//print "Q2 $query2<br>";


//******************************************************EXTRACTION 1
$found_group=strrpos($query1,"group");
$found_where=strrpos($query1,"where");
$found_order=strrpos($query1,"order");
//print "FOUND $found_group $found_where $found_order<br>";


      //TARGET
      $a=eregi("distinct (.+) from",$query1,$regs);
      $target1=$regs[1];
      //print "TARGET $target1<br>";

      //FROM
      if($found_where==true)
      $a=eregi("from (.+) where",$query1,$regs);
      elseif($found_group==true)
      $a=eregi("from (.+) group",$query1,$regs);
      elseif($found_order==true)
      $a=eregi("from (.+) order",$query1,$regs);
      else
      $a=eregi("from (.+)$",$query1,$regs);
      $from1=$regs[1];
      //print "Q1 FROM $from1<br>";

      //WHERE
      //$where1="";
      if($found_where==true && $found_group==true)
        $a=eregi("where (.+) group",$query1,$regs);
      elseif($found_where==true && $found_order==true)
        $a=eregi("where (.+) order",$query1,$regs);
      elseif($found_where==true)
        $a=eregi("where (.+)$",$query1,$regs);
      $where1=$regs[1];
      if($found_where==false) $where1="";
      //print "WHERE1 $where1<br>";

      //GROUP
      if($found_group==true && $found_order==false)    
        $a=eregi("group by (.+)$",$query1,$regs);
      if($found_group==true && $found_order==true)    
        $a=eregi("group by (.+) order",$query1,$regs);
      $group1=$regs[1];
      if($found_group==false) $group1="";
      //print "GROUP $group1<br>";


      //ORDER
      if($found_order==true)
        $a=eregi("order by (.+)$",$query1,$regs);
      $order1=$regs[1];
      if($found_order==false) $order1="";
      //print "ORDER $order1<br>";

//******************************************************EXTRACTION 2
$found_group=strrpos($query2,"group");
$found_where=strrpos($query2,"where");
$found_order=strrpos($query2,"order");

      //TARGET
      $a=eregi("distinct (.+) from",$query2,$regs);
      $target2=$regs[1];
      //print "TARGET $target2<br>";

      //FROM
      if($found_where==true)
      $a=eregi("right join (.+) where",$query2,$regs);
      elseif($found_group==true)
      $a=eregi("right join (.+) group",$query2,$regs);
      elseif($found_order==true)
      $a=eregi("right join (.+) order",$query2,$regs);
      else
      $a=eregi("right join (.+)$",$query2,$regs);
      $from2=$regs[1];
      //print "Q2 FROM $from2<br>";

      //WHERE
      $where2="";
      if($found_where==true && $found_group==true)
        $a=eregi("where (.+) group",$query2,$regs);
      elseif($found_where==true && $found_order==true)
        $a=eregi("where (.+) order",$query2,$regs);
      elseif($found_where==true)
        $a=eregi("where (.+)$",$query2,$regs);
      $where2=$regs[1];
      if($found_where==false) $where2="";
      //print "WHERE2 $where2<br>";
      
      //GROUP
      if($found_group==true && $found_order==false)    
        $a=eregi("group by (.+)$",$query2,$regs);
      if($found_group==true && $found_order==true)    
        $a=eregi("group by (.+) order",$query2,$regs);
      $group2=$regs[1];
      if($found_group==false) $group2="";
      //print "GROUP $group2<br>";

      //ORDER
      if($found_order==true)
        $a=eregi("order by (.+)$",$query2,$regs);
      $order2=$regs[1];
      if($found_order==false) $order2="";
      //print "ORDER $order2<br>";
//*****************************************************************************QUERY FINALE DRILL ACROSS

//$levels=explode("-",$levels_ser);

//from
      $from_final="FROM $from1 JOIN $cubetablenameB ON $join_final JOIN $from2";
      //print "<p>FROM FINAL $from_final<br>"; 

//where
      if($where1!="" && $where2!="")
      $where_final="WHERE $where1 AND $where2";
      
      if($where1=="" && $where2!="")
      $where_final="WHERE $where2";
      
      if($where1!="" && $where2=="")
      $where_final="WHERE $where1";
      
      if($where1=="" && $where2=="")
      $where_final="";
      //print "<p>WHERE FINAL $where_final<br>";
      
//group
      if($group1!="" && $group2!="")
      $group_final="GROUP BY $group1,$group2";
      
      if($group1=="" && $group2!="")
      $group_final="GROUP BY $group2";
      
      if($group1!="" && $group2=="")
      $group_final="GROUP BY $group1";
      
      if($group1=="" && $group2=="")
      $group_final="";

//order
      if($order1!="" && $order2!="")
      $order_final="ORDER BY $order1,$order2";
      
      if($order1=="" && $order2!="")
      $order_final="ORDER BY $order2";
      
      if($order1!="" && $order2=="")
      $order_final="ORDER BY $order1";
      
      if($order1=="" && $order2=="")
      $order_final="";

$query="select distinct $target1,$target2 $from_final $where_final $group_final $order_final";
//print "<p>FINALE<br>$query<br>";
$result=exec_query($query);
$ncols=mysql_num_fields($result);

//****************************************************************REPORT
print "<center>";
print "<table border=1>";
print "<tr>";
  for($i=0;$i<$ncols;$i++)
  {
    $colname=mysql_fetch_field($result);
    $nome=$colname->name;
    $tabella= $colname->table;
    
    if($tabella=="")
    $field="$nome";
    else
    $field="$tabella.$nome";
    
    print "<th>";
    print "$field";
    print "</th>";
    
  }
print "</tr>";

while ($row = mysql_fetch_array($result))
{
print "<tr>";
  for($i=0;$i<$ncols;$i++)
  {
    $colvalue=$row[$i];
    print "<td>$colvalue</td>";
  }
print "</tr>";  
}
  

print "</table>";
print "</center>";

  
?>
