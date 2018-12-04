<?php
//budowanie sql'a i linku do wiersza tabeli
$link="dede.php?show=frmEdit";

echo "
<CENTER>
<BR>
";

if($goBrowse=="") {

echo"
<P class='Big'>
<B>POKAZ WSZYSTKIE PAKIETY Z OKRESU</B>
</P>
<TABLE cellspacing=0 cellpadding=2 border=0>
<FORM action='dede.php?show=browseByDate' method='post' name='browseDateChoser'>
<TR>
<TD>
<SELECT name='dataOd'>
";

//przygotowanie dat
$qryDate="
SELECT     dataWpisu
FROM         DDpakiety
GROUP BY dataWpisu
ORDER BY dataWpisu DESC";

$dateOld="";
$date2sel="";
$i=0;
$query = $db->query($qryDate);
while ($member = $db->fetch_array($query)) {
	$dataWpisu=$member['dataWpisu'];
	$dataWpisu=ms2normal( $dataWpisu );
	//$dataWpisu=date("Y-m-d", $dataWpisu);
	if($dataWpisu!=$dateOld) {
		echo "<OPTION value='$dataWpisu'>$dataWpisu</OPTION>";
	}
	$dateOld=$dataWpisu;
}

echo "
</SELECT>
</TD>
<TD> - </TD>
<TD>
<SELECT name='dataDo'>
";
$dataJutro=jutro();
echo "<OPTION value='$dataJutro'>$dataJutro</OPTION>";
//przygotowanie dat
$qryDate="
SELECT     dataWpisu
FROM         DDpakiety
GROUP BY dataWpisu
ORDER BY dataWpisu DESC";

$dateOld="";
$date2sel="";
$i=0;
$query = $db->query($qryDate);
while ($member = $db->fetch_array($query)) {
	$dataWpisu=$member['dataWpisu'];
	$dataWpisu=ms2normal( $dataWpisu );
	//$dataWpisu=date("Y-m-d", $dataWpisu);
	if($dataWpisu!=$dateOld) {
		echo "<OPTION value='$dataWpisu'>$dataWpisu</OPTION>";
	}
	$dateOld=$dataWpisu;
}
echo "
</SELECT>
</TD>
<TD><INPUT type='submit' name='goBrowse' value='POKAZ'></TD>
</TR>
<TR><TD><B class='Small'>Data od</B></TD><TD></TD><TD><B class='Small'>Data do (+1)</B></TD><TD></TD></TR>
</FORM>
</TABLE>
";

} else {


echo "
<P align='center' class='Big'><B>Pakiety wprowadzone do systemy w dniu $dataOd - $dataDo</B></P>
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
<TD>History</TD>
</TR>
";

$color=1;

$sql="SELECT d.id AS custID, d.idKlient, d.nazwaKlient, d.ulicaKlient, d.miastoKlient, d.kodKlient, d.rachKlient, d.dataWpisu, d.operID, d.source, d.statusTWW, d.statusSV, d.statusBank, d.sprTWW, d.czyForm, u.id, u.f_name, u.s_name, s.nazwaStatus, src.nazwaSource, w.nazwaWeryf FROM DDpakiety d, tab_users u, DDstatusyTWW s, DDsource src, DDweryfikacje w WHERE u.id=d.operID AND d.statusTWW=s.idStatus AND src.idSource=d.source AND w.idWeryf=d.sprTWW";
$sql.=" AND d.dataWpisu BETWEEN '$dataOd' AND '$dataDo'";
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
<TD><A href='dede.php?show=history&idPakiet=$idPakiet'><IMG src='gfx/history.gif' border='0' ALT='View history'></A></TD>
</TR>
</A>
";
}
echo "
</TABLE>
</CENTER>
";

}
?>