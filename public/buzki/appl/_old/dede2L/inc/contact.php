<?php
// sprawdzamy, ktory to jest kontakt z klientem
// dwa etapy - pierwszy kontakt ($kon=1) bezposrednio po weryfikacji
//             drugi kontakt po weryfikacji z banku ($kon=2)
if($kon==1) {
	
} elseif($kon==2) {

} else {
	//$kon=1
}

//zmiana statusu na Bank przyjal - wysylamy pismo
if($pismo!="") {
	$dataHistoria=date("Y-m-d H:i");
	$operID=$xmbid;

	$db->query("INSERT INTO DDhistoria(dataHistoria,idPakietu,operID,statusTWW) VALUES('$dataHistoria','$idPakiet','$operID','6')");
	$db->query("UPDATE DDpakiety SET statusTWW='6' WHERE id='$idPakiet'");
}


//wprowadzenie kontaktu do DDhistoria
if($contactOk!="" && $kontaktKlient!=0) {
	$dataHistoria=date("Y-m-d H:i");
	$operID=$xmbid;

	$db->query("INSERT INTO DDhistoria(dataHistoria,idPakietu,idKlient,nazwaKlient,ulicaKlient,rachKlient,operID,kontaktKlient,miastoKlient,kodKlient,czyForm) VALUES('$dataHistoria','$idPakiet','$idKlient','$nazwaKlient','$ulicaKlient','$rachKlient','$operID','$kontaktKlient','$miastoKlient','$kodKlient','$czyForm')");
}

//pobranie danych do form
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
<B class='Big'>Kontakt z klientem</B><BR><BR>
</CENTER>

<TABLE cellspacing=0 cellpadding=2><TR><TD align='left' valign='top' width=300>

<TABLE cellspacing=0 cellpadding=2>
<FORM action='dede.php?show=contact";
if($Sec==1) echo "&Sec=1";
echo "' method='post' name='frmEdit'>

<TR class='trForm'>
<TD width='50'></TD>
<TD>ID:</TD>
<TD class='wyr'>$idKlient</TD>
</TR>

<TR class='trForm'>
<TD></TD>
<TD>NAZWA:</TD>
<TD class='wyr'>$nazwaKlient</TD>
</TR>

<TR class='trForm'>
<TD></TD>
<TD>ADRES:</TD>
<TD class='wyr'>$ulicaKlient $kodKlient $miastoKlient</TD>
</TR>

<TR class='trForm'>
<TD></TD>
<TD colspan='2'><HR></TD>
</TR>
";
if($pismo!=1 || !isset($pismo)) {
echo "
<TR class='trForm'>
<TD></TD>
<TD>KONTAKT:</TD>
<TD>
<SELECT name='kontaktKlient'>
";
$sqlC="SELECT idKontaktu, nazwaKontaktu FROM DDkontaktyKlient";
$queryC = $db->query($sqlC);
while ($memberC = $db->fetch_array($queryC)) {
	$idKontaktu=$memberC['idKontaktu'];
	$nazwaKontaktu=$memberC['nazwaKontaktu'];

	echo "<OPTION value='$idKontaktu'>$nazwaKontaktu</OPTION>";
}
echo "
</SELECT>
</TD>
</TR>
";
}

echo "
<TR class='trForm'>
<TD></TD>
<TD colspan='2'><HR></TD>
</TR>

<TR class='trForm'>
<TD></TD>
<TD>
<INPUT type='button' value='POWROT' onClick=\"javascript:goUrl('dede.php?show=browse&go=";
if($Sec==1) {
	echo "second";
} else {
	echo "first";
}
echo"Bad')\">

<INPUT type='hidden' name='idPakiet' value='$idPakiet'>
<INPUT type='hidden' name='idKlient' value='$idKlient'>
<INPUT type='hidden' name='nazwaKlient' value='$nazwaKlient'>
<INPUT type='hidden' name='ulicaKlient' value='$ulicaKlient'>
<INPUT type='hidden' name='miastoKlient' value='$miastoKlient'>
<INPUT type='hidden' name='kodKlient' value='$kodKlient'>
<INPUT type='hidden' name='rachKlient' value='$rachKlient'>
<INPUT type='hidden' name='czyForm' value='$czyForm'>
</TD>
<TD align='right'>
<INPUT type='submit' value='ZAPISZ' name='contactOk'><BR>";
if($Sec==1) {
	echo "<BR><INPUT type='button' value='WYSLIJ PISMO' onClick=\"javascript:goUrl('dede.php?show=contact&idPakiet=$idPakiet&Sec=1&pismo=1')\">";
}
echo "
</TD>
</TR>

</FORM>
</TABLE>

</TD><TD align='left' valign='top'>
";


