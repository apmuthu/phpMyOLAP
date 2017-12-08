<?php

print "<select size=1 style='width:1px;visibility:hidden' multiple name='level_selected[]' id='level_selected'>";
$nl=count($levels);
$nj=0;
for($i=0;$i<$nl;$i++) 
{
list($dim1,$hier1,$lev1,$prop1)=explode(".",$levels[$i]);
$a="$dim1.$hier1.$lev1.$prop1";
print "<option value=\"$a\" selected>$a</option>";
}
print "</select>";

?>
