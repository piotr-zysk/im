<?php
//*************************************** DANE DO STATYSTYK ************************

//ile wszystkich
$sqlAll="SELECT d.id AS custID, d.idKlient, d.nazwaKlient, d.ulicaKlient, d.miastoKlient, d.kodKlient, d.rachKlient, d.dataWpisu, d.operID, d.source, d.statusTWW, d.statusSV, d.statusBank, d.sprTWW, d.czyForm, u.id, u.f_name, u.s_name, s.nazwaStatus, src.nazwaSource, w.nazwaWeryf FROM DDpakiety d, tab_users u, DDstatusyTWW s, DDsource src, DDweryfikacje w WHERE u.id=d.operID AND d.statusTWW=s.idStatus AND src.idSource=d.source AND w.idWeryf=d.sprTWW";
$qryAll=$db->query($sqlAll);
$ileAll=$db->num_rows($qryAll);

//ile do wyslania Form
$sqlForm="SELECT d.id AS custID, d.idKlient, d.nazwaKlient, d.ulicaKlient, d.miastoKlient, d.kodKlient, d.rachKlient, d.dataWpisu, d.operID, d.source, d.statusTWW, d.statusSV, d.statusBank, d.sprTWW, d.czyForm, u.id, u.f_name, u.s_name, s.nazwaStatus, src.nazwaSource, w.nazwaWeryf FROM DDpakiety d, tab_users u, DDstatusyTWW s, DDsource src, DDweryfikacje w WHERE u.id=d.operID AND d.statusTWW=s.idStatus AND src.idSource=d.source AND w.idWeryf=d.sprTWW AND d.statusTWW='0' AND d.czyForm='1'";
$qryForm=$db->query($sqlForm);
$ileForm=$db->num_rows($qryForm);

//ile do weryfikacji TWW
$sqlWer="SELECT d.id AS custID, d.idKlient, d.nazwaKlient, d.ulicaKlient, d.miastoKlient, d.kodKlient, d.rachKlient, d.dataWpisu, d.operID, d.source, d.statusTWW, d.statusSV, d.statusBank, d.sprTWW, d.czyForm, u.id, u.f_name, u.s_name, s.nazwaStatus, src.nazwaSource, w.nazwaWeryf FROM DDpakiety d, tab_users u, DDstatusyTWW s, DDsource src, DDweryfikacje w WHERE u.id=d.operID AND d.statusTWW=s.idStatus AND src.idSource=d.source AND w.idWeryf=d.sprTWW AND d.statusTWW='1'";
$qryWer=$db->query($sqlWer);
$ileWer=$db->num_rows($qryWer);

//ile do weryfikacji Bank
$sqlBank="SELECT d.id AS custID, d.idKlient, d.nazwaKlient, d.ulicaKlient, d.miastoKlient, d.kodKlient, d.rachKlient, d.dataWpisu, d.operID, d.source, d.statusTWW, d.statusSV, d.statusBank, d.sprTWW, d.czyForm, u.id, u.f_name, u.s_name, s.nazwaStatus, src.nazwaSource, w.nazwaWeryf FROM DDpakiety d, tab_users u, DDstatusyTWW s, DDsource src, DDweryfikacje w WHERE u.id=d.operID AND d.statusTWW=s.idStatus AND src.idSource=d.source AND w.idWeryf=d.sprTWW AND d.statusTWW='3'";
$qryBank=$db->query($sqlBank);
$ileBank=$db->num_rows($qryBank);

//ile do odrzuconych przez Bank
$sqlBankGo="SELECT id, statusBank FROM DDpakiety WHERE (statusBank > 1)";
$qryBankGo=$db->query($sqlBankGo);
$ileBankGo=$db->num_rows($qryBankGo);

