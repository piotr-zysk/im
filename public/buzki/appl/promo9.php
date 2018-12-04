<?php
include "../../lib/tww.inc";

start_html('#eeeeff','css/main.css','Oferty Tele2');

function allowed($id)
{
$uprawnione_loginy=array(1 => "1", "28", "837", "1583", "1127", "3286", "1526"); // oper_id uzytkownikow ktorzy moga edytowac plany taryfowe dostepne w aplikacji

if (in_array($id,$uprawnione_loginy)) $f_return=True;
else $f_return=False;

return $f_return;  
}

function kreski()
{
echo '---------------------------------------------------------------------------------------------<BR>';
return 1;
}


function decode($tekst)
{

if ($tekst == 'DWIW35') $tekst2='DWIW35';
elseif ($tekst == 'Residential_Preselect_Seconds') $tekst2='Plan sekundowy dla klientow indywidualnych';
elseif ($tekst == 'Residential_Preselect') $tekst2='Standardowy plan impulsowy dla klientow indywidualnych';
elseif ($tekst == 'LOJAL') $tekst2='Pakiet Darmowe Soboty przez Caly Rok';
elseif ($tekst == 'rez_DWIW_RP') $tekst2='Rezygnacja z DWIW i aktywacja Standardowego planu impulsowego (zgloszenie przyjmowac do 3-ech dni roboczych przed koncem m-ca, nowy plan aktywny od nastepnego m-ca)';
elseif ($tekst == 'rez_DWIW_RPS') $tekst2='Rezygnacja z DWIW i aktywacja Planu sekundowego (zgloszenie przyjmowac do 3-ech dni roboczych przed koncem m-ca, nowy plan aktywny od nastepnego m-ca)';
elseif ($tekst == 'rez_DWIW_LOJAL') $tekst2='Rezygnacja z DWiW i aktywacja Pakietu Darmowe Soboty przez 12 m-cy';
elseif ($tekst == 'rez_LOJAL_RPS') $tekst2='Rezygnacja z pakietu Darmowe Soboty przez Caly Rok i aktywacja Planu sekundowego';
elseif ($tekst == 'rez_LOJAL_DWIW') $tekst2='Rezygnacja z pakietu Darmowe Soboty przez Caly Rok i aktywacja DWIW 35 - tylko rezygnacje z umowy w przeciagu 10-dni';
elseif ($tekst == 'DD') $tekst2='Aktywacja DIRECT DEBIT';
elseif ($tekst == 'promo') $tekst2='Promo';
elseif ($tekst == 'wbt') $tekst2='WBT';
elseif ($tekst == 'cc') $tekst2='Up&cross-Sale (Customer Care)';
elseif ($tekst == 'PRIV') $tekst2='Pakiety dla klienta indywidualnego';
elseif ($tekst == 'BIZ') $tekst2='Pakiety dla klienta korporacyjnego';
elseif ($tekst == 'Business_Preselect') $tekst2='Cennik Preselekcji T2 (standardowy)';
elseif ($tekst == 'Business_Wspol_Nieozn') $tekst2='WSB - Umowa na czas nieoznaczony';
elseif ($tekst == 'Business_Wspol_12mies') $tekst2='WSB - Umowa na czas 12 miesiecy z darmowym bilingiem';
elseif ($tekst == 'Business_Opt_Nieozn') $tekst2='OB - Umowa na czas nieoznaczony';
elseif ($tekst == 'Business_Opt_12mies') $tekst2='OB - Umowa na czas 12 miesiecy z darmowym bilingiem';
elseif ($tekst == 'Business_Wspol_Premium_Nieozn') $tekst2='WSBP - Umowa na czas nieoznaczony';
elseif ($tekst == 'Business_Wspol_12mies_30min') $tekst2='WSBP - Umowa na czas 12 miesiecy z darmowym bilingiem i rabatem "30 minut darmowych polaczen lokalnych i miedzymisatowych"';
elseif ($tekst == 'Business_Wspol_12mies_100min') $tekst2='WSBP - Umowa na czas 12 miesiecy z darmowym bilingiem i rabatem "100 minut darmowych polaczen lokalnych i miedzymisatowych" (klient deklaruje, ze wysokosc rachunkow telefonicznych w T2 wynosic bedzie co najmniej 115 zl netto miesiecznie)';
elseif ($tekst == 'rez_LOJAL_DWIW35_do2miesWBT') $tekst2='Rezygnacja z pakietu Darmowe Soboty przez Caly Rok na DWIW 35 (umowa zawarta < niz 2 miesiace od daty rozmowy na WBT)';
elseif ($tekst == 'rez_LOJAL_RPS_do10dni') $tekst2='Rezygnacja z pakietu Darmowe Soboty przez Caly Rok i aktywacja planu sekundowego (tylko rezygnacje z umowy w przeciagu 10 dni)';
elseif ($tekst == 'rez_LOJAL_RP_do10dni') $tekst2='Rezygnacja z pakietu Darmowe Soboty przez Caly Rok i aktywacja planu impulsowego (tylko rezygnacje z umowy w przeciagu 10 dni)';
elseif ($tekst == 'Godzina_gratis_1h') $tekst2='1 Godzina gratis';
elseif ($tekst == 'Godzina_gratis_2h') $tekst2='2 Godziny gratis';
elseif ($tekst == 'Godzina_gratis_3h') $tekst2='3 Godziny gratis';
elseif ($tekst == 'Poczta_12_m-cy') $tekst2='Rekompensata pocztowa na 12 m-cy';
elseif ($tekst == 'Poczta_Nieoznaczony') $tekst2='Rekompensata pocztowa na czas nieokreslony';
elseif ($tekst == '3:60_min_gratis') $tekst2='Cykliczna godzina gratis na 3 miesiace';
elseif ($tekst == '6:60_min_gratis') $tekst2='Cykliczna godzina gratis na 6 miesiecy';
elseif ($tekst == '12:60_min_gratis') $tekst2='Cykliczna godzina gratis na 12 miesiecy';
elseif ($tekst == 'Rez_lojal_12:60_gratis') $tekst2='Zamiana lojalki z darmowych sobot na lojalke z cykliczna godzina gratis na 12 m-cy';
elseif ($tekst == 'GratWBT') $tekst2='Gratyfikacje dla WBT';
elseif ($tekst == 'Gratis') $tekst2='Gratis jednorazowy T2';
elseif ($tekst == 'gocykl') $tekst2='Godzina cykliczna gratis T2';
elseif ($tekst == 'poczta') $tekst2='Rekompensata oplaty pocztowej';
elseif ($tekst == '20na3') $tekst2='20 minut na lokalne i miedzymiastowe na 3 miesiace';
elseif ($tekst == '20na6') $tekst2='Znizka 20% na 6 miesiecy';
elseif ($tekst == '30na6') $tekst2='Znizka 30% na 6 miesiecy';
else $tekst2=$tekst;

return $tekst2;
}



