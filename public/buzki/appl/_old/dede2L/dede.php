<?php
include("../../../lib/tww.inc");
include("./inc/functions.php");
//skad przybywam i gdzie jestem
$url=$_SERVER['QUERY_STRING'];
$url_from_caly=$_SERVER['HTTP_REFERER'];
$url_from_pociety=explode("?", $url_from_caly);
$url_from=$url_from_pociety[1];
//print("aktualny: $url<br>przychodze z: $url_from");

//poziom uprawnien
$xmbid=$_COOKIE["xmbid"];
$xmblevel=$_COOKIE["xmblevel"];

function uprawnienia() {
	$pozMin=90;
	$xmbid=$_COOKIE["xmbid"];
	$xmblevel=$_COOKIE["xmblevel"];
	if($xmblevel>=$pozMin || $xmbid==510 || $xmbid==243 || $xmbid==614 || $xmbid==349 || $xmbid==490) {
		return 1;
	} else {
		return 0;
	}
}

//pobranie winlogin
$query = $db->query("SELECT winlogin FROM tab_users WHERE id='$xmbid'");
while ($member = $db->fetch_array($query))
	{
	$winlogin = $member['winlogin'];
	}

//poczatek strony
//<script language='JavaScript' src='./lib/simplecalendar.js' type='text/javascript'></script>
echo "
<HTML><HEAD>
<TITLE>DEDE</TITLE>
	<meta name=\"robots\" content=\"index, follow\">
	<META HTTP-EQUIV=\"content-type\" CONTENT=\"text/html; charset=iso-8859-2\">
	<meta http-equiv=\"Content-Language\" content=\"pl\">
	<meta http-equiv=\"pragma\" content=\"no-cache\">
	<base target=\"_self\">
	<link rel=\"stylesheet\" type=\"text/css\" href='css/main2.css'>
	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/calendar.css\">

	<SCRIPT language='javascript'>
	function goUrl( url ) {
		window.location.replace( url );
		return 0;
	}
	</SCRIPT>
	
</HEAD>
<BODY>
<CENTER>

";

if(uprawnienia()==1) {

echo "
<TABLE name='top'><TR><TD class='body_table'>

<TABLE cellspacing=0 cellpadding=2 border=0 background='./gfx/logoDD.jpg'>
<TR><TD width='980' height='100'></TD></TR>
</TABLE>

<TABLE cellspacing=0 cellpadding=2 border=0 class='trMenu'>
<TR class='trMenu'><TD width=580><B>Menu: </B>
";
if($winlogin=="") {
	echo "Aby kozystac z aplikacji, musisz byc zalogowany w intranecie!";
} else {
	//modul strony srodkowej
	if(isset($top)) {
		if(file_exists("./inc/".$top.".php")){
    			$plik = "./inc/".$top.".php";
    			include($plik);
    		}else{
    			print("blad!");
    		}
	} else {
		include("inc/menuTop.php");
	}

}
echo "
</TD><TD align='right' width=400>
";
include("inc/frmSearch.php");
echo "
</TD></TR>
</TABLE>

";
if($winlogin=="") {
	echo "Aby kozystac z aplikacji, musisz byc zalogowany w intranecie!";
} else {
	//modul strony srodkowej
	if(isset($show)) {
		if(file_exists("./inc/".$show.".php")){
    			$plik = "./inc/".$show.".php";
    			include($plik);
    		}else{
    			print("blad!");
    		}
	} else {
		include("inc/home.php");
	}

}
echo "
</TD></TR>

<TR><TD align='right' valign='top'>
<A href='#top'><IMG src='gfx/top.gif' border='0' valign='bottom' ALT='Top of the page'></A>
</TD><TR>

<TR><TD>
<CENTER>
<HR noshade width='500' size='1' color='#666666'>
";
include("inc/menuBottom.php");
} else {
	echo "<P class='Big'>BRAK UPRAWNIEN!</P>";
}
echo "
<BR>
<B class='Stopka'>Copyright &copy; 2006 by Lukasz Golaszewski</B>
</CENTER>
</TD></TR></TABLE>
</CENTER>
";
end_html();
?>