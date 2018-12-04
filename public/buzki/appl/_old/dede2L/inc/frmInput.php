<?php
//jezeli nacisnieto przycisk DODAJ
if($poszlo==1) {
	//sprawdzmy, czy juz taka aktywacja jest wprowadzona
	$jest=0; //nie ma
	$sql="SELECT idKlient FROM DDpakiety WHERE idKlient='$idKlient' AND rachKlient='$rachKlient'";
	$query = $db->query($sql);
	while ($member = $db->fetch_array($query)) {
		$jest++;
	}
	if($jest>0) {
		echo "Przykro mi, ale aktywacja dla tego klienta zosta³a ju¿ wprowadzona do systemu!";
	} else {
		//nie ma, wiec dodajemy
		//dane automatyczne
		$dataWpisu=date("Y-m-d H:i");
		$operID=$xmbid;

		if($czyForm=="on") {
			$czyForm=1;
		} else {
			$czyForm=0;
		}
		
		//konwersja znaków PL
		$idKlient=corpol($idKlient);
		$nazwaKlient=corpol($nazwaKlient);
		$ulicaKlient=corpol($ulicaKlient);
		$miastoKlient=corpol($miastoKlient);
		$kodKlient=corpol($kodKlient);
		$rachKlient=corpol($rachKlient);
		$dataWpisu=corpol($dataWpisu);
		$operID=corpol($operID);
		$source=corpol($source);
		$czyForm=corpol($czyForm);

		//do DDpakiety
		//jezeli zostala wybrana weryfikacja
		if($sprTWW!=0) {
			$sql="INSERT INTO DDpakiety(idKlient, nazwaKlient, ulicaKlient, miastoKlient, kodKlient, rachKlient, dataWpisu, operID, source, czyForm, statusTWW, sprTWW) VALUES('$idKlient', '$nazwaKlient', '$ulicaKlient', '$miastoKlient', '$kodKlient', '$rachKlient', '$dataWpisu', '$operID', '$source', '$czyForm', '2', '$sprTWW')";
		} else {
			$sql="INSERT INTO DDpakiety(idKlient, nazwaKlient, ulicaKlient, miastoKlient, kodKlient, rachKlient, dataWpisu, operID, source, czyForm) VALUES('$idKlient', '$nazwaKlient', '$ulicaKlient', '$miastoKlient', '$kodKlient', '$rachKlient', '$dataWpisu', '$operID', '$source', '$czyForm')";
		}
		$db->query($sql);
		//idPakietu wprowadzonego powyzej
		$idPakietu=$db->insert_id();
		//do DDhistoria
		$sql="INSERT INTO DDhistoria(dataHistoria,idPakietu,idKlient, nazwaKlient, ulicaKlient, miastoKlient, kodKlient, rachKlient, dataWpisu, operID, source, czyForm) VALUES('$dataWpisu','$idPakietu','$idKlient', '$nazwaKlient', '$ulicaKlient', '$miastoKlient', '$kodKlient', '$rachKlient', '$dataWpisu', '$operID', '$source', '$czyForm')";
		$db->query($sql);
		//jezeli zostala wybrana weryfikacja
		if($sprTWW!=0) {
			$sql="INSERT INTO DDhistoria(dataHistoria,idPakietu,idKlient, nazwaKlient, ulicaKlient, miastoKlient, kodKlient, rachKlient, dataWpisu, operID, source, czyForm, statusTWW, sprTWW) VALUES('$dataWpisu','$idPakietu','$idKlient', '$nazwaKlient', '$ulicaKlient', '$miastoKlient', '$kodKlient', '$rachKlient', '$dataWpisu', '$operID', '$source', '$czyForm', '2', '$sprTWW')";
			$db->query($sql);
		}
	}
}
?>
<SCRIPT language='javascript'>

function onKeyPress () {
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13) {
		alert('Prosze nie uzywac klawisza ENTER.');
	return false
	}
	return true 
}

document.onkeypress = onKeyPress;

