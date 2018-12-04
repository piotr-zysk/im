<SCRIPT language='javascript'>
function Pokaz( co ) { 
	if (document.getElementById( co ).style.display == 'none') {
		document.getElementById( co ).style.display = 'block';
	} else {
		document.getElementById( co ).style.display = 'none';
	}
}
</script>

<?php
//zmienia miesiac slownie 3 literowy na liczbowy
function s2m ( $s ) {
	$m="00";
	if($s=="Jan") $m="01";
	if($s=="Feb") $m="02";
	if($s=="Mar") $m="03";
	if($s=="Apr") $m="04";
	if($s=="May") $m="05";
	if($s=="Jun") $m="06";
	if($s=="Jul") $m="07";
	if($s=="Aug") $m="08";
	if($s=="Sep") $m="09";
	if($s=="Oct") $m="10";
	if($s=="Nov") $m="11";
	if($s=="Dec") $m="12";
	return $m;
}
//zamienia short date z mssql na Y-m-d
function ms2normal( $date ) {
	$dateTab=explode(" ", $date);
	$newDate=$dateTab[2] . "-" . s2m($dateTab[0]) . "-" . $dateTab[1];
	return $newDate;
}
//zwraca jutrzejsza date w formacie Y-m-d
function jutro() {
	$date = mktime (0,0,0,date("m")  ,date("d")+1,date("Y"));
	$date=date("Y-m-d",$date);
	return $date;
}
//sprawdza, czy dzisiaj wysylka
function czyWysylka() {
	return 0;
}

//ustawia rekordy w kolejce do wyslania PISMA 2 (czyPismo2 z 0 na 1) <-- nie trzeba.. raczej przy ostatniej wysylce
function czyPismo2() {
	return 0;
}

//zwraca date sprzed 7 dni
function minus7() {
	$date = mktime (0,0,0,date("m")  ,date("d")-7,date("Y"));
	$date=date("Y-m-d",$date);
	return $date;
}

//zwraca date sprzed 3 dni
function minus3() {
	$date = mktime (0,0,0,date("m")  ,date("d")-3,date("Y"));
	$date=date("Y-m-d",$date);
	return $date;
}
?>