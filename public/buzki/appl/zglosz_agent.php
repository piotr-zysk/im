
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>T2- Zgloszenia problemow na infolinii</TITLE>
<meta name="robots" content="index, follow">
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=iso-8859-2">
<meta http-equiv="Content-Language" content="pl">
<meta http-equiv="pragma" content="no-cache">
<base target="_self">
<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<BODY bgcolor=lightsalmon>

<?php
//mysql_connect("172.19.72.1","root","web");
//mysql_select_db("intranet");




function corpol($tekst)
{
$tekst=str_replace('&#261;','�',$tekst);
$tekst=str_replace('&#324;','�',$tekst);
$tekst=str_replace('&#281;','�',$tekst);
$tekst=str_replace('&#263;','�',$tekst);
$tekst=str_replace('&#347;','�',$tekst);
$tekst=str_replace('&#322;','�',$tekst);
$tekst=str_replace('&#378;','�',$tekst);
$tekst=str_replace('&#380;','�',$tekst);
$tekst=str_replace('&#260;','�',$tekst);
$tekst=str_replace('&#323;','�',$tekst);
$tekst=str_replace('&#280;','�',$tekst);
$tekst=str_replace('&#262;','�',$tekst);
$tekst=str_replace('&#346;','�',$tekst);
$tekst=str_replace('&#321;','�',$tekst);
$tekst=str_replace('&#377;','�',$tekst);
$tekst=str_replace('&#379;','�',$tekst);

return $tekst;
}


$dbname = "intranet";
$dbuser = "sa";
$dbpw = "trpool2";
$dbhost = "172.19.72.2";
$pconnect = 0;


$tempcache = "";
mssql_connect($dbhost, $dbuser, $dbpw);
mssql_select_db($dbname);



if (@$oper==""){
echo '



<table width=100% height=70%>
<tr><td align=center>
<H1><font color="red">TELE2</font><br> Zgloszenia problemow z polaczeniami telefonicznymi</H1>
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
if ($cust_id=='') $blad=$blad.'Musisz wpisac Customer ID!!!<BR>';
if ($nr_tel=='') $blad=$blad.'Musisz wpisac Numer tel.!!!<BR>';
if ($imie=='') $blad=$blad.'Musisz wpisac imie!!!<BR>';
if ($nazwisko=='') $blad=$blad.'Musisz wpisac nazwisko!!!<BR>';
if ($lokalne=='' and $strefowe=='' and $miedzynarodowe=='' and $komorkowe=='' and $inne=='') $blad=$blad.'Musisz zaznaczyc Rodzaj zgloszenia!!!<BR>';
if ($opis=='') $blad=$blad.'Musisz wpisac opis!!!<BR>';
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
<form method=\"post\" action=\"$PHP_SELF\">

<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"forma\"></input>
<INPUT TYPE=\"hidden\" NAME=\"oper\" VALUE=\"$oper\"></input>
<INPUT TYPE=\"hidden\" NAME=\"stage\" VALUE=\"$stage\"></input>

<center><H2><hr><font color=red>TELE2</font> Zgloszenia problemow na infolinii<hr></H2>
";

if ($blad) echo "<B><font color=red>$blad</font></B><HR>";

echo "
</center>


<TABLE>
<tr><td>Customer Number (SV):</td><td><input type=\"text\" name=\"cust_id\" size=\"9\" value=\"$cust_id\"></td></tr>
<tr><td>Nr telefonu (bez 0):</td><td><input type=\"text\" name=\"nr_tel\" size=\"10\" value=\"$nr_tel\"></td></tr>
<tr><td>Imie:</td><td><input type=\"text\" name=\"imie\" size=\"25\" value=\"$imie\"></td></tr>
<tr><td>Nazwisko:</td><td><input type=\"text\" name=\"nazwisko\"50 size=\"50\" value=\"$nazwisko\"></td></tr>
<tr><td>Firma:</td><td><input type=\"text\" name=\"firma\" size=\"100\" value=\"$firma\"></td></tr>
<tr><td>Numer docelowy tel. (tylko przy probl. z polaczeniem):</td><td><input type=\"text\" name=\"nr_docelowy\" size=\"35\" value=\"$nr_docelowy\"></td></tr>
<tr><td></td><td><INPUT TYPE=\"CHECKBOX\" NAME=\"proble_z_tym_numerem\" VALUE=\"tak\">Czy problem jest tylko z tym numerem? (zaznaczone=tak)<BR></td></tr>
<tr><td></td><td><INPUT TYPE=\"CHECKBOX\" NAME=\"inne_pol_kl_wykonuje\" VALUE=\"tak\">Czy inne polaczenia klient wykonuje? (zaznaczone=tak)<BR></td></tr>
<tr><td>Od kiedy jest problem? (dd-mm-rrrr):</td><td><input type=\"text\" name=\"odkiedy\" size=\"10\" value=\"$odkiedy\"></td></tr>
<tr><td>Opis nieprawidlowosci:</td><td><textarea wrap=hard name=\"opis\" cols=100 rows=4></textarea></td></tr>
<TR>
<TD>
</td><td>
<TR><TD>Rodzaj zgloszenia: </TD><TD>
	<font color=blue> Zgloszenia problemow</font><BR>

	<INPUT TYPE=\"CHECKBOX\" NAME=\"lokalne\" VALUE=\"tak\">problemy - polaczenia lokalne<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"strefowe\" VALUE=\"tak\">problemy - polaczenia miedzystrefowe<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"miedzynarodowe\" VALUE=\"tak\">problemy - polaczenia miedzynarodowe<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"komorkowe\" VALUE=\"tak\">problemy - polaczenia komorkowe<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"inne\" VALUE=\"tak\">problemy - inne<BR></TD></TR>
</TABLE>

<INPUT TYPE=\"SUBMIT\" Value=\"ZAPISZ DANE\">


</FORM>

";
}




