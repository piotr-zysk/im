<?php
if($submitEdit!="") {
//pobranie starych wartosci

$sql="SELECT * FROM DDpakiety WHERE id='$idPakiet'";

$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idPakietOld=$member['id'];
	$rachKlientOld=$member['rachKlient'];
	$dataWpisuOld=$member['dataWpisu'];
	$operIDOld=$member['operID'];
	$sourceOld=$member['source'];
	$statusTWWOld=$member['statusTWW'];
	$statusSVOld=$member['statusSV'];
	$statusBankOld=$member['statusBank'];
	$sprTWWOld=$member['sprTWW'];
	$czyFormOld=$member['czyForm'];
	
	if($czyFormOld==1) { 
		$czyFormOld="on";
	} else {
		$czyFormOld="off";
	}
}

if($statusTWW==3){
  $dataHistoria=$dataWysylki . " 09:00";
} else {
  $dataHistoria=date("Y-m-d H:i");
}

//konwersja znaków PL
$nazwaKlient=corpol($nazwaKlient);
$ulicaKlient=corpol($ulicaKlient);
$miastoKlient=corpol($miastoKlient);

//pobranie operID
$operID=$xmbid;

//konwersja $czyForm
if($czyForm=="on") {
	$czyForm=1;
} else {
	$czyForm=0;
}

//zapisanie danych z form do tabeli DDpakiety
$db->query("UPDATE DDpakiety SET idKlient='$idKlient', nazwaKlient='$nazwaKlient', ulicaKlient='$ulicaKlient', miastoKlient='$miastoKlient', kodKlient='$kodKlient', rachKlient='$rachKlient', source='$source', statusTWW='$statusTWW', statusSV='$statusSV', statusBank='$statusBank', sprTWW='$sprTWW', czyForm='$czyForm' WHERE id='$idPakiet'");

if($statusTWW>0) $db->query("UPDATE DDpakiety SET wysylkaPisma='1' WHERE id='$idPakiet'");
//echo "SQL1: UPDATE DDpakiety SET idKlient='$idKlient', nazwaKlient='$nazwaKlient', ulicaKlient='$ulicaKlient', miastoKlient='$miastoKlient', kodKlient='$kodKlient', rachKlient='$rachKlient', source='$source', statusTWW='$statusTWW', statusSV='$statusSV', statusBank='$statusBank', sprTWW='$sprTWW', czyForm='$czyForm' WHERE id='$idPakiet'<BR><BR>";

//zapisywanie do historii zmian
$sqlHistory="INSERT INTO DDhistoria(dataHistoria,idPakietu";
	//sprawdzanie, czy sie zmienily wartosci
	$sqlHistory.=",idKlient";
	$sqlHistory.=",nazwaKlient";
	$sqlHistory.=",ulicaKlient";
	$sqlHistory.=",miastoKlient";
	$sqlHistory.=",kodKlient";
	$sqlHistory.=",operID";
	$sqlHistory.=",rachKlient";
	if($sourceOld!=$source) $sqlHistory.=",source";
	if($statusTWWOld!=$statusTWW) $sqlHistory.=",statusTWW";
	if($statusSVOld!=$statusSV) $sqlHistory.=",statusSV";
	if($statusBankOld!=$statusBank) $sqlHistory.=",statusBank";
	if($sprTWWOld!=$sprTWW) $sqlHistory.=",sprTWW";
	if($czyFormOld!=$czyForm) $sqlHistory.=",czyForm";

$sqlHistory.=") VALUES ('$dataHistoria','$idPakiet'";
	//sprawdzanie, czy sie zmienilu wartosci
	$sqlHistory.=",'$idKlient'";
	$sqlHistory.=",'$nazwaKlient'";
	$sqlHistory.=",'$ulicaKlient'";
	$sqlHistory.=",'$miastoKlient'";
	$sqlHistory.=",'$kodKlient'";
	$sqlHistory.=",'$operID'";
	$sqlHistory.=",'$rachKlient'";
	if($sourceOld!=$source) $sqlHistory.=",'$source'";
	if($statusTWWOld!=$statusTWW) $sqlHistory.=",'$statusTWW'";
	if($statusSVOld!=$statusSV) $sqlHistory.=",'$statusSV'";
	if($statusBankOld!=$statusBank) $sqlHistory.=",'$statusBank'";
	if($sprTWWOld!=$sprTWW) $sqlHistory.=",'$sprTWW'";
	if($czyFormOld!=$czyForm) $sqlHistory.=",'$czyForm'";
$sqlHistory.=")";

$db->query($sqlHistory);
//echo "SQL2: $sqlHistory<BR>";
}


//pobranie aktualnych danych do edycji
$sql="SELECT * FROM DDpakiety WHERE id='$idPakiet'";

