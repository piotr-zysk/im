
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>T2- Zgloszenia problemow na infolinii</TITLE>
<SCRIPT type="text/javascript" src="mobile_phone/inc/prototype.js"></SCRIPT>
<meta name="robots" content="index, follow">
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=iso-8859-2">
<meta http-equiv="Content-Language" content="pl">
<meta http-equiv="pragma" content="no-cache">
<base target="_self">
<link rel="stylesheet" type="text/css" href="css/main.css">

<script language="javascript">

function showForm(){

var y = $F('search_data');
var url = "searcher_20090310.php";
var pars = 'search_data='+y;


	var formularz = new Ajax.Request(
		url,
			{	
			  method: 'get', 
				parameters: pars,
				onComplete: function(request){ 				  
				$('formularz').style.visibility = "visible";  
				$('formularz').innerHTML = request.responseText;
				}
			}
	);

}



</script>

</head>
<BODY bgcolor=lightsalmon>

<?php
//mysql_connect("172.19.72.1","root","web");
//mysql_select_db("intranet");

include("../../../lib/config.php");


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

$pconnect = 0;


$tempcache = "";
mssql_connect($dbhost, $dbuser, $dbpw);
mssql_select_db($dbname);


if (@$oper==""){
echo '



<table width=100% height=70%>
<tr><td align=center>
<H1><font color="red">TELE2</font><br> Wyszukiwarka</H1>
</td></tr>


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
if ($faktury=='' or strlen($faktury)!=11 ) $blad=$blad.'Musisz wpisac nr faktury w prawidlowym formacie!!!<BR>';
if ($reklamacja=='' and $zamowienie=='' and $finanse=='' and $inne=='') $blad=$blad.'Musisz zaznaczyc Rodzaj zgloszenia!!!<BR>';
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

<center><H2><hr>
<form method=\"get\">
	<table><tr>
	<td><font color=red>TELE2</font> Wyszukiwarka</td>
	<td><input type=\"text\" name=\"search_data\"></td><td onclick='javascript:showForm()'>OK</td></tr>
	</table>
</form>
	
<DIV id='formularz'>
</DIV>
</H2>

<form method=\"post\" action=\"$PHP_SELF\" name=\"formularz\">

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
<tr><td>Numer faktury:</td><td><input type=\"text\" name=\"faktury\" size=\"10\" value=\"$faktury\"></td></tr>
<tr><td>Opis nieprawidlowosci:</td><td><textarea wrap=hard name=\"opis\" cols=100 rows=4>$opis</textarea></td></tr>
<TR>
<TD>
</td><td>
<TR><TD>Rodzaj zgloszenia: </TD><TD>
	<font color=blue> Zgloszenia problemow</font><BR>

	<INPUT TYPE=\"CHECKBOX\" NAME=\"reklamacja\" VALUE=\"tak\">Reklamacja telefoniczna<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"zamowienie\" VALUE=\"tak\">Zamowienie duplikatu/billingu/dokumentu<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"finanse\" VALUE=\"tak\">Finanse<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"inne\" VALUE=\"tak\">Inne<BR></TD></TR>
</TABLE>

<INPUT TYPE=\"SUBMIT\" Value=\"ZAPISZ DANE\">


</FORM>

";
}




if (@$action=="save") 
{
mssql_connect($dbhost,$dbuser,$dbpw);
mssql_select_db($dbname);


$data=strftime("%Y-%m-%d");
$czas=strftime("%H:%M:%S");

$imie=corpol($imie);
$nazwisko=corpol($nazwisko);
$firma=corpol($firma);
$opis=corpol($opis);
$odkiedy=corpol($odkiedy);

$query = mssql_query("INSERT INTO callregistry_zglosz_agent (cust_id, nr_tel, imie, nazwisko, firma, nr_docelowy, proble_z_tym_numerem, inne_pol_kl_wykonuje, faktury, reklamacja, zamowienie, finanse, inne, opis, oper, data, czas, agent) VALUES ('$cust_id', '$nr_tel', '$imie', '$nazwisko', '$firma', '$nr_docelowy', '$proble_z_tym_numerem', '$inne_pol_kl_wykonuje', '$faktury','$reklamacja', '$zamowienie', '$finanse', '$inne', '$opis', '$oper', '$data', '$czas', $xmbid)")
or die("INSERT INTO callregistry_zglosz_agent (cust_id, nr_tel, imie, nazwisko, firma, nr_docelowy, proble_z_tym_numerem, inne_pol_kl_wykonuje, faktury, reklamacja, zamowienie, finanse, inne, opis, oper, data, czas, agent) VALUES ('$cust_id', '$nr_tel', '$imie', '$nazwisko', '$firma', '$nr_docelowy', '$proble_z_tym_numerem', '$inne_pol_kl_wykonuje', '$faktury','$reklamacja', '$zamowienie', '$finanse', '$inne', '$opis', '$oper', '$data', '$czas', $xmbid)");


echo "<HR>Dane zostaly zapisane<HR><br>";
?>
<a href="?action=forma">OK</a>
  <script>
  function redirect()
  {
<?php
  echo 'window.location.replace("?oper='.$oper.'");';
?>
  }
  setTimeout("redirect();", 1000);
  </script>
<?php
}



?>
</BODY>
</HTML>