//ile do zaakceptowanych przez Bank bez kontaktu
$ileBankCon=0;
$sqlBankCon="SELECT id, statusBank FROM DDpakiety WHERE (statusBank = 1)";
$qryBankCon=$db->query($sqlBankCon);
while ($member = $db->fetch_array($qryBankCon)) {
	$id=$member['id'];
	//sprawdzenie, czy nastapil kontakt z klientem
	//pobieranie daty ustawienia statusu Bank
	$data="";
	$sqlDate="SELECT     idPakietu, dataHistoria, statusBank
	FROM         DDhistoria
	WHERE     (idPakietu = $id) AND (statusBank = 1)";
	$qryDate=$db->query($sqlDate);
	while ($mem = $db->fetch_array($qryDate)) {
		$data=$mem['dataHistoria'];
	}
	$data=ms2normal($data);
	//sprawdzamy, czy udalo nam sie skontaktowac z klientem po weryfikacji Bank
	$jest=0;
	$sqlCon="SELECT     idPakietu, dataHistoria, kontaktKlient
	FROM         DDhistoria
	WHERE     (idPakietu = $id) AND (kontaktKlient = 1)
	AND (dataHistoria > CONVERT(DATETIME, '$data', 102))";
	$qryCon=$db->query($sqlCon);
	while ($mem = $db->fetch_array($qryCon)) {
		$jest=1;
	}
	if($jest==0) $ileBankCon++; //jezeli nie ma kontaktu w historii
}

//ile przyjetych przez Bank
$sqlBankOk="SELECT id, statusBank FROM DDpakiety WHERE (statusBank = 1)";
$qryBankOk=$db->query($sqlBankOk);
$ileBankOk=$db->num_rows($qryBankOk);

//ile wprowadzonych dzisiaj na CC
$dataNow=date("Y-m-d");
$sqlCC="SELECT     id, source, dataWpisu
	FROM         DDpakiety
	WHERE     (dataWpisu >= CONVERT(DATETIME, '$dataNow', 102)) AND (source = 0)";
$qryCC=$db->query($sqlCC);
$ileCC=$db->num_rows($qryCC);

//ile wprowadzonych dzisiaj na Promo
$dataNow=date("Y-m-d");
$sqlPr="SELECT     id, source, dataWpisu
	FROM         DDpakiety
	WHERE     (dataWpisu >= CONVERT(DATETIME, '$dataNow', 102)) AND (source = 1)";
$qryPr=$db->query($sqlPr);
$ilePr=$db->num_rows($qryPr);

//ile wprowadzonych dzisiaj na 2L
$dataNow=date("Y-m-d");
$sql2L="SELECT     id, source, dataWpisu
	FROM         DDpakiety
	WHERE     (dataWpisu >= CONVERT(DATETIME, '$dataNow', 102)) AND (source > 1)";
$qry2L=$db->query($sql2L);
$ile2L=$db->num_rows($qry2L);

//ile razem BE
$sqlBE="SELECT     id AS EXPR1, statusBank AS EXPR2
	FROM         DDpakiety
	WHERE     (statusBank = 1)";
$qryBE=$db->query($sqlBE);
$ileBE=$db->num_rows($qryBE);

//**********************************************************************************
?>

<BR>

<TABLE cellspacing=0 cellpadding=0 border=0>
<TR>
<TD width=50 height=400></TD>
<TD width=350 height=400 valign='top'>

<P class='Big'><IMG src='./gfx/kropkaGrey.gif' align='middle'>&nbsp;&nbsp;<B>PAKIETY</B></P>
&nbsp;&nbsp;&nbsp;&nbsp;<IMG src='./gfx/kropkaRed.gif' align='middle'>&nbsp;&nbsp;<A href='dede.php?show=frmInput' class='Menu'>NOWA AKTYWACJA</A><BR>
&nbsp;&nbsp;&nbsp;&nbsp;<IMG src='./gfx/kropkaRed.gif' align='middle'>&nbsp;&nbsp;<A href='dede.php?show=browseByDate' class='Menu'>PRZEGLADAJ WSZYSTKIE</A><BR>
&nbsp;&nbsp;&nbsp;&nbsp;<IMG src='./gfx/kropkaRed.gif' align='middle'>&nbsp;&nbsp;<A href='dede.php?show=browse&go=sendForm' class='Menu'>WYSYLKA FORMULARZY</A><BR>
&nbsp;&nbsp;&nbsp;&nbsp;<IMG src='./gfx/kropkaRed.gif' align='middle'>&nbsp;&nbsp;<A href='dede.php?show=browse&go=sprTWW' class='Menu'>WERYFIKACJA FORMULARZY</A><BR>
&nbsp;&nbsp;&nbsp;&nbsp;<IMG src='./gfx/kropkaRed.gif' align='middle'>&nbsp;&nbsp;<A href='dede.php?show=bankRead'' class='Menu'>PLIK Z BANKU</A><BR>

