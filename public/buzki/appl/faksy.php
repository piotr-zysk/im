<?php

$admin_skill=30;  //id from table LISTA_SKILL

$superusers=array("1","474","543","569");

include("../../lib/tww.inc");

//skad przybywam i gdzie jestem
$url=$_SERVER['QUERY_STRING'];
$url_from_caly=$_SERVER['HTTP_REFERER'];
$url_from_pociety=explode("?", $url_from_caly);
$url_from=$url_from_pociety[1];
//print("aktualny: $url<br>przychodze z: $url_from");

//poziom uprawnien
$xmbid=$_COOKIE["xmbid"];
$xmblevel=$_COOKIE["xmblevel"];

//poczatek strony
echo "
<HTML><HEAD>
<TITLE>faksy</TITLE>
	<meta name=\"robots\" content=\"index, follow\">
	<META HTTP-EQUIV=\"content-type\" CONTENT=\"text/html; charset=iso-8859-2\">
	<meta http-equiv=\"Content-Language\" content=\"pl\">
	<meta http-equiv=\"pragma\" content=\"no-cache\">
	<base target=\"_self\">
	<link rel=\"stylesheet\" type=\"text/css\" href='css/main3.css'>

	<script language=\"javascript\" src=\"./lib/choosedate.js\"></script>
	<link rel=\"stylesheet\" type=\"text/css\" href=\"lalamido/css/calendar.css\">
	

</HEAD>
<BODY>
<CENTER>
<TABLE class='title_table' WIDTH=90%>
<TR><TD><IMG SRC=./faksy/fax.jpg><B>ODEBRANE FAKSY</B><IMG SRC=./faksy/fax.jpg></TD></TR>
</TABLE>
";

//edytowanie w tabeli


	
if (!$xmbid) {
		echo "<BR><H2><FONT color=red>Aby korzystac z aplikacji, musisz byc zalogowany w intranecie, z odpowiednim poziomem uprawnien!</FONT></H2>";
	} 
else {

	// sprawdzenie czy user posiada admin_skill
	$query1 = $db->query("SELECT IDSkillPracownik FROM SkillPracownik WHERE IDListaSkill=$admin_skill AND IDPracownik=$xmbid");
	if ($member = $db->fetch_array($query1)) 
		{
			$is_admin='admin';
		}
	else
		{
			$is_admin='';
			if (!$action) $action='wyszuk';
		}
	
	
	if ((!$action) and ($is_admin))
		{
			echo "
			<TABLE class='title_table' WIDTH=90%>
			<TR><TD><B>
			<CENTER>
			<H1><A HREF=$PHP_SELF?action=wyszuk>Wyszukiwarka</A></H1>
			<H1><A HREF=$PHP_SELF?action=dodaj>Dodawanie wpisow</A></H1>
			<H1><A HREF=$PHP_SELF?action=edit>Edycja statusow aktywacji</A></H1>
			</CENTER>
			</B></TD></TR>
			</TABLE>
			";
		}
	elseif ($action=='wyszuk')
		{
			echo "
			<TABLE class='title_table' WIDTH=90%>
			<TR><TD><B>
			<CENTER>";
			include("./faksy/wyszuk.php");
			echo "
			</CENTER>
			</B></TD></TR>
			</TABLE>";

		}
	elseif ($action=='dodaj')
		{
			echo "
			<TABLE class='title_table' WIDTH=90%>
			<TR><TD><B>
			<CENTER>";
			include("./faksy/dodaj.php");
			echo "
			</CENTER>
			</B></TD></TR>
			</TABLE>";
		}
	elseif ($action=='edit')
		{
			echo "
			<TABLE class='title_table' WIDTH=90%>
			<TR><TD><B>
			<CENTER>";
			include("./faksy/edit.php");
			echo "
			</CENTER>
			</B></TD></TR>
			</TABLE>";	
		}


	

echo "
	</TD></TR>
	<TR></TD><TD>
	<p class='podpis'>by TWW Poland</p>
	</TD></TR></TABLE>
	</CENTER>
";

}

end_html();
?>