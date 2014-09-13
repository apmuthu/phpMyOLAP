<?php

function create_log($query)
{
$oggi=getdate();
$info=$oggi['mday'] . "/" . $oggi['month'] . "/" . $oggi['year'] . " -- " . $oggi['hours'] . ":" .$oggi['minutes'];
$filehandle=fopen("log.txt",'a');
fwrite($filehandle,"$info $query\n");
fclose($filehandle);

}


function SQLgenerator2($cubename_sel,$levels_ser,$slice,$colonna,$ordinamento)
{
global $xmlfile;
$xml=simplexml_load_file($xmlfile);
$levels=explode("-",$levels_ser);

//print "XML $xmlfile, CUB $cubename_sel, LEV $levels_ser<br>";
//*******************************CUBE
$groupby=false;
foreach($xml->Cube as $cube)
{
  $cubename=$cube['name'];
  if($cubename==$cubename_sel)
  {
    $cubetable=$cube->Table;
    $cubetablename=$cubetable['name'];

    //print "CUB TABLE $cubetablename<br>"; 

$nl=count($levels);
$nj=0;
for($i=0;$i<$nl;$i++) 
{
list($dim1,$hier1,$lev1,$prop1)=explode(".",$levels[$i]);


if($dim1=="cube" and $hier1=="cube" and $lev1!="aggregate")
{
  //**************misure del cubo
  foreach($cube->Measure as $measure)
  {
  $measurename=$measure["name"];
  $measurecol=$measure["column"];
  if($measurename==$prop1)
    $target_list.="$measurecol,";
  }
  
  //misure calcolate
  foreach($cube->CalculatedMember as $calc_measure)
  {
  $calc_measurename=$calc_measure["name"];
  if($calc_measurename==$prop1)
  {
    $formula=$calc_measure->Formula;
    $expr=$formula["expression"];
    $alias=$formula["alias"];
    $target_list.="$expr as $alias,";
  }
  }   
}

if($dim1=="cube" and $hier1=="cube" and $lev1=="aggregate")
{
  
  //$a=eregi("(.+)\(",$prop1,$regs);
  $a=preg_match("/(.+)\(/",$prop1,$regs);
  $funz=$regs[1];
  
  //$a=eregi("\((.+)\)",$prop1,$regs);
  $a=preg_match("/\((.+)\)/",$prop1,$regs);
  $measurename=$regs[1];
  
  foreach($cube->Measure as $measure)
  {
  $measurename2=$measure["name"];
  $measurecol=$measure["column"];
  if($measurename2==$measurename)
    $target_list.="$funz($measurecol),";
    $groupby=true;
  }
  
  
  //misure calcolate
  foreach($cube->CalculatedMember as $calc_measure)
  {
  $calc_measurename=$calc_measure["name"];
  if($calc_measurename==$measurename)
  {
    $formula=$calc_measure->Formula;
    $expr=$formula["expression"];
    $alias=$formula["alias"];
    $target_list.="$funz($expr) as $alias,";
    $groupby=true;
  }
  }    
}


    foreach($cube->DimensionUsage as $dimension)
    {
      $dimensionname=$dimension['name'];
      //print "d $dimensionname<br>";
      if($dimensionname==$dim1) 
      {
        $fk_cube=$dimension['foreignKey'];
        foreach($xml->Dimension as $dimensioncube)
        {
        $dimensionname2=$dimensioncube['name'];
        if($dimensionname2==$dim1)
        {
        
        foreach($dimensioncube->Hierarchy as $hier)
        {      
            $hiername=$hier['name'];
            if($hiername==$hier1)
            {
            
                $pk_hier=$hier['primaryKey'];
                $pk_hiertable=$hier['primaryKeyTable'];

                if($pk_hiertable!="")                    
                {
                $join[$nj]="right join $pk_hiertable on $cubetablename.$fk_cube=$pk_hiertable.$pk_hier ";
                $nj=$nj+1;
                }
                      
                //************************ Add join
                $join[$nj]=buildJoin($hier);
                $nj=$nj+1;                
                
                //*********************************
 
                foreach($hier->Level as $level)
                {
                    $levelname=$level['name'];
                    if($levelname==$lev1)
                    {
                      $level_table=$level['table'];
                      if($level_table=="") $level_table=$pk_hiertable;
                      $level_col=$level['column'];
                      $group[$i]="$level_table.$level_col";
                      
                      foreach($level->Property as $prop)
                      {
                        $propname=$prop['name'];
                        if($propname==$prop1)
                        {
                          $level_col=$prop['column'];
                          $target_list.="$level_table.$level_col,";
                        }             
}}}}}}}}}}}}

//************************************WHERE
$n=strlen($slice);
$slice=substr($slice,0,$n-2);

$cond=explode("--",$slice);
$nc=count($cond);


for($i=0;$i<$nc;$i++)
{
list($dim_c,$hier_c,$lev_c,$prop_c,$cond1)=explode(".",$cond[$i]);

$cond1=trasforma($cond1);

// Add fk_cube
foreach($cube->DimensionUsage as $dimension_cube)
{
  $dimensionname_cube=$dimension_cube['name'];
  if($dimensionname_cube==$dim_c) 
  {
    $fk_cube=$dimension_cube['foreignKey'];
  }
}


foreach($xml->Dimension as $dimensioncube)
        {
        $dimensionname=$dimensioncube['name'];
        if($dim_c==$dimensionname)
        {
        foreach($dimensioncube->Hierarchy as $hier)
        {      
            $hiername=$hier['name'];
            if($hiername==$hier_c)
            {
                $pk_hier=$hier['primaryKey'];            
                $pk_hiertable=$hier['primaryKeyTable'];
                
                
                //**********************************************
                if($pk_hiertable!="")                    
                {
                $join[$nj]="right join $pk_hiertable on $cubetablename.$fk_cube=$pk_hiertable.$pk_hier ";
                $nj=$nj+1;
                }
                //************************ Add join
                $join[$nj]=buildJoin($hier);
                $nj=$nj+1;                
                //*********************************************
                
                
                foreach($hier->Level as $level)
                {
                    $levelname=$level['name'];
                    if($levelname==$lev_c)
                    {
                      $level_table=$level['table'];
                      $level_col=$level['column'];
                      if($level_table=="") $level_table=$pk_hiertable;
                      foreach($level->Property as $prop)
                      {
                        $propname=$prop['name'];
                        if($propname==$prop_c)
                        {
                          $level_col=$prop['column'];
                          $where[$i]="$level_table.$level_col $cond1";
}}}}}}}}}

//metti in AND
$where_final="";
for($i=0;$i<$nc;$i++)
{
$where_final = $where_final . " $where[$i] AND ";
}


//***********************elimina join ridondanti

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
 $join_final.=" $join[$i]";
}

