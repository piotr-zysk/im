<?php
include("../../lib/tww.inc");

function check_start() {
	$start=$_COOKIE["start"];
	if($start=="1") {
		$stan=1;
	} else {
		$stan=0;
	}

return $stan;
}

function mssql_insert_id() {
	$id = "";

	$rs = mssql_query("SELECT @@IDENTITY AS id");
  	if ($row = mssql_fetch_row($rs)) {
   		$id = trim($row[0]);
  	}
  	mssql_free_result($rs);
  	return $id;
} 

//pobranie winlogin
$xmbid=$_COOKIE["xmbid"];
$query = $db->query("SELECT winlogin FROM tab_users WHERE id='$xmbid'");
while ($member = $db->fetch_array($query))
	{
	$winlogin = $member['winlogin'];
	}

//sprawdzenie, czy nie zostala zamknieta przegladarka
$czy_start=$_COOKIE["start"];
if ($czy_start=="") {
	$data_aktual_od=date("Y-m-d");
	$data_aktual_od.=" 00:00:00";
	$data_aktual_do=date("Y-m-d");
	$data_aktual_do.=" 23:59:59";

	$sql="SELECT Id ";
	$sql.="FROM EfektywnoscLog ";
	$sql.="WHERE login='$winlogin' AND DataGodzOd!='' AND DataGodzDo is NULL AND Ilosc is NULL AND DataGodzOd BETWEEN '$data_aktual_od' AND '$data_aktual_do'";
	$query = $db->query($sql);
	while ($member = $db->fetch_array($query)) {
		$id_log = $member['Id'];
	}
	
	if($id_log!="") {
		setcookie("start", "1");
		setcookie("start_id", "$id_log");
		//zaladowanie strony ponownie
		echo "
		<script language='javascript'>
		window.location.replace('efektywnosc.php');
		</script>
		";
	}
}



if($submit=='START') {
	setcookie("start", "1");

	//pobranie nazwy kompa
	$host = @getHostByAddr($REMOTE_ADDR);
	$host = str_replace('.transcomeurope.com','',$host);

	//aktualna data
	$data_od=date("Y-m-d H:i:s");
	
	//wprowadzenie wiersza do tabeli	
	$sql="INSERT INTO EfektywnoscLog(login, machine, Id_operacji, DataGodzOd) VALUES('$winlogin','$host','$operacja','$data_od')";
	$query = $db->query($sql);

	//id dodanego rekordu
	$id = "";
	$rs = mssql_query("SELECT @@IDENTITY AS id");
  	if ($row = mssql_fetch_row($rs)) {
   		$id = trim($row[0]);
  	}
  	mssql_free_result($rs);

	setcookie("start_id", "$id");

	//zaladowanie strony ponownie
	echo "
	<script language='javascript'>
	window.location.replace('efektywnosc.php');
	</script>
	";
}

if($submit=='STOP') {
	$wzorzec_liczba="^([0-9]+)$";
	if(ereg($wzorzec_liczba, $ilosc)) {
		setcookie("start", "2");
	
		$id = $_COOKIE["start_id"];
		setcookie("start_id");

		//aktualna data
		$data_do=date("Y-m-d H:i:s");

		//uzupe³nianie wiersza w tabeli
		$sql="UPDATE EfektywnoscLog SET DataGodzDo='$data_do', Ilosc='$ilosc' WHERE Id=$id";
		$query = $db->query($sql);

		//zaladowanie strony ponownie
		echo "
		<script language='javascript'>
		window.location.replace('efektywnosc.php');
		</script>
		";
	} else {
		//zaladowanie strony ponownie
		echo "
		<script language='javascript'>
		alert('Musisz podac prawidlowa ILOSC!');
		window.location.replace('efektywnosc.php');
		</script>
		";
	}
}

//poczatek strony
start_html('#eeeeff','css/main.css','Efektywnosc');

echo "
<CENTER>
<TABLE><TR><TD class='body_table'>
";

if($winlogin=="") {
	echo "Aby kozystac z aplikacji, musisz byc zalogowany w intranecie!";
} else {

	echo "
	<TABLE>
	<FORM action='efektywnosc.php' method='post' name='frmEfekt'>
	<TR>
	";
	if(check_start()==0) {
		echo "
		<TD>Operacja:</TD>
		<TD>
		<SELECT name='operacja'>
		";
		$query = $db->query("SELECT Id_operacji, Operacja FROM EfektywnoscOperacje ORDER BY Operacja");
		while ($member = $db->fetch_array($query))
			{
			$id_op = $member['Id_operacji'];
			$op = $member['Operacja'];
		
			echo "<OPTION value='$id_op'>$op</OPTION>";
			}
		echo "
		</SELECT>
		</TD>
		<TD><INPUT type='submit' name='submit' value='START'></TD>
		";
	} else {
		echo "
		<TD>Podaj ilosc</TD>
		<TD><INPUT type='text' name='ilosc'>
		<input name='poszlo' type='hidden' value='1'></TD>
		<TD><INPUT type='submit' name='submit' value='STOP'></TD>
		";
	}
	echo "
	</TR>
	</FORM>
	</TABLE>
	";

}


