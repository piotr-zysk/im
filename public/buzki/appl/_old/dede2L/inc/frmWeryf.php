<?php
if($submitWeryf!="") {
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
$dataHistoria=date("Y-m-d H:i");

//pobranie operID
$operID=$xmbid;

//konwersja $czyForm
if($czyForm=="on") {
	$czyForm=1;
} else {
	$czyForm=0;
}

//zapisanie danych z form do tabeli DDpakiety
$sqlWeryf="UPDATE DDpakiety SET rachKlient='$rachKlient', statusTWW='$statusTWW', sprTWW='$sprTWW'";
$sqlWeryf.=", nazwaKlient='$nazwaKlient', ulicaKlient='$ulicaKlient', miastoKlient='$miastoKlient', kodKlient='$kodKlient'"; //z rozwijanych pól
if($doSV=='on') $sqlWeryf.=", statusSV='1'";
$sqlWeryf.=" WHERE id='$idPakiet'";

$db->query($sqlWeryf);
//echo "SQL1: UPDATE DDpakiety SET rachKlient='$rachKlient', statusTWW='$statusTWW', sprTWW='$sprTWW' WHERE id='$idPakiet'<BR><BR>";

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
//echo "SQL2: $sqlHistory";
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
<CENTER>
<B>Weryfikacja formularza DD</B><BR><BR>
</CENTER>

<TABLE cellspacing=0 cellpadding=2>
<FORM action='dede.php?show=frmWeryf' method='post' name='frmWeryf'>
<TR class='trForm'>
<TD width='50'></TD>
<TD width='140'>Zrodlo</TD>
<TD>
";

$sql="SELECT idSource, nazwaSource, formSource FROM DDsource";
$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idS = $member['idSource'];
	$nazwaS = $member['nazwaSource'];
	$formS = $member['formSource'];
	
	if($idS==$source) echo "$nazwaS [$formS]";
}
echo "
</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>ID Klienta</TD>
<TD>$idKlient</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Nr rachunku bankowego</TD>
<TD><INPUT name='rachKlient' type='text' value='$rachKlient' size='40'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Nazwa Klienta</TD>
<TD>
$nazwaKlient &nbsp;&nbsp;
<A href='#' onclick=\"Pokaz( 'nazwa_klienta' )\"><IMG src='gfx/plusik.gif' border='0' valign='middle'></A>
<DIV id='nazwa_klienta' STYLE=\"display: none\"><INPUT name='nazwaKlient' value='$nazwaKlient' type='text'></DIV>
</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Ulica</TD>
<TD>
$ulicaKlient &nbsp;&nbsp;
<A href='#' onclick=\"Pokaz( 'ulica_klient' )\"><IMG src='gfx/plusik.gif' border='0' valign='middle'></A>
<DIV id='ulica_klient' STYLE=\"display: none\"><INPUT name='ulicaKlient' value='$ulicaKlient' type='text'></DIV>
</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Miasto</TD>
<TD>
$miastoKlient &nbsp;&nbsp;
<A href='#' onclick=\"Pokaz( 'miasto_klient' )\"><IMG src='gfx/plusik.gif' border='0' valign='middle'></A>
<DIV id='miasto_klient' STYLE=\"display: none\"><INPUT name='miastoKlient' value='$miastoKlient' type='text'></DIV>
</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Kod pocztowy</TD>
<TD>
$kodKlient &nbsp;&nbsp;
<A href='#' onclick=\"Pokaz( 'kod_klient' )\"><IMG src='gfx/plusik.gif' border='0' valign='middle'></A>
<DIV id='kod_klient' STYLE=\"display: none\"><INPUT name='kodKlient' value='$kodKlient' type='text'></DIV>
</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Weryfikacja TWW</TD>
<TD>
<SELECT name='sprTWW'>
";
$sql="SELECT idWeryf, nazwaWeryf FROM DDweryfikacje ORDER BY nazwaWeryf";
$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idWeryf = $member['idWeryf'];
	$nazwaWeryf = corpol_rev($member['nazwaWeryf']);
	
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
<TD>Wprowadzono do SV</TD>
<TD>
<INPUT name='doSV' type='checkbox' class='Trans'>
</TD>
</TR>
<TR>
<TD></TD>
<TD></TD>
<TD>
<INPUT type='hidden' name='statusTWW' value='2'>
<INPUT type='hidden' name='idPakiet' value='$idPakiet'>
<INPUT type='hidden' name='poszlo' value='1'>
<INPUT name='submitWeryf' type='submit' value='POTWIERDZ WERYFIKACJE'>
</TD>
</TR>
</FORM>
</TABLE>
";
?>