//***********************costruisci target list
$n=strlen($target_list);
$target_list=substr($target_list,0,$n-1);
//print $target_list; 


//******************************costruisci group by
for($i=0;$i<$nl;$i++) 
{
  for($j=0;$j<$nl;$j++) 
  {
    if ($i!=$j && $group[$i]==$group[$j])
      $group[$j]="";
  }
}

for($i=0;$i<$nl;$i++) 
{
if($group[$i]!="")
 $group_final.="$group[$i],";
}

$n=strlen($group_final);
$group_final=substr($group_final,0,$n-1);


//***********************costruisci query finale
$n=strlen($where_final);
$where_final=substr($where_final,0,$n-5);
$n=strlen($where_final);


if($groupby==false or $group_final=="")
{
$query="select distinct $target_list $mea from $cubetablename $join_final";
if($n>1)
  $query="select distinct $target_list $mea from $cubetablename $join_final where $where_final";
}
else
{
if($n>1)
  $query="select distinct $target_list $mea from $cubetablename $join_final where $where_final group by $group_final";
else
  $query="select distinct $target_list $mea from $cubetablename $join_final group by $group_final";
}

//***************************ORDINAMENTO
list($tab1,$col1)=explode(".",$colonna);
$a=strrpos($join_final,$tab1);
if($tab1!="" && $a!=false && $colonna!="" && $ordinamento!="")
$query="$query order by $col1 $ordinamento";