$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idPakiet=$member['id'];
	$idKlient=$member['idKlient'];
	$nazwaKlient=corpol_rev($member['nazwaKlient']);
	$ulicaKlient=corpol_rev($member['ulicaKlient']);
	$miastoKlient=corpol_rev($member['miastoKlient']);
	$kodKlient=$member['kodKlient'];
	$rachKlient=$member['rachKlient'];
	$dataWpisu=$member['dataWpisu'];
	$operID=$member['operID'];
	$source=$member['source'];
	$statusTWW=$member['statusTWW'];
	$statusSV=$member['statusSV'];
	$statusBank=$member['statusBank'];
	$sprTWW=$member['sprTWW'];
	$czyForm=$member['czyForm'];
}

echo "
<SCRIPT language='JavaScript'>
function checkStatusTww() {
  if(document.getElementById( 'statusTWW' ).value == 3) {
    document.getElementById( 'data_wys' ).style.display = 'block';
  } else {
    document.getElementById( 'data_wys' ).style.display = 'none';
  }
  return 0;
}
</SCRIPT>

<CENTER>
<P align='center' class='Big'><B>Edycja aktywacji DD</B></P>
</CENTER>

<TABLE cellspacing=0 cellpadding=2>
<FORM action='dede.php?show=frmEdit' method='post' name='frmEdit'>
<TR class='trForm'>
<TD width='50'></TD>
<TD>Zrodlo</TD>
<TD>
<SELECT name='source'>
";

$sql="SELECT idSource, nazwaSource FROM DDsource";
$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idS = $member['idSource'];
	$nazwaS = $member['nazwaSource'];
	
	echo "<OPTION value='$idS'";
	if($idS==$source) echo " selected";
	echo ">$nazwaS</OPTION>";
}
echo "
</SELECT>
</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>ID Klienta</TD>
<TD><INPUT name='idKlient' type='text' value='$idKlient'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Nr rachunku bankowego</TD>
<TD><INPUT name='rachKlient' type='text' value='$rachKlient'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Nazwa Klienta</TD>
<TD><INPUT name='nazwaKlient' type='text' value='$nazwaKlient'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Ulica</TD>
<TD><INPUT name='ulicaKlient' type='text' value='$ulicaKlient'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Miasto</TD>
<TD><INPUT name='miastoKlient' type='text' value='$miastoKlient'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Kod pocztowy</TD>
<TD><INPUT name='kodKlient' type='text' value='$kodKlient'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Status TWW</TD>
<TD>
<SELECT name='statusTWW' onchange=\"checkStatusTww()\">
";
$sql="SELECT idStatus, nazwaStatus FROM DDstatusyTWW";
$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idStatTWW = $member['idStatus'];
	$nazwaStatTWW = $member['nazwaStatus'];
	
	echo "<OPTION value='$idStatTWW'";
	if($idStatTWW==$statusTWW) echo " selected";
	echo ">$nazwaStatTWW</OPTION>";
}
echo "
</SELECT>
<DIV id='data_wys' STYLE=\"display: none\">data wysylki: <INPUT name='dataWysylki' type='text' value='RRRR-MM-DD'></DIV>

</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Status SV</TD>
<TD>
<SELECT name='statusSV'>
";
$sql="SELECT idStatus, nazwaStatus FROM DDstatusySV";
$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idStatSV = $member['idStatus'];
	$nazwaStatSV = $member['nazwaStatus'];
	
	echo "<OPTION value='$idStatSV'";
	if($idStatSV==$statusSV) echo " selected";
	echo ">$nazwaStatSV</OPTION>";
}
echo "
</SELECT>
</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Status Bank</TD>
<TD>
<SELECT name='statusBank'>
";
$sql="SELECT idStatus, nazwaStatus FROM DDstatusyBank";
$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idStatBank = $member['idStatus'];
	$nazwaStatBank = $member['nazwaStatus'];
	
	echo "<OPTION value='$idStatBank'";
	if($idStatBank==$statusBank) echo " selected";
	echo ">$nazwaStatBank</OPTION>";
}
echo "
</SELECT>
</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Weryfikacja TWW</TD>
<TD>
<SELECT name='sprTWW'>
";
$sql="SELECT idWeryf, nazwaWeryf FROM DDweryfikacje ORDER BY nazwaWeryf ASC";
$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idWeryf = $member['idWeryf'];
	$nazwaWeryf = $member['nazwaWeryf'];
	
	echo "<OPTION value='$idWeryf'";
	if($idWeryf==$sprTWW) echo " selected";
	echo ">$nazwaWeryf</OPTION>";
}
echo "
</SELECT>
</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Klient chce formularz</TD>
<TD><INPUT name='czyForm' type='checkbox'";
if($czyForm==1) echo " checked";
echo "></TD>
</TR>
<TR>
<TD></TD>
<TD></TD>
<TD>
<INPUT type='hidden' name='idPakiet' value='$idPakiet'>
<INPUT type='hidden' name='poszlo' value='1'>
<INPUT name='submitEdit' type='submit' value='ZAPISZ ZMIANY'>
</TD>
</TR>
</FORM>
</TABLE>
";
?>