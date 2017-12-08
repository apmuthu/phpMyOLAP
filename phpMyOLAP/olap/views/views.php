<?php

function printBar($cubename_sel,$levels,$img_back,$img_save,$img_home,$img_pdf,$img_csv,$img_share,$img_email,$img_weka)
{
$level_ser=implode("-",$levels);

print "<table border=0>";
  print "<tr valign=top>";
    print "<td>";
    print "<a href='../home.php' title='$message[home]'><img src='$img_home' width=35px height=35px></a>";
    print "</td>";
    print "<td>";
      print "<a style='width:120px' href='#' title='$message[save]' onclick='save(\"$cubename_sel\",\"$level_ser\")'><img src='$img_save' width=32px height=32px></a>";
    print "</td>";
    print "<td valign=top>";
      print "<form name='form_export_pdf' action='../olap/export_pdf.php' method=post target='_blank'>";
      print "<input type=hidden name='cubename' value='$cubename_sel'>";
      print "<input type=hidden name='levels' value='" . serialize($levels) . "'>";
      print "<input type=hidden name=colonna id=colonna_exp value=''>";
      print "<input type=hidden name=ordinamento id=ordinamento_exp value=''>";
      print "<input type=hidden name=slice id=slice_exp value=''>";
      print "<a style='width:120px' href='#' title='Export PDF' onclick='export_set(\"form_export_pdf\")'><img src='$img_pdf' width=33px height=33px></a>";
      print "</form>";
    print "</td>";
    print "<td>";
      print "<form name='form_export_csv' action='../olap/export_csv.php' method=post target='_blank'>";
      print "<input type=hidden name='cubename' value='$cubename_sel'>";
      print "<input type=hidden name='levels' value='" . serialize($levels) . "'>";
      print "<input type=hidden name=colonna id=colonna_csv value=''>";
      print "<input type=hidden name=ordinamento id=ordinamento_csv value=''>";
      print "<input type=hidden name=slice id=slice_csv value=''>";
      print "<a style='width:120px' href='#' title='Export CSV' onclick='export_set(\"form_export_csv\")'><img src='$img_csv' width=35px height=35px></a>";
      print "</form>";
    print "</td>";
    print "<td>";
      print "<form name='form_export_weka' action='../olap/export_weka.php' method=post target='_blank'>";
      print "<input type=hidden name='cubename' value='$cubename_sel'>";
      print "<input type=hidden name='levels' value='" . serialize($levels) . "'>";
      print "<input type=hidden name=colonna id=colonna_weka value=''>";
      print "<input type=hidden name=ordinamento id=ordinamento_weka value=''>";
      print "<input type=hidden name=slice id=slice_weka value=''>";
      print "<a style='width:120px' href='#' title='Export ARFF' onclick='export_set(\"form_export_weka\")'><img src='$img_weka' width=35px height=35px></a>";
      print "</form>";
    print "</td>";
    print "<td>";
      print "<a style='width:120px' href='#' title='Share' onclick='share_fb(\"$cubename_sel\",\"$level_ser\")'><img src='$img_share' width=32px height=32px></a>";
    print "</td>";
    print "<td>";
      print "<a style='width:120px' href='#' title='EMail' onclick='send_email(\"$cubename_sel\",\"$level_ser\")'><img src='$img_email' width=32px height=32px></a>";
    print "</td>";

  print "</tr>";
print "</table>";


print "<table align=center>";
  print "<tr>";
    print "<td>";
      print "<form name='form_report' action='../builder/report.php' method=post>";
      print "<input type=hidden name='operazione' value='back'>";
      print "<input type=hidden name='cubename' value='$cubename_sel'>";
      print "<input type=hidden name='levels' value='" . serialize($levels) . "'>";
      print "<a style='width:120px' class='button' href='#' onclick='invia(\"form_report\")'>$message[modify]</a>";
      print "</form>";
    print "</td>";
    print "<td valign=top>";
      print "<a style='width:120px' class='button' href='#' onclick=\"document.getElementById('divSD').style.visibility='visible';\">$message[slice]</a>";
    print "</td>";
    print "<td valign=top>";
      print "<a style='width:120px' class='button' href='#' onclick=\"document.getElementById('divDrillAcross').style.visibility='visible';\">$message[drill]</a>";
    print "</td>";
    print "<td valign=top>";
      print "<a style='width:120px' class='button' href='#' onclick=\"document.getElementById('divPivoting').style.visibility='visible';\">Pivoting</a>";
    print "</td>";

  print "</tr>";
print "</table>";


print "<p>";

}

  
?>