//skrypcik sprawdzajacy poprawnosc wpisow do formularza
echo "
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


function sprName(name) {
	var i;
	var listaImion='';
	var imiona = ['Bartlomiej','Bogumil','Boguslaw','Boleslaw','Bronislaw','Czeslaw','Jaroslaw','Jedrzej','Ludomil','Lukasz','Michal','Mieczyslaw','Mikolaj','Milosz','Miroslaw','Pawel','Radomil','Radoslaw','Stanislaw','Slawomir','Wieslaw','Wladyslaw','Wlodzimierz','Zdzislaw','Bozena','Elzbieta','Grazyna','Lucja','Malgorzata','Slawa'];
	var wlk = imiona.length;
	for(i=0; i<wlk; i++) {
		if(name.indexOf(imiona[i]) != -1) {
			listaImion = listaImion + ' ' + imiona[i];
		}
	}
	return listaImion;
}

function sprCity(miasto) {
	var i;
	var listaMiast='';
	var miasta = ['Aleksandrow','Augustow','Belchatow','Belchatów','Be³chatow','Bedzin','Biala','Bialogard','Bialy','Biezun','Boleslawiec','Bolkow','Bor','Bytow','Chelm','Chocianow','Chojnow','Chorzow','Ciechanow','Czeladz','Czestochowa','Czluchow','Dabrowa','Deba','Deblin','Debno','Dzialdowo','Dzierzoniow','Elblag','Elk','Gdansk','Gizycko','Glogow','Glowno','Golub-Dobrzyn','Goldap','Gorzow','Gorna','Gornicza','Grudziadz','Ilawa','Ilza','Inowroclaw','Jaroslaw','Jaslo','Lezajsk','Jastrzebie','Jozefow','Kamien','Kedzierzyn-Kozle','Kêdzierzyn-Kozle','Kepice','Kepno','Klodzko','Kolo','Kolobrzeg','Koscian','Kozmin','Kornik','Krajenskie','Krakow','Krasnik','Ksiaz','Lebork','Lubaczow','Luban','Lubartow','Laskarzew','Leba','Lobez','Lomza','Losice','Lowicz','Lodz','Lódz','£ódz','LodŸ','Lukow','Miedzylesie','Miedzyrzec','Miedzyzdroje','Milanowek','Minsk','Mlawa','Morag','Mszczonow','Myslowice','Myszkow','Myslenice','Naklo','Niepolomice','Odolanow','Olesnica','Ostroleka','Ostroda','Ostrow','Ostrzeszow','Oswiecim','Oœwiecim','Oswiêcim','Piastow','Pila','Pilawa','Piotrkow','Plock','Plonsk','P³onsk','Ploñsk','Polaniec','Poznan','Przemysl','Pulawy','Raciborz','Radzyn','Rogozno','Rzeszow','Sacz','Sepolno','Sierakow','Skarzysko','Skoczow','Slubice','Slupsk','Sokolow','Sokolka','Sol','Sulejowek','Sulecin','Suwalki','Swarzedz','Sycow','Szamotuly','Szczecinski','Slask','Sl¹sk','Œlask','Slesin','Swidnica','Swidnik','Swiecie','Swietochlowice','Swietokrzyski','Swinoujscie','Œwinoujscie','Swinoujœcie','Tarnow','Tluszcz','Tomaszow','Tomysl','Torun','Ustron','Walbrzych','Wabrzezno','W¹brzezno','WabrzeŸno','Wagrowiec','Wegrow','Wieruszow','Wiecbork','Wloclawek','W³oclawek','Wloc³awek','Wolomin','Wrzesnia','Zambrow','Zabki','Zbaszynek','Zdroj','Zdunska','Zelow','Ziebice','Zlocieniec','Zlotoryja','Zlotow','Zagan','Zerkow','Zmigrod','Znin','Zory','Zyrardow','¯yrardow','Zyrardów','Zywiec'];
	var wlk = miasta.length;
	for(i=0; i<wlk; i++) {
		if(miasto.indexOf(miasta[i]) != -1) {
			listaMiast = listaMiast + ' ' + miasta[i];
		}
	}
	return listaMiast;
}