function checkForm () {
  var spr = 1;
  var warn = 0;
  var imieNazw = /^.{0,}\s{1,}.{0,}$/;
  var kod_p = /^[0-9]{2}[-]{1}[0-9]{3}$/;
  var tel = /^[1-9]{1}[0-9]{8}$/;
  var c_id = /^\d{11}$/
  var rach = /^[0-9]{26}$/;

  if ( document.frmInput.idKlient.value == '')
  {
    alert ('Musisz wpisac ID klienta!');
    document.frmInput.idKlient.focus();
    spr=0;
  }
  else if ( document.frmInput.nazwaKlient.value == '')
  {
    alert ('Musisz wpisac imie i nazwisko klienta lub nazwe firmy!\\nJezeli jest to klient biznesowy i nie znasz imienia i nazwiska klienta, postaw znak odstepu [Spacja]');
    document.frmInput.nazwaKlient.focus();
    spr=0;
  }
  else if ( document.frmInput.ulicaKlient.value == '')
  {
    alert ('Musisz wpisac ulice!');
    document.frmInput.ulicaKlient.focus();
    spr=0;
  }
  else if ( document.frmInput.miastoKlient.value == '')
  {
    alert ('Musisz wpisac miasto!');
    document.frmInput.miastoKlient.focus();
    spr=0;
  }
  else if ( document.frmInput.kodKlient.value == '')
  {
    alert ('Musisz wpisac kod pocztowy!');
    document.frmInput.kodKlient.focus();
    spr=0;
  }
  else if (!c_id.test(document.frmInput.idKlient.value)) {
    alert ('ID klienta musi byc 11-cyfrowa liczba!');
    document.frmInput.idKlient.focus();
    spr=0;
  }
  else if (document.frmInput.rachKlient.value != '' && !rach.test(document.frmInput.rachKlient.value)) {
    alert ('Numer rachunku klienta musi zawierac 26-cyfr! Je¿eli jest nieprawidlowy pozostaw pole puste.');
    document.frmInput.rachKlient.focus();
    spr=0;
  }
  else if (!kod_p.test(document.frmInput.kodKlient.value)) {
    alert ('Kod pocztowy klienta musi byc formatu 00-000');
    document.frmInput.kodKlient.focus();
    spr=0;
  }
  if (spr==1) {
    document.frmInput.submit();
  }
}
</SCRIPT>


<CENTER>
<P align='center' class='Big'><B>Dodawanie nowej aktywacji DD</B></P>
</CENTER>
<TABLE cellspacing=0 cellpadding=2>
<FORM action='dede.php?show=frmInput' method='post' name='frmInput'>
<TR class='trForm'>
<TD width=50></TD>
<TD>Zrodlo</TD>
<TD>
<SELECT name='source'>
<?php
$sql="SELECT idSource, nazwaSource, formSource FROM DDsource";
$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idS = $member['idSource'];
	$nazwaS = $member['nazwaSource'];
	$formS = $member['formSource'];
	
	echo "<OPTION value='$idS'>$nazwaS [$formS]</OPTION>";
}
?>
</SELECT>
</TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>ID Klienta</TD>
<TD><INPUT name='idKlient' type='text'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Nr rachunku bankowego</TD>
<TD><INPUT name='rachKlient' type='text'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Nazwa Klienta</TD>
<TD><INPUT name='nazwaKlient' type='text'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Ulica</TD>
<TD><INPUT name='ulicaKlient' type='text'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Miasto</TD>
<TD><INPUT name='miastoKlient' type='text'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Kod pocztowy</TD>
<TD><INPUT name='kodKlient' type='text'></TD>
</TR>
<TR class='trForm'>
<TD></TD>
<TD>Klient chce formularz</TD>
<TD><INPUT name='czyForm' type='checkbox'></TD>
</TR>

<TR class='trForm'>
<TD></TD>
<TD>Weryfikuj</TD>
<TD><A href='#' onclick="Pokaz( 'divWeryf' )"><IMG src='gfx/plusik.gif' border='0' valign='middle'></A></TD>
</TR>

<TR class='trForm' id='divWeryf' STYLE="display: none">
<TD></TD>
<TD></TD>
<TD>
<SELECT name='sprTWW'>
<?php
$sql="SELECT idWeryf, nazwaWeryf FROM DDweryfikacje ORDER BY nazwaWeryf";
$query = $db->query($sql);
while ($member = $db->fetch_array($query)) {
	$idWeryf = $member['idWeryf'];
	$nazwaWeryf = corpol_rev($member['nazwaWeryf']);
	
	echo "<OPTION value='$idWeryf'";
	if($idWeryf==$sprTWW) echo " selected";
	echo ">$nazwaWeryf</OPTION>";
}
?>
</SELECT>
</TD>
</TR>

<TR>
<TD></TD>
<TD></TD>
<TD>
<INPUT type='hidden' name='poszlo' value='1'>
<INPUT name='submitInsert' type='button' value='DODAJ' onClick='checkForm()'>
</TD>
</TR>
</FORM>
</TABLE>
