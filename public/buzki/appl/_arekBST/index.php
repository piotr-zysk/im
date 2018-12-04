<?php

include("../../../lib/tww.inc");
include("./inc/functions.php");

//poziom uprawnien
$xmbid=$_COOKIE["xmbid"];
$xmblevel=$_COOKIE["xmblevel"];
$kod=$_GET['kod'];

// lista uzytkownikow, ktorzy moga miec dostep do aplikacji (przeszkoleni na nowy skill Customer Care Netia)
$userzy=array(
	168,
	1015,
	1380,
	1452,
	1496,
	1591,
	1599,
	1779,
	2106,
	2280,
	2364,
	2368,
	2454,
	2465,
	2494,
	2533,
	2549,
	2565,
	2613,
	2641,
	2680,
	2713,
	2831,
	2871,
	2924,
	2945,
	3000,
	3018,
	3064,
	3080,
	3174,
	3284,
	3321,
	3401,
	3407,
	3444,
	3452,
	3473,
	3562,
	3569,
	3578,
	3583,
	3585,
	3590,
	3667,
	3704,
	3724,
	3734,
	3771,
	3777,
	3808,
	3817,
	3917,
	3920,
	3963,
	4172,
	4176,
	4182,
	4196,
	4203
);

// sprwadzenie czy user moze korzytac z aplikacji - okresleni agenci z tabeli powyzej + TL i starsi stopniem
if (!in_array($xmbid, $userzy) && ($xmblevel < 20)) {
	die('Brak uprawnien do korzystana z aplikacji. Skontaktuj sie ze swoim Team Leaderem');
}


// jezeli byl zapodaj z formularza to generuj kod i przierowuj z nim w gecie, ejzeli nie wyswietla inicjujaca strone
if ($_POST['zapodaj'] == 1) {

// wyciagniecie nowego kodu
$sql_wyciaganie_kodu="SELECT MIN(kod) FROM netia_kody_umow WHERE agent=0 AND data IS NULL";
$sql_wynik=$db->select($sql_wyciaganie_kodu);
$nowy_kod=$sql_wynik[0][0];

// zaklepanie kodu 
$sql_zaklepanie_kodu="UPDATE netia_kody_umow SET agent=$xmbid, data='".date('Y-m-d H:i:s')."', rodzaj='".$_POST['rodzaj']."' WHERE kod='$nowy_kod'";
$db->query($sql_zaklepanie_kodu);

// przekierowanie z kodem na strone glowna 
header('Location: index.php?kod='.$nowy_kod);

} else {

echo '
<HTML><HEAD>
<TITLE>Generowanie kodow umow</TITLE>

<script language="javascript">
function zapodawaj() {

	var czek=1;

	if(document.formularz_zapodawania_kodu.rodzaj.value == ''){
		alert("Wybierz rodzaj uslugi");
		czek=0;		
	}
	
	if(confirm("Czy na pewno chcesz wygenerowac kod umowy (dokonales sprzedazy)?")) {
		czek=1;
	}
	
	if( czek == 1 ){
		document.formularz_zapodawania_kodu.submit();
	}
	
}
</script>
</HEAD>
<BODY>
';


if ($kod <> '') {
// jezeli byl wygenerowany wyswietla kod agentowi
	echo 'Kod wygenerowany '.date('Y-m-d H:i:s').'. Prosze skopiowac numer umowy: '.$kod.'<br>';
} else {
// jezeli nie wyswietl instrukcje kiedy uzyc kodu
	echo 'Po dokonanku sprzedazy prosze wygenerowac kod guzikiem ponizej.<br>';
}

echo '
<form name="formularz_zapodawania_kodu" method="post">
<select name="rodzaj">
	<option value=""> - wybierz - </option>
	<option value="usluga glosowa">usluga glosowa</option>
	<option value="internet">internet</option>	
</select>
<input type="button" name="akcja" value="Generuj Nowy Kod" onclick="zapodawaj();" />
<input type="hidden" name="zapodaj" value="1" />
</form>

</BODY>
</HTML>
';
}


?>