if($tab1=="" && $colonna!="" && $ordinamento!="")
$query="$query order by $col1 $ordinamento";

//print "$query<br>";
return $query; 
}



//******************************************************************



function buildJoin($hier)
{

foreach($hier->Join as $join)
{
  $i=0;
  $left=$join['leftKey'];
  $right=$join['rightKey'];
  $alias=$join['rightAlias'];
  foreach($join->Table as $table)
  { 
    $t[$i]=$table['name'];
    $i=$i+1;        
  } 
  if($i==2)
  {
    $strJoin=" right join $t[1] on $t[0].$left=$t[1].$right";
    return $strJoin; 
  } 
  else
  {
    $strJoin=" right join $alias on $t[0].$left=$alias.$right " . buildJoin($join);
    return $strJoin; 
  }     
         
}
}


function buildHead($cubename_sel,$levels,$ncols,$result)
{

global $img_sortasc,$img_sortdesc,$img_lev,$img_hier,$img_save,$img_dim;

$level_ser=implode("-",$levels);

print "<tr>";
  for($i=0;$i<$ncols;$i++)
  {
    $colname=mysql_fetch_field($result);
    $nome=$colname->name;
    $tabella= $colname->table;
    $pk= $colname->primary_key;
    
    $v=checkLevel($nome);
    
    if($tabella=="")
    $field="$nome";
    else
    $field="$tabella.$nome";
    
    $colonna_ordinamento="$tabella.$nome";    
    print "<th>";
    print "<a href='#'><img border=0 src='$img_sortasc' width=20 height=20 onclick='ordina(\"$cubename_sel\",\"$level_ser\",\"$colonna_ordinamento\",\"asc\")'></a>";
    print "<a href='#'><img border=0 src='$img_sortdesc' width=20 height=20 onclick='ordina(\"$cubename_sel\",\"$level_ser\",\"$colonna_ordinamento\",\"desc\")'></a>";
    if($v==true)
    {
      print " <a href='#'><img src='$img_lev' width=20px height=20px onclick='drill(\"$cubename_sel\",\"$tabella\",\"$nome\")'></a>";
      print " <a href='#'><img src='$img_hier' width=20px height=20px onclick='change_hier(\"$cubename_sel\",\"$tabella\",\"$nome\")'></a>";
      print " <a href='#'><img src='$img_dim' width=20px height=20px onclick='change_dim(\"$cubename_sel\",\"$tabella\",\"$nome\")'></a>";
    }
    print "<br>$field";
    
    print "</th>";
    
  }
print "</tr>";  

}  


function printReport($cubename_sel,$levels,$result)
{
$ncols=mysql_num_fields($result);

print "<table border=1>";
buildHead($cubename_sel,$levels,$ncols,$result,$query);
buildBody($ncols,$result);
print "</table>";

}


function buildBody($ncols,$result)
{

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
}



function checkLevel($colname)
{
global $xmlfile;

$v=false;
$xml=simplexml_load_file($xmlfile);
foreach($xml->Dimension as $dimensioncube)
{
  foreach($dimensioncube->Hierarchy as $hier)
  {
         foreach($hier->Level as $level)
         {
            $level_col=$level['column'];
            if($level_col==$colname)
            {
              $v=true;
              return $v;
            }     
         }
  }        
}
return $v;
}


function trasforma($cond1)
{
$n=strlen($cond1);
$prima2=substr($cond1,0,2);
$seconda=substr($cond1,2,$n);

if(($prima2==">=" or $prima2=="<=") and is_numeric($seconda)==false)
return $cond1="$prima2'$seconda'";

if(($prima2==">=" or $prima2=="<=") and is_numeric($seconda)==true)
return $cond1="$prima2$seconda";


$prima1=substr($cond1,0,1);
$seconda=substr($cond1,1,$n);

if(($prima1=="=" or $prima1=="<" or $prima1==">") and is_numeric($seconda)==false)
return $cond1="$prima1'$seconda'";

if(($prima1=="=" or $prima1=="<" or $prima1==">") and is_numeric($seconda)==true)
return $cond1="$prima1$seconda";


}


?>