function sprStr(ulica) {
	var i;
	var listaUlic='';
	var ulice = ['Pawla','Kosciuszki','Zrodlo','rodlo','Zródlo','Pulku','Niepodleglosci','Wyszynskiego','Zwyciestwa','Baltycka','Boguslaw','Bochaterow','Boleslawa','Chlopska','Chlopow','Cieszynskiego','Darbowszczakow','Dabrowskiego','Slowianska','Daszynskiego','Dluga','Galczynskiego','Gdanska','Gdynska','Jagielly','Raclawicka','Lesna','Obroncow','Powstancow','Zlotego','Wladyslawa','Boleslawa','Pilsudskiego','Zolnierska','Sklodowskiej','Tysiaclecia','Wolnosci','Wyspianskiego','Zeromskiego','Zwyciestwa','Slowackiego'];
	var wlk = ulice.length;
	for(i=0; i<wlk; i++) {
		if(ulica.indexOf(ulice[i]) != -1) {
			listaUlic = listaUlic + ' ' + ulice[i];
		}
	}
	return listaUlic;
}

function checkForm () {
  var spr = 1;
  var warn = 0;
  var imieNazw = /^.{0,}\s{1,}.{0,}$/;
  var kod_p = /^[0-9]{2}[-]{1}[0-9]{3}$/;
  var tel = /^[1-9]{1}[0-9]{8}$/;
  var c_id = /^\d{11}$/

if(document.stage2.idKlient) {
  if ( document.stage2.idKlient.value == '')
  {
    alert ('Musisz wpisac ID klienta!');
    document.stage2.idKlient.focus();
    spr=0;
  }
  else if ( document.stage2.nazwaKlient.value == '')
  {
    alert ('Musisz wpisac imie i nazwisko klienta lub nazwe firmy!\\nJezeli jest to klient biznesowy i nie znasz imienia i nazwiska klienta, postaw znak odstepu [Spacja]');
    document.stage2.nazwaKlient.focus();
    spr=0;
  }
  else if ( document.stage2.ulicaKlient.value == '')
  {
    alert ('Musisz wpisac ulice!');
    document.stage2.ulicaKlient.focus();
    spr=0;
  }
  else if ( document.stage2.miastoKlient.value == '')
  {
    alert ('Musisz wpisac miasto!');
    document.stage2.miastoKlient.focus();
    spr=0;
  }
  else if ( document.stage2.kodKlient.value == '')
  {
    alert ('Musisz wpisac kod pocztowy!');
    document.stage2.kodKlient.focus();
    spr=0;
  }
  else if (!c_id.test(document.stage2.idKlient.value)) {
    alert ('ID klienta musi byc 11-cyfrowa liczba!');
    document.stage2.idKlient.focus();
    spr=0;
  }
  else if (!kod_p.test(document.stage2.kodKlient.value)) {
    alert ('Kod pocztowy klienta musi byc formatu 00-000');
    document.stage2.kodKlient.focus();
    spr=0;
  }

} else {

  if ( document.stage2.cust_id.value == '')
  {
    alert ('Musisz wpisac ID klienta!');
    document.stage2.cust_id.focus();
    spr=0;
  }
  else if ( document.stage2.nr_tel.value == '')
  {
    alert ('Musisz wpisac numer telefonu klienta!');
    document.stage2.nr_tel.focus();
    spr=0;
  }
  else if ( document.stage2.name.value == '')
  {
    alert ('Musisz wpisac imie i nazwisko klienta!\\nJezeli jest to klient biznesowy i nie znasz imienia i nazwiska klienta, postaw znak odstepu [Spacja]');
    document.stage2.name.focus();
    spr=0;
  }
    else if ( document.stage2.ulica.value == '')
  {
    alert ('Musisz wpisac ulice!');
    document.stage2.ulica.focus();
    spr=0;
  }
  else if ( document.stage2.kod.value == '')
  {
    alert ('Musisz wpisac kod pocztowy klienta!');
    document.stage2.kod.focus();
    spr=0;
  }
  else if ( document.stage2.miasto.value == '')
  {
    alert ('Musisz wpisac miasto!');
    document.stage2.miasto.focus();
    spr=0;
  }
    else if (!kod_p.test(document.stage2.kod.value)) {
    alert ('Kod pocztowy klienta musi byc formatu 00-000');
    document.stage2.kod.focus();
    spr=0;
  }
  else if (!c_id.test(document.stage2.cust_id.value)) {
    alert ('ID klienta musi byc 11-cyfrowa liczba!');
    document.stage2.c_id.focus();
    spr=0;
  }
  else if (!tel.test(document.stage2.nr_tel.value)) {
    alert ('Numer telefonu klienta musi byc 9-cyfrowa liczba bez zera na poczaktu!');
    document.stage2.nr_tel.focus();
    spr=0;
  }
  else if (!imieNazw.test(document.stage2.name.value)) {
    alert ('Bledne imie i nazwisko: Rozdziel spacja imie i nazwisko!');
    document.stage2.name.focus();
    spr=0;
  }
  if ( sprName(document.stage2.name.value) != '')
  {
    badName = sprName(document.stage2.name.value);
      if( confirm('Ostrzezenie, pole IMIE I NAZWISKO!\\nProsze o uzywanie polskich znakow dialektycznych.\\nPrawdopodobny blad w wyrazie: ' + badName + '\\n\\nCzy chcesz poprawic ten wyraz?') ) {
        document.stage2.name.focus();
        spr=0;
      }
  }
}
  if (spr==1) {
    document.stage2.submit();
  }
}
</SCRIPT>
";

