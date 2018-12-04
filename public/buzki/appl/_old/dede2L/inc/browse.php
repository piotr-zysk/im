<?php
//budowanie sql'a i linku do wiersza tabeli
if($go=="sprTWW") {
	$qryPlus=" AND d.statusTWW='1'";
	$link="dede.php?show=frmWeryf";
	echo "<P align='center' class='Big'><B>Formularze czekajace na weryfikacje TWW</B></P>";
} elseif($go=="sendForm") {
	$qryPlus=" AND d.statusTWW='0'";
	$link="dede.php?show=frmEdit";
	echo "<P align='center' class='Big'><B>Klienci, ktorym nalezy wyslac formularze</B></P>";
} elseif($go=="statusSV0") {
	$qryPlus=" AND d.statusSV='0' AND d.sprTWW='1'";
	$link="dede.php?show=frmEdit";
	echo "<P align='center' class='Big'><B>Klienci zweryfikowani TWW do zmiany statusu SV</B></P>";
} elseif($go=="firstBad") {
	$qryPlus=" AND d.sprTWW!='0' AND d.sprTWW!='1' AND d.statusTWW!='7'";
	$link="dede.php?show=contact";
	echo "<P align='center' class='Big'><B>Klienci, z ktorymi nalezy sie skontaktowac po negatywnej weryfikacji TWW</B></P>";

	//updejt pakietow - wygaszenie, pod warunkiem, ze minely 3 dni od weryfikacji
	$data3=minus3();
	$dataHist=date("Y-m-d H:i");	
	$qryHist="SELECT     dataHistoria AS EXPR1, idPakietu AS EXPR2, weryfikacjaTWW AS EXPR3
	FROM         DDhistoria
	WHERE     (weryfikacjaTWW > 2) AND (dataHistoria < $data3) ORDER BY dataHistoria";
	$queryH = $db->query($qryHist);
	while ($memberH = $db->fetch_array($queryH)) {
		$idPakiet=$memberH['EXPR2'];
		//updejt
		$db->query("UPDATE DDpakiety SET statusTWW = 7 WHERE id='$idPakiet'");
		$db->query("INSERT INTO DDhistoria(dataHistoria, idPakietu, statusTWW) VALUES('$dataHist', '$idPakiet', '7')");
	}

} elseif($go=="secondBad") {
	$qryPlus=" AND d.statusBank=1 AND d.statusTWW=4";
	$link="dede.php?show=contact";
	echo "<P align='center' class='Big'><B>Klienci, z ktorymi nalezy sie skontaktowac po pozytywnej weryfikacji banku</B></P>";
} else {
	$link="dede.php?show=frmEdit";
}



echo "
<CENTER>
<TABLE cellspacing=1 cellpadding=2 border=0 bgcolor='#444444'>
<TR class='trBrowseH'>
<TD>idKlient</TD>
<TD>Nazwa</TD>
<TD>Ulica</TD>
<TD>Miasto</TD>
<TD>Poczta</TD>
<TD>Rachunek</TD>
<TD>dataWpisu</TD>
<TD>Weryfikacja</TD>
<TD>Src</TD>
<TD>StatusTWW</TD>
<TD>Form</TD>
</TR>
";

$color=1;

$sql="SELECT d.id AS custID, d.idKlient, d.nazwaKlient, d.ulicaKlient, d.miastoKlient, d.kodKlient, d.rachKlient, d.dataWpisu, d.operID, d.source, d.statusTWW, d.statusSV, d.statusBank, d.sprTWW, d.czyForm, u.id, u.f_name, u.s_name, s.nazwaStatus, src.nazwaSource, w.nazwaWeryf FROM DDpakiety d, tab_users u, DDstatusyTWW s, DDsource src, DDweryfikacje w WHERE u.id=d.operID AND d.statusTWW=s.idStatus AND src.idSource=d.source AND w.idWeryf=d.sprTWW";
$sql.=$qryPlus;
$sql.=" ORDER BY d.dataWpisu DESC, d.idKlient ASC";

$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idPakiet=$member['custID'];
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

	$nazwaWeryf=$member['nazwaWeryf'];
		
	$f_name=$member['f_name'];
	$s_name=$member['s_name'];

	$nazwaStatusTWW=$member['nazwaStatus'];
	
	$nazwaSource=$member['nazwaSource'];

	if($rachKlient=="") $rachKlient="nie podano";

	if($czyForm==1) {
		$czyFormFull="tak";
	} else {
		$czyFormFull="nie";
	}
	
	$color*=-1;

	//sprawdzamy, czy jeszcze nie bylo kontaktu z klientem jezeli chodzi o second Bad
	if($go=="secondBad") {
		//pobieranie daty ustawienia statusu Bank
		$data="";
		$sqlDate="SELECT     idPakietu, dataHistoria, statusBank
		FROM         DDhistoria
		WHERE     (idPakietu = $idPakiet) AND (statusBank = 1)";
		$qryDate=$db->query($sqlDate);
		while ($mem = $db->fetch_array($qryDate)) {
			$data=$mem['dataHistoria'];
		}

		$data=ms2normal($data);

		//sprawdzamy, czy udalo nam sie skontaktowac z klientem po weryfikacji Bank
		$jest=0;
		$sqlCon="SELECT     idPakietu, dataHistoria, kontaktKlient
		FROM         DDhistoria
		WHERE     (idPakietu = $idPakiet) AND (kontaktKlient = 1)
		AND (dataHistoria > CONVERT(DATETIME, '$data', 102))";
		$qryCon=$db->query($sqlCon);
		while ($mem = $db->fetch_array($qryCon)) {
			$jest=1;
		}
		//jezeli nie bylo kontaktu z klientem
		if($jest==0) {

		echo "
		<A href='$link&idPakiet=$idPakiet&Sec=1' class='aBrowse'>
		<TR class='trBrowse";
		if($color==1) echo "1";
		echo"' onmouseover=\"this.style.backgroundColor='#f1cfcf'\" 
		onmouseout=\"this.style.backgroundColor=''\">
		<TD>$idKlient</TD>
		<TD>$nazwaKlient</TD>
		<TD>$ulicaKlient</TD>
		<TD>$miastoKlient</TD>
		<TD>$kodKlient</TD>
		<TD>$rachKlient</TD>
		<TD>$dataWpisu</TD>
		<TD>$nazwaWeryf</TD>
		<TD>$nazwaSource</TD>
		<TD>$nazwaStatusTWW</TD>
		<TD>$czyFormFull</TD>
		</TR>
		</A>
		";
		}
	} else {
		echo "
		<A href='$link&idPakiet=$idPakiet' class='aBrowse'>
		<TR class='trBrowse";
		if($color==1) echo "1";
		echo"' onmouseover=\"this.style.backgroundColor='#f1cfcf'\" 
		onmouseout=\"this.style.backgroundColor=''\">
		<TD>$idKlient</TD>
		<TD>$nazwaKlient</TD>
		<TD>$ulicaKlient</TD>
		<TD>$miastoKlient</TD>
		<TD>$kodKlient</TD>
		<TD>$rachKlient</TD>
		<TD>$dataWpisu</TD>
		<TD>$nazwaWeryf</TD>
		<TD>$nazwaSource</TD>
		<TD>$nazwaStatusTWW</TD>
		<TD>$czyFormFull</TD>
		</TR>
		</A>
		";
	}
}
echo "
</TABLE>
</CENTER>
";
?>