if (@$action=="save") 
{
mssql_connect("trpool2","sa","trpool2");
mssql_select_db("intranet");


$data=strftime("%Y-%m-%d");
$czas=strftime("%H:%M:%S");

$imie=corpol($imie);
$nazwisko=corpol($nazwisko);
$firma=corpol($firma);
$opis=corpol($opis);
$odkiedy=corpol($odkiedy);

$query = mssql_query("INSERT INTO callregistry_zglosz_agent (cust_id, nr_tel, imie, nazwisko, firma, nr_docelowy, proble_z_tym_numerem, inne_pol_kl_wykonuje, odkiedy, lokalne, strefowe, miedzynarodowe, komorkowe, inne, opis, oper, data, czas) VALUES ('$cust_id', '$nr_tel', '$imie', '$nazwisko', '$firma', '$nr_docelowy', '$proble_z_tym_numerem', '$inne_pol_kl_wykonuje', '$odkiedy','$lokalne', '$strefowe', '$miedzynarodowe', '$komorkowe', '$inne', '$opis', '$oper', '$data', '$czas')")
or die("INSERT INTO callregistry_zglosz_agent (cust_id, nr_tel, imie, nazwisko, firma, nr_docelowy, proble_z_tym_numerem, inne_pol_kl_wykonuje, odkiedy, lokalne, strefowe, miedzynarodowe, komorkowe, inne, opis, oper, data, czas) VALUES ('$cust_id', '$nr_tel', '$imie', '$nazwisko', '$firma', '$nr_docelowy', '$proble_z_tym_numerem', '$inne_pol_kl_wykonuje', '$odkiedy','$lokalne', '$strefowe', '$miedzynarodowe', '$komorkowe', '$inne', '$opis', '$oper', '$data', '$czas')");


echo "<HR>Dane zostaly zapisane<HR><br>";
?>
<a href="?action=forma">OK</a>
  <script>
  function redirect()
  {
  window.location.replace("?oper=<?php=@$oper?>");
  }
  setTimeout("redirect();", 1000);
  </script>
<?php
}



?>
</BODY>
</HTML>