//checkpoint
if ($stage==1)
{
$blad=check_if_exists($source,$blad,'Musisz wybrac infolinie');
$blad=check_if_exists($produkt_pre,$blad,'Musisz wybrac produkt');
if ((!$blad) and ($produkt_pre=='DD'))
		{
		$stage=$stage+1;
		$produkt=$produkt_pre;
		}
}
if ($stage==2)
{
$blad=check_if_exists($produkt,$blad,'Musisz wybrac produkt');
}
if ($stage==3)
{
$blad=check_if_exists($wybor,$blad,'Musisz wybrac rezultat rozmowy');
$blad=check_if_exists($cust_id,$blad,'Musisz wpisac ID klienta');
$blad=check_if_exists($nr_tel,$blad,'Musisz wpisac numer telefonu klienta');
if ($source<>'wbt') $blad=check_if_exists(($wybor<>'zastanawia sie'),$blad,'Mozesz wybrac "zastanawia sie" tylko w przypadku WBT');

if (($wybor=='aktywacja_35') or ($wybor=='aktywacja_35_block') or ($produkt=='LOJAL') or ($wybor=='aktywacja_lojal_block'))
	{
		$blad=check_if_exists($name,$blad,'Przy aktywacji musisz wpisac imie i nazwisko klienta');
		//$blad=check_if_exists($ulica,$blad,'Przy aktywacji musisz wpisac adres klienta');
		//$blad=check_if_exists($kod,$blad,'Przy aktywacji musisz wpisac kod pocztowy klienta');
		//$blad=check_if_exists($miasto,$blad,'Przy aktywacji musisz wpisac miejscowosc zamieszkania klienta');
	}
}

