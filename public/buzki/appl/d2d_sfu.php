
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>T2</TITLE>
<meta name="robots" content="index, follow">
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=iso-8859-2">
<meta http-equiv="Content-Language" content="pl">
<meta http-equiv="pragma" content="no-cache">
<base target="_self">
<link rel="stylesheet" type="text/css" href="css/main.css">
<link rel="stylesheet" type="text/css" href="css/calendar.css">
<script language="javascript" src="choosedate.js"></script>
</head>
<BODY bgcolor=#dd9955>

<?php



function corpol($tekst)
{
$tekst=str_replace('&#261;','š',$tekst);
$tekst=str_replace('&#324;','ń',$tekst);
$tekst=str_replace('&#281;','ę',$tekst);
$tekst=str_replace('&#263;','ć',$tekst);
$tekst=str_replace('&#347;','',$tekst);
$tekst=str_replace('&#322;','ł',$tekst);
$tekst=str_replace('&#378;','',$tekst);
$tekst=str_replace('&#380;','ż',$tekst);
$tekst=str_replace('&#260;','Ľ',$tekst);
$tekst=str_replace('&#323;','Ń',$tekst);
$tekst=str_replace('&#280;','Ę',$tekst);
$tekst=str_replace('&#262;','Ć',$tekst);
$tekst=str_replace('&#346;','',$tekst);
$tekst=str_replace('&#321;','Ł',$tekst);
$tekst=str_replace('&#377;','',$tekst);
$tekst=str_replace('&#379;','Ż',$tekst);

return $tekst;
}

include("../../../lib/tww.inc");



if (@$oper==""){
echo '



<table width=100% height=70%>
<tr><td align=center>
<H1><font color="red">TELE2</font><br> Sfalszowane umowy</H1>
</td></tr>

<tr><td align=center>


<form method="get">
<b><font color=blue>OPER log.in</font></b><br><br>
<TABLE>
<tr><td>Name</td><td>
<select name="oper" onChange=window.location="?action=forma&oper="+this.options[this.selectedIndex].value;>

   <option value="">- - - - -</option>';

  $query1 = $db->query("SELECT * FROM tab_users WHERE IB_ID <> '' ORDER BY s_name");
    while($kas5 = $db->fetch_array($query1)) {
      echo "

       <option value=".$kas5['IB_ID'].">".$kas5['f_name']." ".$kas5['s_name']."</option>";
    }

 echo '
</select>
</td></tr>
</TABLE>
</form>
</td></tr></table>


';
}


/// Checkpoint

if ($stage==1)
{
if ($zrodlo=='') $blad=$blad.'Musisz wybrac zrodlo!!!<BR>';
}

if (!$blad) $stage=$stage+1;




if (($stage==2) and (!$inf)) $action="save";



/// Stage1

if (($oper) and ($stage==1))
{

echo "
<Table width=100%>
<TR>
<TD>
</td><td>
</TD>
<TD align=right>
<font color=\"gray\">agent: $oper / $stage</font>
</TD>
</TR>
</Table>
<form method=\"post\" action=\"$PHP_SELF\" name=\"frmD2D\">

<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"forma\"></input>
<INPUT TYPE=\"hidden\" NAME=\"oper\" VALUE=\"$oper\"></input>
<INPUT TYPE=\"hidden\" NAME=\"stage\" VALUE=\"$stage\"></input>

<center><H2><hr><font color=red>TELE2</font> Sfalszowane umowy<hr></H2>
";

if ($blad) echo "<B><font color=green>$blad</font></B><HR>";

echo "
</center>


<TABLE>
<TR><TD>Zrodlo: </TD><TD>
	<INPUT TYPE=\"radio\" NAME=\"zrodlo\" VALUE=\"infolinia\">infolinia<BR>
	<INPUT TYPE=\"radio\" NAME=\"zrodlo\" VALUE=\"telemarketing\">telemarketing<BR>
</TD></TR>
<tr><td>Numer w Singl.eView:</td><td><input type=\"text\" name=\"nr_bc\" size=\"20\" value=\"$nr_bc\"></td></tr>
<tr><td>Nr telefonu klienta:</td><td><input type=\"text\" name=\"nr_tel\" size=\"20\" value=\"$nr_tel\"></td></tr>
<tr><td>Firma D2D:</td><td><input type=\"text\" name=\"firma_d2d\" size=\"50\" value=\"$firma_d2d\"></td></tr>
<tr><td>Imie klienta:</td><td><input type=\"text\" name=\"klt_imie\" size=\"50\" value=\"$klt_imie\"></td></tr>
<tr><td>Nazwisko klienta:</td><td><input type=\"text\" name=\"klt_nazwisko\" size=\"50\" value=\"$klt_nazwisko\"></td></tr>
<tr><td>Adres klienta:</td><td><input type=\"text\" name=\"klt_adres\" size=\"50\" value=\"$klt_adres\"></td></tr>
<tr><td>Kod pocztowy:</td><td><input type=\"text\" name=\"klt_kod_poczt\" size=\"10\" value=\"$klt_kod_poczt\"></td></tr>
<tr><td>Miejscowosc:</td><td><input type=\"text\" name=\"klt_miejscowosc\" size=\"40\" value=\"$klt_miejscowosc\"></td></tr>
<tr><td>Opis nieprawidlowosci:</td><td><textarea wrap=hard name=\"opis\" cols=70 rows=2></textarea></td></tr>
<tr><td>Data zdarzenia:</td><td><input type=\"text\" name=\"data_z\" size=\"10\" value=\"$data_z\">
&nbsp;
		<script language=javascript>
			var basicCal2 = new calendar(\"FIELD:document.frmD2D.data_z;FORMAT:2;DELIMITER:-;\");
			basicCal2.writeCalendar();
		</script>
</td><tr>
</TABLE>

<INPUT TYPE=\"SUBMIT\" Value=\"ZAPISZ DANE\">


</FORM>

";
}




if (@$action=="save") 
{
include("../../lib/dbconnect.php");

$firma_d2d=corpol($firma_d2d);
$klt_imie=corpol($klt_imie);
$klt_nazwisko=corpol($klt_nazwisko);
$klt_adres=corpol($klt_adres);
$klt_miejscowosc=corpol($klt_miejscowosc);
$opis=corpol($opis);
$data_z=corpol($data_z);

$data=strftime("%Y-%m-%d");
$czas=strftime("%H:%M:%S");

$query = $db->query("INSERT INTO callregistry_d2d (nr_bc, nr_tel, firma_d2d, klt_imie, klt_nazwisko, klt_adres, klt_kod_poczt, klt_miejscowosc, opis, data_z, oper, data, czas, rodzaj, zrodlo) VALUES ('$nr_bc', '$nr_tel', '$firma_d2d', '$klt_imie', '$klt_nazwisko', '$klt_adres', '$klt_kod_poczt', '$klt_miejscowosc', '$opis', '$data_z', '$oper', '$data', '$czas', 'sfalszowana umowa', '$zrodlo')")
or die("SQL Error");


echo "<HR>Dane zostaly zapisane<HR><br>";
?>
<a href="?action=forma">OK</a>
  <script>
  function redirect()
  {
  window.location.replace("?oper=<?php
  echo $oper;
  ?>");
  }
  setTimeout("redirect();", 1000);
  </script>
<?php
}



?>
</BODY>
</HTML>