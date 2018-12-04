
<HTML><HEAD><TITLE>T2- Zgloszenia problemow na infolinii</TITLE>
<meta name="robots" content="index, follow">
<META HTTP-EQUIV="content-type" CONTENT="text/html; charset=iso-8859-2">
<meta http-equiv="Content-Language" content="pl">
<meta http-equiv="pragma" content="no-cache">
<base target="_self">
<link rel="stylesheet" type="text/css" href="css/main.css">

<SCRIPT type="text/javascript">

function loadFormRezCPS(){
	if (( document.formInsert.z6.checked == true ) || ( document.formInsert.z7.checked == true )){
    	document.getElementById('rez_cps_option').style.display = 'block';
	}
	else{
		document.getElementById('rez_cps_option').style.display = 'none';
	}
}

</SCRIPT>

</head>
<BODY bgcolor=salmon>

<?php
include "../../lib/tww.inc";
check_level(10,$xmblevel);

$oper=$xmbid;


/// Checkpoint

if ($stage==1)
{
if ($cust_id=='') $blad=$blad.'Musisz wpisac Customer ID!!!<BR>';
if ($nr_tel=='') $blad=$blad.'Musisz wpisac Numer tel.!!!<BR>';
if ($imie=='') $blad=$blad.'Musisz wpisac imie!!!<BR>';
if ($nazwisko=='') $blad=$blad.'Musisz wpisac nazwisko!!!<BR>';
if ($z1=='' and $z2=='' and $z3=='' and $z4=='' and $z5=='' and $z6=='' and $z7=='') $blad=$blad.'Musisz zaznaczyc Rodzaj zgloszenia!!!<BR>';
if ($opis=='') $blad=$blad.'Musisz wpisac opis!!!<BR>';
if (($z6!='') or ($z7!='')){
  if ( $data_scanu=='' ) $blad=$blad.'Musisz podac date skanu!!!<BR>';
  if ( $data_blokady=='' ) $blad=$blad.'Musisz podac date blokady!!!<BR>';
  if ( $plan_taryfowy=='' ) $blad=$blad.'Musisz podac plan taryfowy!!!<BR>';  
}
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
<font color=\"gray\">agent_id: $oper / $stage</font>
</TD>
</TR>
</Table>
<form method=\"post\" action=\"$PHP_SELF\" name='formInsert'>

<INPUT TYPE=\"hidden\" NAME=\"action\" VALUE=\"forma\"></input>
<INPUT TYPE=\"hidden\" NAME=\"oper\" VALUE=\"$oper\"></input>
<INPUT TYPE=\"hidden\" NAME=\"stage\" VALUE=\"$stage\"></input>

<center><H2><hr><font color=yellow>TELE2</font> Zgloszenia Mailcenter<hr></H2>
";

if ($blad) echo "<B><font color=white>$blad</font></B><HR>";

echo "
</center>


<TABLE>
<tr><td>Customer Number (SV):</td><td><input type=\"text\" name=\"cust_id\" size=\"9\" value=\"$cust_id\"></td></tr>
<tr><td>Barkod:</td><td><input type=\"text\" name=\"barkod\" size=\"15\" value=\"$barkod\"></td></tr>
<tr><td>Nr telefonu (bez 0):</td><td><input type=\"text\" name=\"nr_tel\" size=\"10\" value=\"$nr_tel\"></td></tr>
<tr><td>Imie:</td><td><input type=\"text\" name=\"imie\" size=\"25\" value=\"$imie\"></td></tr>
<tr><td>Nazwisko:</td><td><input type=\"text\" name=\"nazwisko\"50 size=\"50\" value=\"$nazwisko\"></td></tr>
<tr><td>Firma:</td><td><input type=\"text\" name=\"firma\" size=\"100\" value=\"$firma\"></td></tr>
<tr><td>Opis nieprawidlowosci:</td><td><textarea wrap=hard name=\"opis\" cols=100 rows=8>$opis</textarea></td></tr>
<TR>
<TD>
</td><td>
<TR><TD>Rodzaj zgloszenia: </TD><TD>
	
	<INPUT TYPE=\"CHECKBOX\" NAME=\"z1\" VALUE=\"tak\">kopia umowy<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"z2\" VALUE=\"tak\">duplikaty<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"z3\" VALUE=\"tak\">ksiegowosc<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"z4\" VALUE=\"tak\">rezygnacje<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"z5\" VALUE=\"tak\">inne<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"z6\" VALUE=\"tak\" OnClick='loadFormRezCPS()'>rezygnacja CPS<BR>
	<INPUT TYPE=\"CHECKBOX\" NAME=\"z7\" VALUE=\"tak\" OnClick='loadFormRezCPS()'>rezygnacja 10-dnionowa CPS<BR>
	</TD></TR>

<tr><td colspan=\"2\">
<DIV id='rez_cps_option' style='display:none'>
	<table>
		<tr><td>Data scanu:</td><td><input type='text' name='data_scanu'> w formacie: 2008-01-01</td></tr>
		<tr><td>Data blokady:</td><td><input type='text' name='data_blokady'> w formacie: 2008-01-01</td></tr>
		<tr><td>Plan taryfowy:</td><td>
			<select name='plan_taryfowy'>
				<option value=''> - wybierz plan - </option>
				<option value='Res_Pres_Sec_Darmowe Soboty'>Res_Pres_Sec_Darmowe Soboty</option>
				<option value='Tele2 60 min'>Tele2 60 min</option>
				<option value='Residential Preselect DWiW! 35'>Residential Preselect DWiW! 35</option>
				<option value='Res_Pres_DWiW! 35_1000minut'>Res_Pres_DWiW! 35_1000minut</option>
				<option value='Tele2_Preselect'>Tele2_Preselect</option>																
				<option value='Biz_Sek_12m_Optymalny'>Biz_Sek_12m_Optymalny</option>
				<option value='Biz_Sek_12m_Wspolna_Stawka'>Biz_Sek_12m_Wspolna_Stawka</option>
				<option value='Biz_Sek_Premium_100 min_Wspolna_Stawka'>Biz_Sek_Premium_100 min_Wspolna_Stawka</option>
				<option value='Biz_Sek_Premium_30 min_Wspolna_Stawka'>Biz_Sek_Premium_30 min_Wspolna_Stawka</option>
				<option value='Biz_Sek_Optymalny'>Biz_Sek_Optymalny</option>
				<option value='Biz_Sek_Premium_Wspolna_Stawka'>Biz_Sek_Premium_Wspolna_Stawka</option>
				<option value='Biz_Sek_Wspolna_Stawka'>Biz_Sek_Wspolna_Stawka</option>
				<option value='Tele2_Preselect'>Tele2_Preselect</option>
			</select>
		</td></tr>
		<tr><td>Lojalka:</td><td><input type='checkbox' name='lojalka'></td></tr>				
	</table>
</DIV>
</td></tr>

</TABLE>

<INPUT TYPE=\"SUBMIT\" Value=\"ZAPISZ DANE\">


</FORM>

";
}