//pokazanie historii pakietu $idPakiet
echo "
<P class='Small'>Skrocona historia kontaktow z klientem</P>
<TABLE cellspacing=1 cellpadding=2 border=0 bgcolor='#444444'>
<TR class='trBrowseH'>
<TD class='tabHistory'>dataHistoria</TD>
<TD class='tabHistory'>operID</TD>
<TD class='tabHistory'>pismo</TD>
<TD class='tabHistory'>kontakt</TD>
<TD class='tabHistory'>weryfikacjaTWW</TD>
<TD class='tabHistory'>statusBank</TD>
</TR>
";

$color=1;

$sql="SELECT     DDhistoria.idHist AS EXPR1, DDhistoria.dataHistoria AS EXPR2, DDhistoria.idPakietu AS EXPR3, DDhistoria.idKlient AS EXPR4, 
                      DDhistoria.nazwaKlient AS EXPR5, DDhistoria.ulicaKlient AS EXPR6, DDhistoria.kodKlient AS EXPR7, DDhistoria.miastoKlient AS EXPR8, 
                      DDhistoria.rachKlient AS EXPR9, DDhistoria.dataWpisu AS EXPR10, view_users_active.f_name AS EXPR11, view_users_active.s_name AS EXPR12, 
                      DDsource.nazwaSource AS EXPR13, DDstatusyTWW.nazwaStatus AS EXPR14, DDweryfikacje.nazwaWeryf AS EXPR15, 
                      DDstatusySV.nazwaStatus AS EXPR16, DDstatusyBank.nazwaStatus AS EXPR17, DDpisma.nazwaPisma AS EXPR18, 
                      DDkontaktyKlient.nazwaKontaktu AS EXPR19, DDhistoria.czyForm AS EXPR20
FROM         DDstatusySV RIGHT OUTER JOIN
                      DDstatusyTWW RIGHT OUTER JOIN
                      DDhistoria INNER JOIN
                      view_users_active ON DDhistoria.operID = view_users_active.id LEFT OUTER JOIN
                      DDweryfikacje ON DDhistoria.sprTWW = DDweryfikacje.idWeryf ON DDstatusyTWW.idStatus = DDhistoria.statusTWW LEFT OUTER JOIN
                      DDsource ON DDhistoria.source = DDsource.idSource ON DDstatusySV.idStatus = DDhistoria.statusSV LEFT OUTER JOIN
                      DDpisma ON DDhistoria.wysylkaPisma = DDpisma.idPisma LEFT OUTER JOIN
                      DDstatusyBank ON DDhistoria.statusBank = DDstatusyBank.idStatus LEFT OUTER JOIN
                      DDkontaktyKlient ON DDhistoria.kontaktKlient = DDkontaktyKlient.idKontaktu
WHERE     (DDhistoria.idPakietu = '$idPakiet') ORDER BY idHist";

$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idHist=$member['EXPR1'];
	$dataHistoria=$member['EXPR2'];
	$idPakietu=$member['EXPR3'];
	$idKlient=$member['EXPR4'];
	$nazwaKlient=$member['EXPR5'];
	$ulicaKlient=$member['EXPR6'];
	$kodKlient=$member['EXPR7'];
	$miastoKlient=$member['EXPR8'];
	$rachKlient=$member['EXPR9'];
	$dataWpisu=$member['EXPR10'];
	$f_name=$member['EXPR11'];
	$s_name=$member['EXPR12'];
	$nazwaSource=$member['EXPR13'];
	$nazwaStatusTWW=$member['EXPR14'];
	$nazwaWeryf=$member['EXPR15'];
	$nazwaStatusSV=$member['EXPR16'];
	$nazwaStatusBank=$member['EXPR17'];
	$nazwaPisma=$member['EXPR18'];
	$nazwaKontaktu=$member['EXPR19'];
	$czyForm=$member['EXPR20'];

	//if($rachKlient=="") $rachKlient="nie podano";

	if($czyForm==1) {
		$czyFormFull="tak";
	} else {
		$czyFormFull="nie";
	}
	
	$color*=-1;

echo "
<TR class='trBrowse";
if($color==1) echo "1";
echo"' onmouseover=\"this.style.backgroundColor='#f1cfcf'\" 
onmouseout=\"this.style.backgroundColor=''\">
<TD class='tabHistory'>$dataHistoria</TD>
<TD class='tabHistory'>$f_name $s_name</TD>
<TD class='tabHistory'>$nazwaPisma</TD>
<TD class='tabHistory'>$nazwaKontaktu</TD>
<TD class='tabHistory'>$nazwaWeryf</TD>
<TD class='tabHistory'>$nazwaStatusBank</TD>
</TR>
";
}
echo "
</TABLE>
<P class='Small'>
<A href='dede.php?show=history&idPakiet=$idPakiet'>Zobacz pelna historie</A>
</P>
";

//zakonczenie zewnetrznej tabeli
echo "
</TD></TR>
</TABLE>
";
?>