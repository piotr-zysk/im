<?php
//przygotowanie zapytania

$keyword=corpol($keyword);
$keywords=explode(" ", $keyword);

$qryPlus="";

for($i=0; $i<count($keywords); $i++) {
	$qryPlus.= " AND (idKlient LIKE '%$keywords[$i]%' OR nazwaKlient LIKE '%$keywords[$i]%')";
}

//pokazanie wynikow wyszukiwania

echo "
<CENTER>
<P align='center' class='Big'><B>Wyniki wyszukiwania po frazie <i class='wyr'>$keyword</i></B></P>
<TABLE cellspacing=1 cellpadding=2 border=0 bgcolor='#444444'>
<TR class='trBrowseH'>
<TD>idKlient</TD>
<TD>nazwaKlient</TD>
<TD>ulicaKlient</TD>
<TD>miastoKlient</TD>
<TD>kodKlient</TD>
<TD>rachKlient</TD>
<TD>dataWpisu</TD>
<TD>operID</TD>
<TD>source</TD>
<TD>statusTWW</TD>
<TD>czyForm</TD>
<TD>History</TD>
</TR>
";

$color=1;

$sql="SELECT d.id AS custID, d.idKlient, d.nazwaKlient, d.ulicaKlient, d.miastoKlient, d.kodKlient, d.rachKlient, d.dataWpisu, d.operID, d.source, d.statusTWW, d.statusSV, d.statusBank, d.sprTWW, d.czyForm, u.id AS userID, u.f_name, u.s_name, s.nazwaStatus, src.nazwaSource FROM DDpakiety d, tab_users u, DDstatusyTWW s, DDsource src WHERE u.id=d.operID AND d.statusTWW=s.idStatus AND src.idSource=d.source";
$sql.=$qryPlus;
$sql.=" ORDER BY dataWpisu DESC, idKlient ASC";

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
<A href='dede.php?show=frmEdit&idPakiet=$idPakiet' class='aBrowse'>
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
<TD>$f_name $s_name</TD>
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
?>