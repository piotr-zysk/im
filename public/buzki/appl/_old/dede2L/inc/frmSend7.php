<CENTER>
<P class='Big'><B>RAPORT Z OPOZNIEN BANKU</B></P>
</CENTER>

<?php
if($send!="") {
	//data sprzed 7 dni
	$data7=minus7();
	
	$lista="idKlient;nazwaKlient;adresKlient;rachKlient\n";
	//ile do odrzuconych przez Bank bez kontaktu
	$sqlBank="SELECT id, idKlient, nazwaKlient, ulicaKlient, miastoKlient, kodKlient, rachKlient FROM DDpakiety WHERE (statusBank = 0) AND (statusTWW = 3)";
	$qryBank=$db->query($sqlBank);
	while ($member = $db->fetch_array($qryBank)) {
		$id=$member['id'];
		$idKlient=$member['idKlient'];
		$nazwaKlient=corpol_rev($member['nazwaKlient']);
		$ulicaKlient=corpol_rev($member['ulicaKlient']);
		$miastoKlient=corpol_rev($member['miastoKlient']);
		$kodKlient=$member['kodKlient'];
		$rachKlient=$member['rachKlient'];

		$jest=0;
		$sqlHist="SELECT * FROM DDhistoria WHERE idPakietu=$id AND statusTWW=3 AND dataHistoria<'$data7'";
		$qryHist=$db->query($sqlHist);
		while ($member = $db->fetch_array($qryHist)) {
			$jest++;
		}
	if($jest>0) $lista.="$idKlient;$nazwaKlient;$ulicaKlient $kodKlient $MiastoKlient;$rachKlient\n";
	}

	//tworzenie pliku tekstowego CSV
	$file=fopen("tmp/lista.csv", "w+");
	fwrite($file, $lista);
	fclose($file);
	
	//plik do pobrania
	echo "
	<IFRAME width=0 height=0 src='tmp/lista.csv'></IFRAME>
	";
}
?>

<TABLE cellspacing=0 cellpadding=0 border=0>
<FORM name='send7' action='dede.php?show=frmSend7' method='post'>
<TR class='trForm'>
<TD width='50'></TD>
<TD>Wyslij E-mail z powiadomieniem o 7-dniowym opoznieniu banku</TD>
</TR>
<TR>
<TD width='50'></TD>
<TD class='Small'>
Skrypt generuje liste rekordow w pliku CSV.
</TD>
</TR>
<TR>
<TD height='20'></TD>
</TR>
<TR>
<TD width='50'></TD>
<TD align='right'><INPUT type='submit' name='send' value='WYGENERUJ PLIK' size='10'></TD>
</TR>
</FORM>
</TABLE>

