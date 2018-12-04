<?php
//pokazanie historii pakietu $idPakiet

echo "
<A href='javascript:history.back()' class='aBrowse'><IMG SRC='gfx/kropkaRed.gif' border='0'> <B>POWROT</B></A>
<CENTER>
<P align='center' class='Big'><B>Historia pakietu</B></P>
<TABLE cellspacing=1 cellpadding=2 border=0 bgcolor='#444444'>
<TR class='trBrowseH'>
<TD class='tabHistory'>dataHistoria</TD>
<TD class='tabHistory'>idKlient</TD>
<TD class='tabHistory'>Klient</TD>
<TD class='tabHistory'>rachKlient</TD>
<TD class='tabHistory'>dataWpisu</TD>
<TD class='tabHistory'>operID</TD>
<TD class='tabHistory'>source</TD>
<TD class='tabHistory'>statusTWW</TD>
<TD class='tabHistory'>statusSV</TD>
<TD class='tabHistory'>statusBank</TD>
<TD class='tabHistory'>pismo</TD>
<TD class='tabHistory'>kontakt</TD>
<TD class='tabHistory'>weryfikacjaTWW</TD>
<TD class='tabHistory'>czyForm</TD>
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
WHERE     (DDhistoria.idPakietu = '$idPakiet')";

$sql.=" ORDER BY idHist";

/*
DDhistoria.idHist AS EXPR1,
DDhistoria.dataHistoria AS EXPR2, 
DDhistoria.idPakietu AS EXPR3, 
DDhistoria.idKlient AS EXPR4, 
DDhistoria.nazwaKlient AS EXPR5, 
DDhistoria.ulicaKlient AS EXPR6, 
DDhistoria.kodKlient AS EXPR7, 
DDhistoria.miastoKlient AS EXPR8, 
DDhistoria.rachKlient AS EXPR9, 
DDhistoria.dataWpisu AS EXPR10, 
view_users_active.f_name AS EXPR11, 
view_users_active.s_name AS EXPR12, 
DDsource.nazwaSource AS EXPR13, 
DDstatusyTWW.nazwaStatus AS EXPR14, 
DDweryfikacje.nazwaWeryf AS EXPR15, 
DDstatusySV.nazwaStatus AS EXPR16, 
DDstatusyBank.nazwaStatus AS EXPR17, 
DDpisma.nazwaPisma AS EXPR18, 
DDkontaktyKlient.nazwaKontaktu AS EXPR19, 
DDhistoria.czyForm AS EXPR20
*/

//resetowanie Old'ow
$dataHistoriaOld="";
$idKlientOld="";
$nazwaKlientOld="";
$ulicaKlientOld="";
$kodKlientOld="";
$miastoKlientOld="";
$rachKlientOld="";
$dataWpisuOld="";
$f_nameOld="";
$s_nameOld="";
$nazwaSourceOld="";
$nazwaStatusTWWOld="";
$nazwaStatusSVOld="";
$nazwaStatusBankOld="";
$nazwaPismaOld="";
$nazwaKontaktuOld="";
$nazwaWeryfOld="";
$czyFormFullOld="";

$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idHist=$member['EXPR1'];
	$dataHistoria=$member['EXPR2'];
	$idPakietu=$member['EXPR3'];
	$idKlient=$member['EXPR4'];
	$nazwaKlient=corpol_rev($member['EXPR5']);
	$ulicaKlient=corpol_rev($member['EXPR6']);
	$kodKlient=$member['EXPR7'];
	$miastoKlient=corpol_rev($member['EXPR8']);
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
<TD class='tabHistory";
if($dataHistoria!=$dataHistoriaOld) echo "New";
echo "'>$dataHistoria</TD>
<TD class='tabHistory";
if($idKlient!=$idKlientOld) echo "New";
echo "'>$idKlient</TD>
<TD class='tabHistory";
if($nazwaKlient!=$nazwaKlientOld || $ulicaKlient!=$ulicaKlientOld || $kodKlient!=$kodKlientOld || $miastoKlient=$miastoKlientOld) echo "New";
echo "'>$nazwaKlient, $ulicaKlient $kodKlient $miastoKlient</TD>
<TD class='tabHistory";
if($rachKlient!=$rachKlientOld) echo "New";
echo "'>$rachKlient</TD>
<TD class='tabHistory";
if($dataWpisu!=$dataWpisuOld) echo "New";
echo "'>$dataWpisu</TD>
<TD class='tabHistory";
if($f_name!=$f_nameOld || $s_name!=$s_nameOld) echo "New";
echo "'>$f_name $s_name</TD>
<TD class='tabHistory";
if($nazwaSource!=$nazwaSourceOld) echo "New";
echo "'>$nazwaSource</TD>
<TD class='tabHistory";
if($nazwaStatusTWW!=$nazwaStatusTWWOld) echo "New";
echo "'>$nazwaStatusTWW</TD>
<TD class='tabHistory";
if($nazwaStatusSV!=$nazwaStatusSVOld) echo "New";
echo "'>$nazwaStatusSV</TD>
<TD class='tabHistory";
if($nazwaStatusBank!=$nazwaStatusBankOld) echo "New";
echo "'>$nazwaStatusBank</TD>
<TD class='tabHistory";
if($nazwaPisma!=$nazwaPismaOld) echo "New";
echo "'>$nazwaPisma</TD>
<TD class='tabHistory";
if($nazwaKontaktu!=$nazwaKontaktuOld) echo "New";
echo "'>$nazwaKontaktu</TD>
<TD class='tabHistory";
if($nazwaWeryf!=$nazwaWeryfOld) echo "New";
echo "'>$nazwaWeryf</TD>
<TD class='tabHistory";
if($czyFormFull!=$czyFormFullOld) echo "New";
echo "'>$czyFormFull</TD>
</TR>
";

//tworzenie Old'ow
$dataHistoriaOld=$dataHistoria;
$idKlientOld=$idKlient;
$nazwaKlientOld=$nazwaKlient;
$ulicaKlientOld=$ulicaKlient;
$kodKlientOld=$kodKlient;
$miastoKlientOld=$miastoKlient;
$rachKlientOld=$rachKlient;
$dataWpisuOld=$dataWpisu;
$f_nameOld=$f_name;
$s_nameOld=$s_name;
$nazwaSourceOld=$nazwaSource;
$nazwaStatusTWWOld=$nazwaStatusTWW;
$nazwaStatusSVOld=$nazwaStatusSV;
$nazwaStatusBankOld=$nazwaStatusBank;
$nazwaPismaOld=$nazwaPisma;
$nazwaKontaktuOld=$nazwaKontaktu;
$nazwaWeryfOld=$nazwaWeryf;
$czyFormFullOld=$czyFormFull;
}
echo "
</TABLE>
</CENTER>
";
?>