<P class='Big'><IMG src='./gfx/kropkaGrey.gif' align='middle'>&nbsp;&nbsp;<B>KONTAKT Z KLIENTAMI</B></P>
&nbsp;&nbsp;&nbsp;&nbsp;<IMG src='./gfx/kropkaRed.gif' align='middle'>&nbsp;&nbsp;<A href='dede.php?show=browse&go=firstBad' class='Menu'>NEGATYWNA WERYFIKACJA TWW</A><BR>
&nbsp;&nbsp;&nbsp;&nbsp;<IMG src='./gfx/kropkaRed.gif' align='middle'>&nbsp;&nbsp;<A href='dede.php?show=browse&go=secondBad' class='Menu'>POZYTYWNA WERYFIKACJA BANK</A><BR>

<P class='Big'><IMG src='./gfx/kropkaGrey.gif' align='middle'>&nbsp;&nbsp;<B>KONTAKT Z TELE2</B></P>
&nbsp;&nbsp;&nbsp;&nbsp;<IMG src='./gfx/kropkaRed.gif' align='middle'>&nbsp;&nbsp;<A href='dede.php?show=frmSend7' class='Menu'>RAPORT ZALEGLOSCI Z BANKU</A><BR>

</TD>
<TD width=2 height=400 valign='top' background='./gfx/bgKreska.gif'></TD>
<TD width=10 height=400 valign='top'></TD>
<TD width=548 height=400 valign='top'>

<TABLE cellspacing=0 cellpadding=2>
<TR><TD class='Small' colspan='2'><U><B>Informacje o pakietach</B></U></TD></TR>
<TR><TD class='Small' colspan='2' height='20'></TD></TR>
<TR><TD class='Small' width=240>Wszystkich</TD><TD class='SmallWyr'><?php echo "$ileAll"; ?></TD></TR>
<TR><TD class='Small'>Czekajacych na wyslanie formularza</TD><TD class='SmallWyr'><?php echo "$ileForm"; ?></TD></TR>
<TR><TD class='Small'>Czekajacych na weryfikacje TWW</TD><TD class='SmallWyr'><?php echo "$ileWer"; ?></TD></TR>
<TR><TD class='Small'>Czekajacych na weryfikacje banku</TD><TD class='SmallWyr'><?php echo "$ileBank"; ?></TD></TR>
<TR><TD class='Small'>Odrzuconych przez bank razem</TD><TD class='SmallWyr'><?php echo "$ileBankGo"; ?></TD></TR>
<TR><TD class='Small'>Przyjetych przez bank i czekajacych na kontakt</TD><TD class='SmallWyr'><?php echo "$ileBankCon"; ?></TD></TR>
<TR><TD class='Small'>Przyjetych przez bank</TD><TD class='SmallWyr'><?php echo "$ileBankOk"; ?></TD></TR>
<TR><TD class='Small' colspan='2' height='20'></TD></TR>
<TR><TD class='Small'>Wprowadzonych dzisiaj na CC</TD><TD class='SmallWyr'><?php echo "$ileCC"; ?></TD></TR>
<TR><TD class='Small'>Wprowadzonych dzisiaj na Promo</TD><TD class='SmallWyr'><?php echo "$ilePr"; ?></TD></TR>
<TR><TD class='Small'>Wprowadzonych dzisiaj na 2L</TD><TD class='SmallWyr'><?php echo "$ile2L"; ?></TD></TR>
<TR><TD class='Small' colspan='2' height='20'></TD></TR>
<TR><TD class='Small'>BE razem</TD><TD class='SmallWyr'><?php echo "$ileBE"; ?></TD></TR>

</TABLE>

</TD>
</TR>
</TABLE>