echo "
</TD></TR>
<TR><TD>
";

//log dzisiejszy poczatek
echo "
<TABLE class='body_table'>
<TR><TD colspan='5' class='table_log'><B>TWOJE OPERACJE Z DZISIEJSZEGO DNIA</B></TD></TR>
<TR>
<TD class='table_log'>Login</TD>
<TD class='table_log'>Operacja</TD>
<TD class='table_log'>Czas rozpoczecia</TD>
<TD class='table_log'>Czas zakonczenia</TD>
<TD class='table_log'>Ilosc</TD>
</TR>
";

$id = $_COOKIE["start_id"];
$data_aktual_od=date("Y-m-d");
$data_aktual_od.=" 00:00:00";
$data_aktual_do=date("Y-m-d");
$data_aktual_do.=" 23:59:59";

$sql="SELECT log.Id, log.login, log.DataGodzOd, log.DataGodzDo, log.Ilosc, oper.Operacja ";
$sql.="FROM EfektywnoscOperacje oper, EfektywnoscLog log ";
$sql.="WHERE log.login='$winlogin' AND log.Id_operacji=oper.Id_operacji AND log.DataGodzOd BETWEEN '$data_aktual_od' AND '$data_aktual_do' ";
$sql.="ORDER BY log.Id DESC";
$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$id_log = $member['Id'];
	$login_log = $member['login'];
	$dataOd_log = $member['DataGodzOd'];
	$dataDo_log = $member['DataGodzDo'];
	$ilosc_log = $member['Ilosc'];
	$operacja_oper = $member['Operacja'];

	if($id_log==$id) {
		echo "
		<TR bgcolor='#eeeeaa'>
		<TD class='table_log'>$login_log</TD>
		<TD class='table_log'>$operacja_oper</TD>
		<TD class='table_log'>$dataOd_log</TD>
		<TD class='table_log' colspan='2'>Operacja w toku</TD>
		</TR>
		";
	} else {
		echo "
		<TR>
		<TD class='table_log'>$login_log</TD>
		<TD class='table_log'>$operacja_oper</TD>
		<TD class='table_log'>$dataOd_log</TD>
		<TD class='table_log'>$dataDo_log</TD>
		<TD class='table_log'>$ilosc_log</TD>
		</TR>
		";
	}
}
echo "</TABLE>";
//log dzisiejszy koniec

if($action=="raport") {
//raport poczatek
echo "
<TABLE class='body_table'>
<TR><TD colspan='5' class='table_log'><B>RAPORT</B></TD></TR>
<TR>
<TD class='table_log'>Login</TD>
<TD class='table_log'>Imie</TD>
<TD class='table_log'>Nazwisko</TD>
<TD class='table_log'>Operacja</TD>
<TD class='table_log'>Ile na godzine</TD>
</TR>
";

//$sql="SELECT log.Id, log.login, log.DataGodzOd, log.DataGodzDo, log.Ilosc, oper.Operacja, oper.IloscNaGodzine, u.f_name, u.s_name ";
//$sql.="FROM EfektywnoscOperacje oper, EfektywnoscLog log, tab_users u ";
//$sql.="WHERE log.login='$winlogin' AND log.Id_operacji=oper.Id_operacji AND u.winlogin=log.login ";

$sql="SELECT log.login, log.DataGodzOd, oper.Operacja, oper.IloscNaGodzine, u.f_name, u.s_name ";
$sql.="FROM EfektywnoscOperacje oper, EfektywnoscLog log, tab_users u ";
$sql.="WHERE log.Id_operacji=oper.Id_operacji AND u.winlogin=log.login ";
$sql.="GROUP BY log.login, oper.Operacja";

$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$login_log = $member['login'];
	$operacja_oper = $member['Operacja'];
	$imie = $member['f_name'];
	$nazwisko = $member['s_name'];
	$ilosc_na_godz = $member['IloscNaGodzine'];


/*	$dataOd=strtotime($dataOd);

	$dataDo=strtotime($dataDo);

	$czas = ($dataDo - $dataOd) / 60;

	$efektywnosc = round(($ilosc_log * 0.041666666668) / $czas / $ilosc_na_godz * 100, 2);
*/	

	echo "
	<TR>
	<TD class='table_log'>$login_log</TD>
	<TD class='table_log'>$imie</TD>
	<TD class='table_log'>$nazwisko</TD>
	<TD class='table_log'>$operacja_oper</TD>
	<TD class='table_log'>$ilosc_na_godz</TD>
	</TR>
	";

}
echo "</TABLE>";
//raport koniec
}

echo "
</TD></TR></TABLE>
<TABLE><TR><TD>
<p class='podpis'>by £ukasz</p>
</TD></TR></TABLE>
</CENTER>
";
end_html();
?>