if (!$blad) $stage=$stage+1;

if (($oper) and (!$stage)) $stage=1;
elseif (!$oper)
	{
	echo '<BR><B>Aplikacja zostala uruchomiona w nieprawidlowy sposob</B>';
	exit;
	}


if ($stage==1)
{
	include "promo/stage1.inc";

}

if ($stage==2)
{
	include "promo/stage2.inc";

}

if ($stage==3)
{
	include "promo/stage3.inc";
}
if ($stage==999)
{
	include "promo/stage999.inc"; // admin
}
elseif ($stage==4)
{
	mssql_connect("trpool2","sa","trpool2");
	mssql_select_db("intranet");
	


//nowe rzeczy
if($idKlient) {
	//echo "ze niby bedziemy dodawac DD";
	//sprawdzmy, czy juz taka aktywacja jest wprowadzona
	$jest=0; //nie ma
	$sql="SELECT idKlient FROM DDpakiety WHERE idKlient='$idKlient' AND rachKlient='$rachKlient'";
	$query = $db->query($sql);
	while ($member = $db->fetch_array($query)) {
		$jest++;
	}
	if($jest>0) {
		echo "
		Przykro mi, ale aktywacja dla tego klienta zostala juz wprowadzona do systemu!<BR>
		<a href='?oper=$oper'>OK</a>
		";
	} else {
		//echo "<BR>i niby nie ma takiej aktywacji...";
		//nie ma, wiec dodajemy
		//dane automatyczne
		$dataWpisu=date("Y-m-d H:i");
		$operID=$xmbid;

		if($czyForm!="") {
			$czyForm=1;
		} else {
			$czyForm=0;
		}

		//echo "<BR>$source";

		if($source=="cc") {
			$source=0;
		}		
		elseif($source=="promo") {
			$source=1;
		}
		elseif($source=="wbt") {
			$source=2;
		}

		//echo "<BR>$source";

		$nazwaKlient=corpol($nazwaKlient);
		$ulicaKlient=corpol($ulicaKlient);
		$miastoKlient=corpol($miastoKlient);

		//do DDpakiety
		//echo "INSERT INTO DDpakiety(idKlient, nazwaKlient, ulicaKlient, miastoKlient, kodKlient, rachKlient, dataWpisu, operID, source, czyForm) VALUES('$idKlient', '$nazwaKlient', '$ulicaKlient', '$miastoKlient', '$kodKlient', '$rachKlient', '$dataWpisu', '$operID', '$source', '$czyForm')";
		$query = mssql_query("INSERT INTO DDpakiety(idKlient, nazwaKlient, ulicaKlient, miastoKlient, kodKlient, dataWpisu, operID, source, czyForm) VALUES('$idKlient', '$nazwaKlient', '$ulicaKlient', '$miastoKlient', '$kodKlient', '$dataWpisu', '$operID', '$source', '$czyForm')")
		or die("blad SQL");
		
		//idPakietu wprowadzonego powyzej
		$idPakietu=$db->insert_id();
		//echo "$idPakietu";
		//do DDhistoria
		$query = mssql_query("INSERT INTO DDhistoria(dataHistoria, idPakietu, idKlient, nazwaKlient, ulicaKlient, miastoKlient, kodKlient, dataWpisu, operID, source, czyForm) VALUES('$dataWpisu','$idPakietu','$idKlient', '$nazwaKlient', '$ulicaKlient', '$miastoKlient', '$kodKlient', '$dataWpisu', '$operID', '$source', '$czyForm')")
		or die("blad SQL");


			echo "<HR>Dane zostaly zapisane<HR><br>";
		?>
		<a href="?action=forma">OK</a>
		  <script>
		  function redirect()
		  {
		  window.location.replace("?oper=<?php=@$oper?>");
		  }
		  setTimeout("redirect();", 1000);
		  </script>
		<?php
	}
} else {
//stare rzeczy
	$name=corpol($name);
	$ulica=corpol($ulica);
	$miasto=corpol($miasto);
	$firma=corpol($firma);	

	$data=strftime("%Y-%m-%d");
	$czas=strftime("%H:%M:%S");
	
	$query = mssql_query("INSERT INTO callregistry_promo (cust_id, nr_tel, name, firma, ulica, kod, miasto, produkt, wybor, source, duedate, oper_id, oper, data, czas, kiedy) VALUES ('$cust_id', '$nr_tel', '$name', '$firma', '$ulica', '$kod', '$miasto', '$produkt', '$wybor', '$source', '$duedate', '$xmbid', '$oper', '$data', '$czas', '$kiedy')")
	or die("INSERT INTO callregistry_promo (cust_id, nr_tel, name, ulica, kod, miasto, produkt, wybor, source, duedate, oper_id, oper, data, czas, kiedy) VALUES ('$cust_id', '$nr_tel', '$name', '$ulica', '$kod', '$miasto', '$produkt', '$wybor', '$source', '$duedate', '$xmbid', '$oper', '$data', '$czas', '$kiedy')");
	
	
	echo "<HR>Dane zostaly zapisane<HR><br>";
	?>
	<a href="?action=forma">OK</a>
	  <script>
	  function redirect()
	  {
	  window.location.replace("?oper=<?php=@$oper?>");
	  }
	  setTimeout("redirect();", 1000);
	  </script>
	<?php
}

}

end_html();
?>