if (@$action=="save") 
{


$data=strftime("%Y-%m-%d");
$czas=strftime("%H:%M:%S");

$imie=corpol($imie);
$nazwisko=corpol($nazwisko);
$firma=corpol($firma);
$opis=corpol($opis);

if( $lojalka=="on" ) $lojalka = "1"; else $lojalka = "0";

$query = mssql_query("INSERT INTO callregistry_zglosz_mc (cust_id, barkod, nr_tel, imie, nazwisko, firma, z1, z2, z3, z4, z5, opis, oper_id, data, czas, data_scanu, data_blokady, plan_taryfowy, z6, lojalka, z7) VALUES ('$cust_id', '$barkod', '$nr_tel', '$imie', '$nazwisko', '$firma', '$z1', '$z2', '$z3', '$z4', '$z5', '$opis', '$oper', '$data', '$czas', '$data_scanu', '$data_blokady', '$plan_taryfowy', '$z6', '$lojalka', '$z7')")
or die("INSERT INTO callregistry_zglosz_mc (cust_id, barkod, nr_tel, imie, nazwisko, firma, z1, z2, z3, z4, z5, opis, oper_id, data, czas, data_scanu, data_blokady, plan_taryfowy, z6, lojalka) VALUES ('$cust_id', '$barkod', '$nr_tel', '$imie', '$nazwisko', '$firma', '$z1', '$z2', '$z3', '$z4', '$z5', '$opis', '$oper', '$data', '$czas', '$data_scanu', '$data_blokady', '$plan_taryfowy', '$z6', '$lojalka', '$z7')");


echo "<HR>Dane zostaly zapisane<HR><br>";
?>
<a href="?action=forma">OK</a>
  <script>
  function redirect()
  {
  window.location.replace("zglosz_mc.php");
  }
  setTimeout("redirect();", 1000);
  </script>
<?php
}



?>
</BODY>
</HTML>